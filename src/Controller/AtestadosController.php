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
            $atestado = $t_atestado->get($id);
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
}