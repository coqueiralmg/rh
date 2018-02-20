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
            $detalhamento = $this->request->query('detalhamento');
            $nome = $this->request->query('nome');

            if($codigo != "")
            {
                $condicoes['codigo'] = $codigo;

                if($detalhamento != "")
                {
                    $condicoes['detalhamento'] = $detalhamento;
                }
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
                'codigo' => 'ASC',
                'detalhamento' => 'ASC'
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

    public function imprimir()
    {
        $t_cid = TableRegistry::get('Cid');
        
        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 1)
        {
            $codigo = $this->request->query('codigo');
            $detalhamento = $this->request->query('detalhamento');
            $nome = $this->request->query('nome');

            if($codigo != "")
            {
                $condicoes['codigo'] = $codigo;

                if($detalhamento != "")
                {
                    $condicoes['detalhamento'] = $detalhamento;
                }
            }

            if($nome != "")
            {
                $condicoes['nome LIKE'] = '%' . $nome . '%';
                
            }
        }

        $itens = $t_cid->find('all', [
            'conditions' => $condicoes
        ]);

        $qtd_total = $itens->count();

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Tabela de CID');
        $this->set('itens', $itens);
        $this->set('qtd_total', $qtd_total);
    }

    public function add()
    {
        $this->redirect(['action' => 'cadastro', 0]);
    }

    public function addc()
    {
        $this->redirect(['action' => 'insercao', 0]);
    }

    public function edit(int $id)
    {
        $this->redirect(['action' => 'cadastro', $id]);
    }

    public function view(int $id)
    {
        $this->redirect(['action' => 'consulta', $id]);
    }

    public function cadastro(int $id)
    {
        $title = ($id > 0) ? 'Edição de CID' : 'Novo CID';

        $t_cid = TableRegistry::get('Cid');

        if ($id > 0) 
        {
            $cid = $t_cid->get($id);
            $this->set('cid', $cid);
        }
        else
        {
            $this->set('cid', null);
        }

        $this->set('title', $title);
        $this->set('icon', 'grid_on');
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

    public function delete(int $id)
    {
        try
        {
            $t_cid = TableRegistry::get('Cid');

            $marcado = $t_cid->get($id);
            $codigo = $marcado->cid;

            $propriedades = $marcado->getOriginalValues();

            $t_cid->delete($marcado);

            $this->Flash->greatSuccess('O CID ' . $codigo . ' foi excluído com sucesso!');

            $auditoria = [
                'ocorrencia' => 38,
                'descricao' => 'O usuário excluiu um determinado CID do sistema.',
                'dado_adicional' => json_encode(['cid_excluido' => $id, 'dados_cid_excluido' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if ($this->request->session()->read('UsuarioSuspeito')) 
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'index']);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao excluir o CID.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'index']);
        }
    }

    protected function insert()
    {
        try 
        {
            $t_cid = TableRegistry::get('Cid');
            $entity = $t_cid->newEntity($this->request->data());
            
            if($entity->detalhamento === "")
            {
                $entity->detalhamento = null;
            }
           
            $qcid = $t_cid->find('all', [
                'conditions' => [
                    'codigo' => $entity->codigo,
                    'detalhamento' => $entity->detalhamento
                ]
            ])->count();
           
            
            if($qcid > 0)
            {
                throw new Exception("Existe um CID com o código informado e detalhamento cadastrado.");
            }

            $t_cid->save($entity);
            
            $this->Flash->greatSuccess('O CID foi salvo com sucesso');
            
            $propriedades = $entity->getOriginalValues();
            
            $auditoria = [
                'ocorrencia' => 35,
                'descricao' => 'O usuário fez o cadastro simples de CID.',
                'dado_adicional' => json_encode(['id_novo_cid' => $entity->id, 'campos' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if ($this->request->session()->read('UsuarioSuspeito')) 
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $entity->id]);
        } 
        catch (Exception $ex) 
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o CID', [
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
            $t_cid = TableRegistry::get('Cid');
            $entity = $t_cid->get($id);

            $t_cid->patchEntity($entity, $this->request->data());

            if($entity->detalhamento === "")
            {
                $entity->detalhamento = null;
            }
            
            $qcid = $t_cid->find('all', [
                'conditions' => [
                    'codigo' => $entity->codigo,
                    'detalhamento' => $entity->detalhamento
                ]
            ])->count();
           
            
            if($qcid > 0)
            {
                throw new Exception("Existe um CID com o código informado e detalhamento cadastrado.");
            }

            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_cid->save($entity);

            $this->Flash->greatSuccess('O CID foi salvo com sucesso');

            $auditoria = [
                'ocorrencia' => 37,
                'descricao' => 'O usuário modificou os dados de um determinado CID.',
                'dado_adicional' => json_encode(['cid_modificado' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if ($this->request->session()->read('UsuarioSuspeito')) 
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $id]);
        } 
        catch (Exception $ex) 
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o CID', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', $id]);
        }
    }
}