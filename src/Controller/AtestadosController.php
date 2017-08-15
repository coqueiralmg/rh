<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


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
            'contain' => ['Funcionario'],
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

        $this->set('title', 'Atestados');
        $this->set('icon', 'local_hospital');
        $this->set('opcao_paginacao', $opcao_paginacao);
        $this->set('atestados', $atestados);
        $this->set('qtd_total', $qtd_total);
        $this->set('tipos_funcionarios', $tipos_funcionarios);
        $this->set('data', $data);
    }

    public function imprimir()
    {
        
    }
}