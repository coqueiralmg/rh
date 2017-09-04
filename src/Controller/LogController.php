<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class LogController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->validationRole = false;
        $this->configurarAcesso();
        $this->controlAuth();
        $this->carregarDadosSistema();
    }

    public function index()
    {
        $t_auditoria = TableRegistry::get('Auditoria');
        $limite_paginacao = Configure::read('Pagination.limit');

        $conditions = [
            'usuario' =>  $this->request->session()->read('UsuarioID'),
            'ocorrencia' => 1
        ];

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $conditions,
            'order' => [
                'data' => 'DESC'
            ]
        ];

        $log = $this->paginate($t_auditoria);
        $quantidade = $t_auditoria->find('all', ['conditions' => $conditions])->count();
        
        $this->set('title', 'Log de Acesso');
        $this->set('icon', 'receipt');
        $this->set('log', $log);
        $this->set('qtd_total', $quantidade);
        $this->set('limit_pagination', $limite_paginacao);
    }

    public function imprimir()
    {
        $t_auditoria = TableRegistry::get('Auditoria');

        $conditions = [
            'usuario' =>  $this->request->session()->read('UsuarioID'),
            'ocorrencia' => 1
        ];

        $log = $t_auditoria->find('all', [
            'conditions' => $conditions,
            'order' => [
                'data' => 'DESC'
            ]
        ]);

        $quantidade = $t_auditoria->find('all', ['conditions' => $conditions])->count();

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão de seu próprio log de acesso.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Log de Acesso');
        $this->set('log', $log);
        $this->set('qtd_total', $quantidade);
    }
}