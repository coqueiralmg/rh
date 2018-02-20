<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use \Exception;

class CidController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_cid = TableRegistry::get('Cid');

        $limite_paginacao = Configure::read('Pagination.limit');
        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 1)
        {
            $codigo = $this->request->query('codigo');
            $nome = $this->request->query('nome');

            if($codigo != "")
            {
                $condicoes['codigo'] = $codigo;
            }

            if($nome != "")
            {
                $condicoes['nome LIKE'] = '%' . $nome . '%';
                
            }

            $data['codigo'] = $codigo;
            $data['nome'] = $nome;
            
            $this->request->data = $data;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes,
            'order' => [
                'nome' => 'ASC'
            ]
        ];

        $itens = $this->paginate($t_cid);

        $qtd_total = $t_cid->find('all', [
            'conditions' => $condicoes
        ])->count();

        $this->set('title', 'CID');
        $this->set('icon', 'grid_on');
        $this->set('itens', $itens);
        $this->set('qtd_total', $qtd_total);
        $this->set('data', $data);
    }
}