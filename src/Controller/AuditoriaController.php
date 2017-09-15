<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class AuditoriaController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_auditoria = TableRegistry::get('Auditoria');
        $t_usuarios = TableRegistry::get('Usuario');

        $limite_paginacao = Configure::read('Pagination.limit');
        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $responsavel = $this->request->query('responsavel');
            $ocorrencia = $this->request->query('ocorrencia');
            $data_inicial = $this->request->query('data_inicial');
            $data_final = $this->request->query('data_final');
            $ip = $this->request->query('ip');
            
            if($responsavel != '')
            {
                $condicoes['Usuario.id'] = $responsavel;
            }

            if($ocorrencia != '')
            {
                $condicoes['ocorrencia'] = $ocorrencia;
            }

            if($data_inicial != "" && $data_final != "")
            {
                $condicoes["data >="] = $this->Format->formatDateDB($data_inicial);
                $condicoes["data <="] = $this->Format->formatDateDB($data_final);
            }

            if($ip != '')
            {
                $condicoes['ip'] = $ip;
            }

            $data['responsavel'] = $responsavel;
            $data['ocorrencia'] = $ocorrencia;
            $data['data_inicial'] = $data_inicial;
            $data['data_final'] = $data_final;
            $data['ip'] = $ip;

            $this->request->data = $data;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'contain' => ['Usuario'],
            'conditions' => $condicoes,
            'order' => [
                'data' => 'DESC'
            ]
        ];

        $trilha = $this->paginate($t_auditoria);
        $total = $t_auditoria->find('all', ['contain' => ['Usuario'], 'conditions' => $condicoes])->count();

        $usuarios = $t_usuarios->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome'
        ]);

        $ocorrencias = $this->Auditoria->obterOcorrencias();
        
        $this->set('title', ' Auditoria do Sistema');
        $this->set('icon', 'fingerprint');
        $this->set('auditoria', $trilha);
        $this->set('qtd_total', $total);
        $this->set('data', $data);
        $this->set('usuarios', $usuarios);
        $this->set('ocorrencias', $ocorrencias);
    }

    public function detalhe(int $id)
    {
        
    }
}