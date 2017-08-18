<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use \Exception;

class AtestadosController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_atestados = TableRegistry::get('Atestado');
        $t_tipo_funcionario = TableRegistry::get('TipoFuncionario');

        $limite_paginacao = Configure::read('Pagination.limit');
        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $funcionario = $this->request->query('funcionario');
            $medico = $this->request->query('medico');
            $cid = $this->request->query('cid');
            $emissao_inicial = $this->request->query('emissao_inicial');
            $emissao_final = $this->request->query('emissao_final');
            $afastamento_inicial = $this->request->query('afastamento_inicial');
            $afastamento_final = $this->request->query('afastamento_final');
            $tipo_funcionario = $this->request->query('tipo_funcionario');
            $mostrar = $this->request->query('mostrar');

            $condicoes['Funcionario.nome LIKE'] = '%' . $funcionario . '%';
            $condicoes['Medico.nome LIKE'] = '%' . $medico . '%';

            if($cid != '')
            {
                $condicoes['Atestado.cid'] = $cid;
            }

            if($cid != '')
            {
                $condicoes['Atestado.cid'] = $cid;
            }

            if($emissao_inicial != "" && $emissao_final != "")
            {
                $condicoes["Atestado.emissao >="] = $this->Format->formatDateDB($emissao_inicial);
                $condicoes["Atestado.emissao <="] = $this->Format->formatDateDB($emissao_final);
            }

            if($afastamento_inicial != "" && $afastamento_final != "")
            {
                $condicoes["Atestado.afastamento >="] = $this->Format->formatDateDB($afastamento_inicial);
                $condicoes["Atestado.afastamento <="] = $this->Format->formatDateDB($afastamento_final);
            }
            
            if($tipo_funcionario != "")
            {
                $condicoes["Funcionario.tipo"] = $tipo_funcionario;
            }

            if($mostrar == 'E')
            {
                $condicoes['Funcionario.probatorio'] = true;
            }
            else
            {
                if ($mostrar != 'T') 
                {
                    $condicoes["Funcionario.ativo"] = ($mostrar == "A") ? "1" : "0";
                }
            }

            $data['funcionario'] = $funcionario;
            $data['medico'] = $medico;
            $data['cid'] = $cid;
            $data['emissao_inicial'] = $emissao_inicial;
            $data['emissao_final'] = $emissao_final;
            $data['afastamento_inicial'] = $afastamento_inicial;
            $data['afastamento_final'] = $afastamento_final;
            $data['tipo_funcionario'] = $tipo_funcionario;
            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'contain' => ['Funcionario', 'Medico'],
            'conditions' => $condicoes,
            'order' => [
                'afastamento' => 'DESC'
            ]
        ];

        $atestados = $this->paginate($t_atestados);
        $qtd_total = $t_atestados->find('all', [
            'contain' => ['Funcionario', 'Medico'],
            'conditions' => $condicoes
            
        ])->count();

        $opcao_paginacao = [
            'name' => 'atestados',
            'name_singular' => 'atestado'
        ];

        $tipos_funcionarios = $t_tipo_funcionario->find('list', [
            'keyField' => 'id',
            'valueField' => 'descricao'
        ]);

        $combo_mostra = [
            'T' => 'Atestados de todos os funcionários', 
            'A' => 'Somente atestados de funcionários ativos', 
            'I' => 'Somente atestados de funcionários inativos',
            'E' => 'Somente atestados de funcionários em estágio probatório'
        ];

        $this->set('title', 'Atestados');
        $this->set('icon', 'local_hospital');
        $this->set('opcao_paginacao', $opcao_paginacao);
        $this->set('atestados', $atestados);
        $this->set('qtd_total', $qtd_total);
        $this->set('tipos_funcionarios', $tipos_funcionarios);
        $this->set('combo_mostra', $combo_mostra);
        $this->set('data', $data);
    }

    public function imprimir()
    {
        $t_atestados = TableRegistry::get('Atestado');
        $condicoes = array();

        if (count($this->request->getQueryParams()) > 0)
        {
            $funcionario = $this->request->query('funcionario');
            $medico = $this->request->query('medico');
            $cid = $this->request->query('cid');
            $emissao_inicial = $this->request->query('emissao_inicial');
            $emissao_final = $this->request->query('emissao_final');
            $afastamento_inicial = $this->request->query('afastamento_inicial');
            $afastamento_final = $this->request->query('afastamento_final');
            $tipo_funcionario = $this->request->query('tipo_funcionario');
            $mostrar = $this->request->query('mostrar');

            $condicoes['Funcionario.nome LIKE'] = '%' . $funcionario . '%';
            $condicoes['Medico.nome LIKE'] = '%' . $medico . '%';

            if($cid != '')
            {
                $condicoes['Atestado.cid'] = $cid;
            }

            if($cid != '')
            {
                $condicoes['Atestado.cid'] = $cid;
            }

            if($emissao_inicial != "" && $emissao_final != "")
            {
                $condicoes["Atestado.emissao >="] = $this->Format->formatDateDB($emissao_inicial);
                $condicoes["Atestado.emissao <="] = $this->Format->formatDateDB($emissao_final);
            }

            if($afastamento_inicial != "" && $afastamento_final != "")
            {
                $condicoes["Atestado.afastamento >="] = $this->Format->formatDateDB($afastamento_inicial);
                $condicoes["Atestado.afastamento <="] = $this->Format->formatDateDB($afastamento_final);
            }
            
            if($tipo_funcionario != "")
            {
                $condicoes["Funcionario.tipo"] = $tipo_funcionario;
            }

            if($mostrar == 'E')
            {
                $condicoes['Funcionario.probatorio'] = true;
            }
            else
            {
                if ($mostrar != 'T') 
                {
                    $condicoes["Funcionario.ativo"] = ($mostrar == "A") ? "1" : "0";
                }
            }
        }

        $atestados = $t_atestados->find('all', [
            'contain' => ['Funcionario', 'Medico'],
            'conditions' => $condicoes,
            'order' => [
                'afastamento' => 'DESC'
            ]
        ]);

        $qtd_total = $atestados->count();

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão da lista de atestados.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito')) {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');
        
        $this->set('title', 'Atestados');
        $this->set('atestados', $atestados);
        $this->set('qtd_total', $qtd_total);
    }

    public function add()
    {
        $this->redirect(['action' => 'cadastro', 0]);
    }

    public function edit(int $id)
    {
        $this->redirect(['action' => 'cadastro', $id]);
    }

    public function cadastro(int $id)
    {
        $title = ($id > 0) ? 'Edição de Atestado' : 'Novo Atestado';
        $icon = 'local_hospital';

        $t_atestado = TableRegistry::get('Atestado');

        if ($id > 0) 
        {
            $t_funcionarios = TableRegistry::get('Funcionario');
            $t_medicos = TableRegistry::get('Medico');

            $atestado = $t_atestado->get($id);

            $funcionario = $t_funcionarios->get($atestado->funcionario);
            $medico = $t_medicos->get($atestado->medico);

            $atestado->nome_funcionario = $funcionario->nome;
            $atestado->nome_medico = $medico->nome;

            $this->set('atestado', $atestado);
        } 
        else 
        {
            $this->set('atestado', null);
        }

        $this->set('title', $title);
        $this->set('icon', $icon);
        $this->set('id', $id);
    }

    public function save(int $id)
    {
        if ($this->request->is('post'))
        {
            $this->insert();
        }
        else if($this->request->is('put'))
        {
            $this->update($id);
        }
    }

    protected function insert()
    {
        try 
        {
            $t_atestado = TableRegistry::get('Atestado');
            $entity = $t_atestado->newEntity($this->request->data());

            $entity->emissao = $this->Format->formatDateDB($entity->emissao);
            $entity->afastamento = $this->Format->formatDateDB($entity->afastamento);
            $entity->retorno = $this->Format->formatDateDB($entity->retorno);
            $entity->funcionario = $this->request->getData('funcionario');
            $entity->medico = $this->request->getData('medico');

            $t_atestado->save($entity);
            $this->Flash->greatSuccess('Atestado salvo com sucesso');

            $propriedades = $entity->getOriginalValues();
            
            $auditoria = [
                'ocorrencia' => 27,
                'descricao' => 'O usuário cadastrou o novo atestado.',
                'dado_adicional' => json_encode(['id_novo_atestado' => $entity->id, 'campos' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if ($this->request->session()->read('UsuarioSuspeito')) {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $entity->id]);
        } 
        catch (Exception $ex) 
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o atestado', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', 0]);
        }
    }

    protected function update(int $id)
    {
        try 
        {
            $t_atestado = TableRegistry::get('Atestado');
            
            $entity = $t_atestado->get($id);

            $t_atestado->patchEntity($entity, $this->request->data());

            $entity->emissao = $this->Format->formatDateDB($entity->emissao);
            $entity->afastamento = $this->Format->formatDateDB($entity->afastamento);
            $entity->retorno = $this->Format->formatDateDB($entity->retorno);
            $entity->funcionario = $this->request->getData('funcionario');
            $entity->medico = $this->request->getData('medico');

            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_atestado->save($entity);
            $this->Flash->greatSuccess('Atestado salvo com sucesso');
            
            $auditoria = [
                'ocorrencia' => 28,
                'descricao' => 'O usuário modificou as informações do atestado.',
                'dado_adicional' => json_encode(['atestado_modificado' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if ($this->request->session()->read('UsuarioSuspeito')) {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $entity->id]);
        } 
        catch (Exception $ex) 
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o atestado', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', $id]);
        }  
    }
}