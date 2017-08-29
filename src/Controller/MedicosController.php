<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use \Exception;

class MedicosController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_medicos = TableRegistry::get('Medico');

        $limite_paginacao = Configure::read('Pagination.limit');
        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 1)
        {
            $nome = $this->request->query('nome');
            $crm = $this->request->query('crm');
            
            if($nome != "")
            {
                $condicoes['nome LIKE'] = '%' . $nome . '%';
            }

            if($crm != "")
            {
                $condicoes['crm'] = $crm;
            }

            $data['nome'] = $nome;
            $data['crm'] = $crm;

            $this->request->data = $data;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes,
            'order' => [
                'nome' => 'ASC'
            ]
        ];

        $medicos = $this->paginate($t_medicos);
        $qtd_total = $t_medicos->find('all', [
            'conditions' => $condicoes
        ])->count();

        $opcao_paginacao = [
            'name' => 'médicos',
            'name_singular' => 'médico'
        ];

        $this->set('title', 'Médicos');
        $this->set('icon', 'face');
        $this->set('opcao_paginacao', $opcao_paginacao);
        $this->set('medicos', $medicos);
        $this->set('qtd_total', $qtd_total);
        $this->set('data', $data);
    }

    public function imprimir()
    {
        $t_medicos = TableRegistry::get('Medico');
        
        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 1)
        {
            $nome = $this->request->query('nome');
            $crm = $this->request->query('crm');
            
            if($nome != "")
            {
                $condicoes['nome LIKE'] = '%' . $nome . '%';
            }

            if($crm != "")
            {
                $condicoes['crm'] = $crm;
            }
        }

        $medicos = $t_medicos->find('all', [
            'conditions' => $condicoes
        ]);

        $qtd_total = $medicos->count();

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Médicos');
        $this->set('medicos', $medicos);
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
        
    }

    public function append()
    {
        if ($this->request->is('ajax'))
        {
            $t_medicos = TableRegistry::get('Medico');
           
            $this->autoRender = false;
            $mensagem = null;
            $sucesso = false;
            $entity = $t_medicos->newEntity($this->request->data());

            $entity->nome = $this->request->query("nome");
            $entity->crm = $this->request->query("crm");
            $entity->especialidade = $this->request->query("especialidade");

            if($entity->crm != '')
            {
                $qcrm = $t_medicos->find('all', [
                    'conditions' => [
                        'crm' => $entity->crm
                    ]
                ])->count();
                
                if($qcrm > 0)
                {
                    $mensagem = 'Existe um médico com o CRM selecionado';
                }
            }
            else
            {
                $entity->crm = null;
            }
            
            $t_medicos->save($entity);
            $mensagem = 'O médico foi salvo com sucesso!';
            $sucesso = true;

            $propriedades = $entity->getOriginalValues();

            $auditoria = [
                'ocorrencia' => 24,
                'descricao' => 'O usuário cadastrou o novo médico via formulário flutuante na tela de atestados.',
                'dado_adicional' => json_encode(['id_novo_medico' => $entity->id, 'campos' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if ($this->request->session()->read('UsuarioSuspeito')) {
                $this->Monitoria->monitorar($auditoria);
            }

            $retorno = [
                'sucesso' => $sucesso,
                'mensagem' => $mensagem
            ];

            echo json_encode($retorno);
        }
    }

    public function listar() 
    {
        if ($this->request->is('ajax'))
        {
            $t_medicos = TableRegistry::get('Medico');

            $this->autoRender = false;
            $nome = $this->request->query("nome");

            $medicos = $t_medicos->find('all', [
                'conditions' => [
                    'nome LIKE' => '%' . $nome . '%',
                ]
            ]);

            echo json_encode($medicos);
        }
    }
}