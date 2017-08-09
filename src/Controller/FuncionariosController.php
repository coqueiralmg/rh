<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;

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
}
