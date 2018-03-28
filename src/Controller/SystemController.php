<?php

namespace App\Controller;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use \DateInterval;
use \DateTime;

class SystemController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->validationRole = false;
        $this->configurarAcesso();
    }

    public function login()
    {
        if ($this->request->session()->check('Usuario')) {
            if (!$this->request->session()->read('UsuarioSuspeito')) {
                $idUsuario = $this->request->session()->read('UsuarioID');
                $t_usuario = TableRegistry::get('Usuario');

                $query = $t_usuario->find('all', [
                    'contain' => ['GrupoUsuario'],
                    'conditions' => [
                        'Usuario.id' => $idUsuario
                    ]
                ]);

                if ($query->count() > 0) {
                    $usuario = $query->first();
                    $this->validarLogin($usuario);
                } else {
                    $this->atualizarTentativas('Os dados estão inválidos');
                }
            } else {
                $this->request->session()->destroy();
                $this->redirectLogin("Efetue o login no sistema.", false);
            }
        } else {
            $login = $this->obterLoginCookie();
            $this->viewBuilder()->layout('guest');
            $this->configurarTentativas();

            $this->set('title', 'Controle de Acesso');
            $this->set('login', $login);
        }
    }

    public function logon()
    {
        if ($this->request->is('post')) {
            $login = $this->request->data['usuario'];
            $senha = $this->request->data['senha'];

            if ($login == '' || $senha == '') {
                $this->redirectLogin('É obrigatório informar o login e a senha.');
            } else {
                $this->Cookie->write('login_user', $login);
                $t_usuario = TableRegistry::get('Usuario');

                $query = $t_usuario->find('all', [
                    'contain' => ['GrupoUsuario'],
                    'conditions' => [
                        'Usuario.usuario' => $login
                    ]
                ])->orWhere([
                    'Usuario.email' => $login
                ]);

                if ($query->count() > 0) {
                    $usuario = $query->first();
                    $this->validarLogin($usuario, $senha);
                } else {
                    $this->atualizarTentativas('Os dados estão inválidos');
                }
            }
        }
    }

    public function logoff()
    {
        $usuario =  $this->request->session()->read('Usuario');
        
        $auditoria = [
            'ocorrencia' => 8,
            'descricao' => 'O usuário efetuou o logoff no sistema.',
            'usuario' => $usuario->id
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito')) {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->request->session()->destroy();
        $this->redirectLogin("Você saiu do sistema.", false);
    }

    public function password()
    {
        if ($this->request->is('post')) {
            $idUsuario = $this->request->data['idUsuario'];
            $senha = $this->request->data['senha'];

            $t_usuario = TableRegistry::get('Usuario');
            $usuario = $t_usuario->get($idUsuario);

            $usuario->senha = sha1($senha);
            $usuario->verificar = false;

            $t_usuario->save($usuario);

            $auditoria = [
                'ocorrencia' => 2,
                'descricao' => 'O usuário trocou a senha, por ter sido obrigado a efetuar a troca.',
                'usuario' => $usuario->id
            ];

            $this->Auditoria->registrar($auditoria);

            $this->redirectLogin('Sua senha foi alterada com sucesso.', false);
        } else {
            $idUsuario = $this->request->session()->read('UsuarioID');
            $this->request->session()->destroy();
            
            $this->viewBuilder()->layout('guest');
            $this->set('title', 'Troca de Senha');
            $this->set('idUsuario', $idUsuario);
        }
    }

    public function board()
    {
        $this->controlAuth();
        $this->carregarDadosSistema();

        $data_inicial = new DateTime();
        $data_inicial->sub(new DateInterval("P1Y"));

        $data_final = new DateTime();

        $t_funcionarios = TableRegistry::get('Funcionario');
        $t_empresas = TableRegistry::get('Empresa');
        $t_atestados = TableRegistry::get('Atestado');
        $t_medicos = TableRegistry::get('Medico');

        $funcionarios = $t_funcionarios->find('all')->count();
        $empresas = $t_empresas->find('all')->count();
        
        $medicos = $t_medicos->find('all')->count();

        $atestados = $t_atestados->find('all', [
            'conditions' => [
                'emissao >=' => $data_inicial->format("Y-m-d"),
                'emissao <=' => $data_final->format("Y-m-d"),
            ]
        ])->count();

        $inss = $t_atestados->find('all', [
            'conditions' => [
                'emissao >=' => $data_inicial->format("Y-m-d"),
                'emissao <=' => $data_final->format("Y-m-d"),
                'inss' => true
            ]
        ])->count();

        $relatorio_funcionarios = $t_funcionarios->find('all', [
            'contain' => ['Empresa']
        ]);

        $relatorio_funcionarios->select([
            'Empresa.id',
            'Empresa.nome',
            'quantidade' => $relatorio_funcionarios->func()->count('*')
        ])->group('Empresa.id')->order([
            'quantidade' => 'DESC'
        ]);

        $relatorio_atestados = $t_atestados->find('all', [
            'contain' => ['Funcionario' => ['Empresa']],
            'conditions' => [
                'emissao >=' => $data_inicial->format("Y-m-d"),
                'emissao <=' => $data_final->format("Y-m-d"),
            ]
        ]);

        $relatorio_atestados->select([
            'nome' => 'Empresa.nome',
            'quantidade' => $relatorio_atestados->func()->count('*')
        ])->group('Empresa.id')->order([
            'quantidade' => 'DESC'
        ]);

        $top_funcionarios = $t_atestados->find('all', [
            'contain' => ['Funcionario'],
            'conditions' => [
                'Funcionario.ativo' => true,
                'Atestado.emissao >=' => $data_inicial->format("Y-m-d"),
                'Atestado.emissao <=' => $data_final->format("Y-m-d")
            ]
        ]);

        $top_funcionarios->select([
            'id' => 'Funcionario.id',
            'matricula' => 'Funcionario.matricula',
            'nome' => 'Funcionario.nome',
            'quantidade' => $top_funcionarios->func()->count('*')
        ])->group('Funcionario.id')->order([
            'quantidade' => 'DESC',
            'nome' => 'ASC'
        ])->limit(10);

        $top_cid = $t_atestados->find('all', [
            'contain' => ['Doenca'],
            'conditions' => [
                'Doenca.detalhamento IS' => null,
                'Atestado.emissao >=' => $data_inicial->format("Y-m-d"),
                'Atestado.emissao <=' => $data_final->format("Y-m-d")
            ]
        ]);

        $top_cid->select([
            'codigo' => 'Atestado.cid',
            'nome' => 'Doenca.nome',
            'quantidade' => $top_cid->func()->count('*')
        ])->group('Atestado.cid')->order([
            'quantidade' => 'DESC',
            'Atestado.cid' => 'ASC'
        ])->limit(10);

        $this->set('title', 'Sistema de Gerenciamento de Recursos Humanos');
        $this->set('icon', 'dashboard');
        $this->set('funcionarios', $funcionarios);
        $this->set('empresas', $empresas);
        $this->set('atestados', $atestados);
        $this->set('inss', $inss);
        $this->set('medicos', $medicos);
        $this->set('relatorio_funcionarios', $relatorio_funcionarios);
        $this->set('relatorio_atestados', $relatorio_atestados);
        $this->set('top_funcionarios', $top_funcionarios);
        $this->set('top_cid', $top_cid);
    }

    public function fail(string $mensagem)
    {
        $this->viewBuilder()->layout('guest');
        $this->set('title', 'Acesso Indisponível');
        $this->set('mensagem', base64_decode($mensagem));
    }

    public function block(string $chave)
    {
        $this->viewBuilder()->layout('guest');
        
        $chave = base64_decode($chave);
        $valores = json_decode($chave);
        
        $login = $valores->login;
        $ip = $valores->ip;
        $usuario = null;

        $this->Firewall->bloquear('Bloqueado pelo administrador, por motivo de atividades suspeitas', $ip);

        $t_usuario = TableRegistry::get('Usuario');
        
        $query = $t_usuario->find('all', [
            'conditions' => [
                'Usuario.usuario' => $login
            ]
        ])->orWhere([
            'Usuario.email' => $login
        ]);

        if ($query->count() > 0) {
            $usuario = $query->first();
        }

        $auditoria = [
            'ocorrencia' => 3,
            'descricao' => 'O administrador do sistema bloqueou o endereço de IP ' . $ip . ' através do link de e-mail, por motivos de atividades suspeitas',
            'usuario' => null
        ];

        $this->Auditoria->registrar($auditoria);

        $this->set('title', 'Bloquear Acesso');
        $this->set('ip', $ip);
        $this->set('login', $login);
        $this->set('usuario', $usuario);
    }

    public function suspend(int $idUsuario)
    {
        $t_usuario = TableRegistry::get('Usuario');
        
        $usuario = $t_usuario->get($idUsuario);

        $usuario->suspenso = true;

        $t_usuario->save($usuario);
        $this->Monitoria->alertarContaSuspensa($usuario->nome, $usuario->email, true);

        $auditoria = [
            'ocorrencia' => 4,
            'descricao' => 'O administrador do sistema decidiu suspender a conta ' . $usuario->usuario . ', devido a esta conta ser usada para atividades suspeitas.',
            'usuario' => null
        ];

        $this->Auditoria->registrar($auditoria);

        $this->redirectLogin('O usuário ' . $usuario->usuario . ' encontra-se suspenso. O mesmo foi notificado por e-mail.', false);
    }

    public function reset()
    {
        $auditoria = [
            'ocorrencia' => 5,
            'descricao' => 'Feita a limpeza de cache e de sessão.',
            'usuario' => null
        ];

        $this->Auditoria->registrar($auditoria);
        
        $this->request->session()->destroy();
        Cache::clear(false);
        $this->redirectLogin("As sessões foram zeradas com sucesso.", false);
    }

    protected function configurarTentativas()
    {
        if (!$this->request->session()->check('LoginAttemps')) {
            $this->request->session()->write('LoginAttemps', 0);
        }
    }

    protected function atualizarTentativas(string $mensagem)
    {
        $tentativa = $this->request->session()->read('LoginAttemps');
        $aviso = Configure::read('Security.login.attemps.warning');
        $limite = Configure::read('Security.login.attemps.max');
        $this->request->session()->write('LoginAttemps', $tentativa + 1);

        if ($tentativa >= $aviso && $tentativa < $limite) {
            $auditoria = [
                'ocorrencia' => 6,
                'descricao' => 'O usuário tem tentado acessar o sistema por ' . $aviso . ' ou mais vezes.',
                'usuario' => null
            ];

            $this->Auditoria->registrar($auditoria);
            
            $this->Monitoria->alertarTentativasIntermitentes();
            $this->redirectLogin('Você tentou o acesso ' . $tentativa . ' vezes. Caso você tente ' . $limite . ' vezes sem sucesso, você será bloqueado.');
        } elseif ($tentativa >= $limite) {
            $auditoria = [
                'ocorrencia' => 7,
                'descricao' => 'O usuário foi bloqueado pelo sistema automaticamente, por muitas tentativas de acesso sem sucesso.',
                'usuario' => null
            ];

            $this->Auditoria->registrar($auditoria);
            
            $this->Monitoria->alertarUsuarioBloqueado();
            $this->bloquearAcesso();
            $this->redirectLogin('O acesso ao sistema encontra-se bloqueado.');
        } else {
            $this->redirectLogin($mensagem);
        }
    }

    protected function bloquearAcesso()
    {
        $login = $this->Cookie->read('login_user');
        $t_usuario = TableRegistry::get('Usuario');

        $query = $t_usuario->find('all', [
            'conditions' => [
                'Usuario.usuario' => $login
            ]
        ])->orWhere([
            'Usuario.email' => $login
        ]);

        if ($query->count() > 0) {
            $resultado = $query->all();

            foreach ($resultado as $usuario) {
                $usuario->suspenso = true;
                $t_usuario->save($usuario);
                $this->Monitoria->alertarContaSuspensa($usuario->nome, $usuario->email);
            }
        }

        $this->Firewall->bloquear('Tentativas de acesso indevidos.');
    }

    protected function obterLoginCookie()
    {
        $login = "";

        if ($this->Cookie->check('login_user')) {
            $login = $this->Cookie->read('login_user');
        }
        
        return $login;
    }

    protected function validarLogin($usuario, $senha = '')
    {
        if (!$usuario->ativo) 
        {
            $this->redirectLogin("O usuário encontra-se inativo para o sistema.");
            return;
        }

        if ($usuario->suspenso) 
        {
            $this->redirectLogin("O usuário encontra-se suspenso no sistema. Favor entrar em contato com o administrador do sistema.");
            return;
        }

        if (!$usuario->grupoUsuario->ativo) 
        {
            $this->redirectLogin("O usuário encontra-se em um grupo de usuário inativo.");
            return;
        }

        if ($senha != '') 
        {
            if ($usuario->senha != sha1($senha)) 
            {
                $this->atualizarTentativas('A senha informada é inválida.');
                return;
            }
        }

        if ($usuario->verificar) 
        {
            $this->request->session()->write('UsuarioID', $usuario->id);
            $this->Flash->success('Por favor, troque a senha.');
            $this->redirect(['controller' => 'system', 'action' => 'password']);
            return;
        }

        if ($senha != '') 
        {
            $this->request->session()->write('Usuario', $usuario);
            $this->request->session()->write('UsuarioID', $usuario->id);
            $this->request->session()->write('UsuarioNick', $usuario->usuario);
            $this->request->session()->write('UsuarioNome', $usuario->nome);
            $this->request->session()->write('UsuarioEmail', $usuario->email);
        }

        $auditoria = [
            'ocorrencia' => 1,
            'descricao' => 'O usuário acessou o sistema com sucesso.',
            'usuario' => $usuario->id
        ];

        $this->Auditoria->registrar($auditoria);
        $this->request->session()->write('UsuarioEntrada', date("Y-m-d H:i:s"));

        if ($senha != '') 
        {
            $tentativa = $this->request->session()->read('LoginAttemps');

            if ($tentativa >= Configure::read('Security.login.attemps.warning')) 
            {
                $this->request->session()->write('UsuarioSuspeito', true);
                $this->Monitoria->monitorar($auditoria);
            } 
            else 
            {
                $this->request->session()->write('UsuarioSuspeito', false);
            }
        }

        $this->redirect(['controller' => 'system', 'action' => 'board']);
    }
}
