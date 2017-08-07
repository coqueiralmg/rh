<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use \Exception;

class PublicacoesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_publicacao = TableRegistry::get('Publicacao');
        $limite_paginacao = Configure::read('limitPagination');

        $condicoes = array();
        $data = array();

        if(count($this->request->getQueryParams()) > 0)
        {
            $numero = $this->request->query('numero');
            $titulo = $this->request->query('titulo');
            $data_inicial = $this->request->query('data_inicial');
            $data_final = $this->request->query('data_final');
            $mostrar = $this->request->query('mostrar');

            $condicoes['numero LIKE'] = '%' . $numero . '%';
            $condicoes['titulo LIKE'] = '%' . $titulo . '%';

            if($data_inicial != "" && $data_final != "")
            {
                $condicoes["data >="] = $this->Format->formatDateDB($data_inicial);
                $condicoes["data <="] = $this->Format->formatDateDB($data_final);
            }

            if($mostrar != 'T')
            {
                $condicoes["ativo"] = ($mostrar == "A") ? "1" : "0";
            }

            $data['numero'] = $numero;
            $data['titulo'] = $titulo;
            $data['data_inicial'] = $data_inicial;
            $data['data_final'] = $data_final;
            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes,
            'order' => [
                'data' => 'DESC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'publicações',
            'name_singular' => 'publicação',
            'predicate' => 'encontradas',
            'singular' => 'encontrada'
        ];

        $publicacoes = $this->paginate($t_publicacao);

        $qtd_total = $t_publicacao->find('all', [
            'conditions' => $condicoes]
        )->count();

        $combo_mostra = ["T" => "Todos", "A" => "Somente ativos", "I" => "Somente inativos"];
        
        $this->set('title', 'Publicações');
        $this->set('icon', 'library_books');
        $this->set('combo_mostra', $combo_mostra);
        $this->set('publicacoes', $publicacoes);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
        $this->set('data', $data);
    }

    public function imprimir()
    {
        $t_publicacao = TableRegistry::get('Publicacao');

        $condicoes = array();

        if(count($this->request->getQueryParams()) > 0)
        {
            $numero = $this->request->query('numero');
            $titulo = $this->request->query('titulo');
            $data_inicial = $this->request->query('data_inicial');
            $data_final = $this->request->query('data_final');
            $mostrar = $this->request->query('mostrar');

            $condicoes['numero LIKE'] = '%' . $numero . '%';
            $condicoes['titulo LIKE'] = '%' . $titulo . '%';

            if($data_inicial != "" && $data_final != "")
            {
                $condicoes["data >="] = $this->Format->formatDateDB($data_inicial);
                $condicoes["data <="] = $this->Format->formatDateDB($data_final);
            }

            if($mostrar != 'T')
            {
                $condicoes["ativo"] = ($mostrar == "A") ? "1" : "0";
            }
        }

        $publicacoes = $t_publicacao->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'data' => 'DESC'
            ]
        ]);

        $qtd_total = $publicacoes->count();

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão da lista de publicações.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Publicações');
        $this->set('publicacoes', $publicacoes);
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
        $title = ($id > 0) ? 'Edição da Publicação' : 'Nova Publicação';
        $icon = ($id > 0) ? 'group' : 'group_add';

        $t_publicacao = TableRegistry::get('Publicacao');

        if($id > 0)
        {
            $publicacao = $t_publicacao->get($id);
            
            $this->set('publicacao', $publicacao);
        }
        else
        {
            $this->set('publicacao', null);
        }

        $this->set('title', $title);
        $this->set('icon', $icon);
        $this->set('id', $id);
    }

}