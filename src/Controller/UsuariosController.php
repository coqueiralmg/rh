<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use \Exception;

class UsuariosController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_usuarios = TableRegistry::get('Usuario');
        $t_grupos = TableRegistry::get('GrupoUsuario');

        $limite_paginacao = Configure::read('Pagination.limit');
        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 3) 
        {
            $nome = $this->request->query('nome');
            $usuario = $this->request->query('usuario');
            $email = $this->request->query('email');
            $grupo = $this->request->query('grupo');
            $mostrar = $this->request->query('mostrar');

            $condicoes['Usuario.nome LIKE'] = '%' . $nome . '%';
            $condicoes['Usuario.usuario LIKE'] = '%' . $usuario . '%';
            $condicoes['Usuario.email LIKE'] = '%' . $email . '%';

            if ($grupo != "") 
            {
                $condicoes['Usuario.grupo'] = $grupo;
            }

            if ($mostrar != 'T') 
            {
                $condicoes["Usuario.ativo"] = ($mostrar == "A") ? "1" : "0";
            }

            $data['nome'] = $nome;
            $data['usuario'] = $usuario;
            $data['email'] = $email;
            $data['grupo'] = $grupo;
            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'contain' => ['GrupoUsuario'],
            'conditions' => $condicoes
        ];

        $opcao_paginacao = [
            'name' => 'usuários',
            'name_singular' => 'usuário'
        ];

        $usuarios = $this->paginate($t_usuarios);
        $qtd_total = $t_usuarios->find('all', [
            'conditions' => $condicoes]
            )->count();

        $combo_mostra = ["T" => "Todos", "A" => "Somente ativos", "I" => "Somente inativos"];
        
        $grupos = $t_grupos->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'conditions' => [
                'ativo' => true
            ]
        ]);

        $this->set('title', 'Lista de Usuários');
        $this->set('icon', 'person');
        $this->set('grupos', $grupos);
        $this->set('combo_mostra', $combo_mostra);
        $this->set('usuarios', $usuarios);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
        $this->set('data', $data);
    }

    public function imprimir()
    {
        $t_usuarios = TableRegistry::get('Usuario');
        
        $condicoes = array();
        
        if (count($this->request->getQueryParams()) > 0) 
        {
            $nome = $this->request->query('nome');
            $usuario = $this->request->query('usuario');
            $email = $this->request->query('email');
            $grupo = $this->request->query('grupo');
            $mostrar = $this->request->query('mostrar');

            $condicoes['Usuario.nome LIKE'] = '%' . $nome . '%';
            $condicoes['Usuario.usuario LIKE'] = '%' . $usuario . '%';
            $condicoes['Usuario.email LIKE'] = '%' . $email . '%';

            if ($grupo != "") 
            {
                $condicoes['Usuario.grupo'] = $grupo;
            }

            if ($mostrar != 'T') 
            {
                $condicoes["Usuario.ativo"] = ($mostrar == "A") ? "1" : "0";
            }

            $data['nome'] = $nome;
            $data['usuario'] = $usuario;
            $data['email'] = $email;
            $data['grupo'] = $grupo;
            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }

        $usuarios = $t_usuarios->find('all', [
            'contain' => ['GrupoUsuario'],
            'conditions' => $condicoes
        ]);

        $qtd_total = $usuarios->count();

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão da lista de usuários.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito')) {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Lista de Usuários');
        $this->set('usuarios', $usuarios);
        $this->set('qtd_total', $qtd_total);
    }

    public function add()
    {
        $this->redirect(['action' => 'cadastro', 0]);
    }

    public function edit(int $id)
    {
        $t_usuarios = TableRegistry::get('Usuario');
        $pivot = $t_usuarios->get($id);

        if ($pivot->suspenso) 
        {
             $this->Flash->greatWarning('Este usuário encontra-se suspenso para acessar ao sistema. Para que ele volte a acessar o sistema, clique no botão liberar.');
        }
        
        $this->redirect(['action' => 'cadastro', $id]);
    }

    public function cadastro(int $id)
    {
        $title = ($id > 0) ? 'Edição de Usuário' : 'Novo Usuário';
        $icon = ($id > 0) ? 'person_outline' : 'person_add';

        $t_usuarios = TableRegistry::get('Usuario');
        $t_grupos = TableRegistry::get('GrupoUsuario');

        $grupos = $t_grupos->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'conditions' => [
                'ativo' => true
            ]
        ]);

        if ($id > 0) 
        {
            $usuario = $t_usuarios->get($id);

            $this->set('usuario', $usuario);
        } 
        else 
        {
            $this->set('usuario', null);
        }

        $this->set('title', $title);
        $this->set('icon', $icon);
        $this->set('id', $id);
        $this->set('grupos', $grupos);
    }

    public function save(int $id)
    {
        if ($this->request->is('post')) {
            $this->insert();
        } elseif ($this->request->is('put')) {
            $this->update($id);
        }
    }

    public function delete(int $id)
    {
        try {
            $usuarios = TableRegistry::get('Usuario');

            $exclui_auditoria = $this->request->query('auditoria');

            $marcado = $usuarios->get($id);
            $nome = $marcado->nome;
            $propriedades = $marcado->getOriginalValues();

            $qa = $this->Auditoria->quantidade($id);

            if ($qa > 0) {
                if ($exclui_auditoria) {
                    $this->Auditoria->limpar($id);
                } else {
                    throw new Exception('Este usuário não pode ser excluído, porque tem o registro de auditoria. Verifique a tabela de auditoria antes de excluir definitivamente ou deixe-o inativo.');
                }
            }

            $usuarios->delete($marcado);

            $this->Flash->greatSuccess('O usuário ' . $nome . ' foi excluído com sucesso!');

            $auditoria = [
                'ocorrencia' => 12,
                'descricao' => 'O usuário excluiu um determinado usuário do sistema.',
                'dado_adicional' => json_encode(['usuario_excluido' => $id, 'dados_usuario_excluido' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if ($this->request->session()->read('UsuarioSuspeito')) {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['controller' => 'usuarios', 'action' => 'index']);
        } catch (Exception $ex) {
            $this->Flash->exception('Ocorreu um erro no sistema ao excluir o usuário', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['controller' => 'usuarios', 'action' => 'index']);
        }
    }

    public function liberar(int $id)
    {
        $usuarios = TableRegistry::get('Usuario');
        $usuario = $usuarios->get($id);

        $usuario->suspenso = false;
        $usuario->verificar = true;
        $usuario->ativo = true;

        $usuarios->save($usuario);

        $this->Flash->greatSuccess('Liberado com sucesso o acesso do usuário ao sistema. Recomendamos deixar que o usuário troque sua senha no próximo acesso.');

        $propriedades = $usuario->getOriginalValues();

        $auditoria = [
            'ocorrencia' => 20,
            'descricao' => 'O administrador do sistema liberou um determinado usuário para o acesso ao sistema, a qual estava suspenso.',
            'dado_adicional' => json_encode(['usuario_liberado' => $id, 'dados_usuario' => $propriedades]),
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito')) {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->redirect(['controller' => 'usuarios', 'action' => 'cadastro', $id]);
    }

    protected function insert()
    {
        $usuarios = TableRegistry::get('Usuario');

        $entity = $usuarios->newEntity($this->request->data());
        
        $entity->senha = sha1($entity->senha);
        $entity->suspenso = false;

        try 
        {
            $qtd = $usuarios->find('all', [
                'conditions' => [
                    'usuario' => $entity->usuario
                ]
            ])->count();

            if ($qtd > 0) {
                throw new Exception("Existe um usuário com o login escolhido.");
            }

            $propriedades = $entity->getOriginalValues();

            $usuarios->save($entity);
            $this->Flash->greatSuccess('Usuário salvo com sucesso');

            $auditoria = [
                'ocorrencia' => 10,
                'descricao' => 'O usuário criou um novo usuário.',
                'dado_adicional' => json_encode(['id_novo_usuario' => $entity->id, 'campos' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if ($this->request->session()->read('UsuarioSuspeito')) {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['controller' => 'usuarios', 'action' => 'cadastro', $entity->id]);
        } 
        catch (Exception $ex) 
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o usuário', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['controller' => 'usuarios', 'action' => 'cadastro', 0]);
        }
    }

    protected function update(int $id)
    {
        $usuarios = TableRegistry::get('Usuario');
        $entity = $usuarios->get($id);
        $senha_antiga = $entity->senha;

        $usuarios->patchEntity($entity, $this->request->data());

        if ($entity->mudasenha == 'true') 
        {
            $entity->senha = sha1($entity->senha);
        }
        else 
        {
            $entity->senha = $senha_antiga;
        }

        try 
        {
            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $usuarios->save($entity);
            $this->Flash->greatSuccess('Usuário salvo com sucesso');

            $auditoria = [
                'ocorrencia' => 11,
                'descricao' => 'O usuário modificou os dados de um determinado usuário.',
                'dado_adicional' => json_encode(['usuario_modificado' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if ($this->request->session()->read('UsuarioSuspeito')) {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->request->session()->delete('USER_FUNCTIONS');
            $this->redirect(['controller' => 'usuarios', 'action' => 'cadastro', $id]);
        } 
        catch (Exception $ex) 
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o usuário', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['controller' => 'usuarios', 'action' => 'cadastro', $id]);
        }
    }
}
