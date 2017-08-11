<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use \Exception;

class FuncionariosController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_funcionarios = TableRegistry::get('Funcionario');
        $t_tipo_funcionario = TableRegistry::get('TipoFuncionario');

        $limite_paginacao = Configure::read('Pagination.limit');
        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 3)
        {

        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'contain' => ['TipoFuncionario'],
            'conditions' => $condicoes
        ];

        $funcionarios = $this->paginate($t_funcionarios);
        $qtd_total = $t_funcionarios->find('all', [
            'conditions' => $condicoes
        ])->count();

        $opcao_paginacao = [
            'name' => 'funcionários',
            'name_singular' => 'funcionário'
        ];

        $combo_mostra = [
            'T' => 'Todos', 
            'A' => 'Somente ativos', 
            'I' => 'Somente inativos',
            'E' => 'Somente funcionários em estágio probatório'
        ];

        $tipos_funcionarios = $t_tipo_funcionario->find('list', [
            'keyField' => 'id',
            'valueField' => 'descricao'
        ]);
        
        $this->set('title', 'Funcionários');
        $this->set('icon', 'work');
        $this->set('opcao_paginacao', $opcao_paginacao);
        $this->set('combo_mostra', $combo_mostra);
        $this->set('funcionarios', $funcionarios);
        $this->set('qtd_total', $qtd_total);
        $this->set('tipos_funcionarios', $tipos_funcionarios);
        $this->set('data', $data);
    }

    public function imprimir()
    {
        $this->set('title', 'Funcionários');
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
        $title = ($id > 0) ? 'Edição de Funcionário' : 'Novo Funcionário';
        $icon = 'work';

        $t_funcionarios = TableRegistry::get('Funcionario');
        $t_tipo_funcionario = TableRegistry::get('TipoFuncionario');

        $tipos_funcionarios = $t_tipo_funcionario->find('list', [
            'keyField' => 'id',
            'valueField' => 'descricao'
        ]);

        if ($id > 0) 
        {
            $funcionario = $t_funcionarios->get($id);
            $this->set('funcionario', $funcionario);
        } 
        else 
        {
            $this->set('funcionario', null);
        }

        $this->set('title', $title);
        $this->set('icon', $icon);
        $this->set('id', $id);
        $this->set('tipos_funcionarios', $tipos_funcionarios);
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
            $t_funcionarios = TableRegistry::get('Funcionario');
            $entity = $t_funcionarios->newEntity($this->request->data());

            $qcpf = $t_funcionarios->find('all', [
                'conditions' => [
                    'cpf' => $this->Format->clearMask($entity->cpf)
                ]
            ])->count();

            if($qcpf > 0)
            {
                throw new Exception("Existe um funcionário com CPF informado.");
            }
            
            if($entity->pis != '')
            {
                $qpis = $t_funcionarios->find('all', [
                    'conditions' => [
                        'pis' => $entity->pis
                    ]
                ])->count();

                if($qpis > 0)
                {
                    throw new Exception("Existe um funcionário com PIS informado.");
                }
            }
            else
            {
                $entity->pis = null;
            }

            $entity->data_admissao = $this->Format->formatDateDB($entity->data_admissao);
            $entity->cpf = $this->Format->clearMask($entity->cpf);
            $entity->tipo = $this->request->getData('tipo');

            $t_funcionarios->save($entity);
            $this->Flash->greatSuccess('Funcionário salvo com sucesso');

            $propriedades = $entity->getOriginalValues();

            $auditoria = [
                'ocorrencia' => 21,
                'descricao' => 'O usuário criou um novo usuário.',
                'dado_adicional' => json_encode(['id_novo_usuario' => $entity->id, 'campos' => $propriedades]),
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
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o funcionário', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', 0]);
        }
    }

    protected function update(int $id)
    {

    }
}
