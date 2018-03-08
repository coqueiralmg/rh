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

    public function view(int $id)
    {
        $this->redirect(['action' => 'consulta', $id]);
    }

    public function cadastro(int $id)
    {
        $title = ($id > 0) ? 'Edição de Médico' : 'Novo Médico';
        $icon = 'face';

        $t_medicos = TableRegistry::get('Medico');

        if ($id > 0) 
        {
            $medico = $t_medicos->get($id);
            $this->set('medico', $medico);
        }
        else
        {
            $this->set('medico', null);
        }

        $this->set('title', $title);
        $this->set('icon', $icon);
        $this->set('id', $id);
    }

    public function consulta(int $id)
    {
        $title = 'Consulta de Dados do Médico';
        $icon = 'face';

        $t_medicos = TableRegistry::get('Medico');
        $medico = $t_medicos->get($id);

        $this->set('title', $title);
        $this->set('icon', $icon);
        $this->set('id', $id);
        $this->set('medico', $medico);
    }

    public function documento(int $id)
    {
        $t_medicos = TableRegistry::get('Medico');
        $medico = $t_medicos->get($id);
        $propriedades = $medico->getOriginalValues();
        
        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão de um determinado funcionário.',
            'dado_adicional' => json_encode(['registro_impresso' => $id, 'dados_registro' => $propriedades]),
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);
        
        if ($this->request->session()->read('UsuarioSuspeito')) {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');
        
        $this->set('title', 'Dados do Médico');
        $this->set('medico', $medico);
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
            $t_medicos = TableRegistry::get('Medico');
            $t_atestado = TableRegistry::get('Atestado');

            $marcado = $t_medicos->get($id);
            $nome = $marcado->nome;

            $qtd = $t_atestado->find('all', [
                'medico' => $id
            ])->count();

            if($qtd > 0)
            {
                throw new Exception("Existem atestados cadastrados para este médico. Será preciso fazer exclusão dos atestados primeiramente, antes de excluir este médico.");
            }

            $propriedades = $marcado->getOriginalValues();

            $t_medicos->delete($marcado);

            $this->Flash->greatSuccess('O médico ' . $nome . ' foi excluído com sucesso!');

            $auditoria = [
                'ocorrencia' => 26,
                'descricao' => 'O usuário excluiu um determinado médico do sistema.',
                'dado_adicional' => json_encode(['medico_excluido' => $id, 'dados_medico_excluido' => $propriedades]),
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
            $this->Flash->exception('Ocorreu um erro no sistema ao excluir o médico.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'index']);
        }
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
                    $mensagem = 'Existe um médico com o CRM informado.';
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

            $this->response->header('Content-Type', 'application/json');
            echo json_encode($medicos);
        }
    }

    protected function insert()
    {
        try 
        {
            $t_medicos = TableRegistry::get('Medico');

            $entity = $t_medicos->newEntity($this->request->data());

            if($entity->crm != '')
            {
                $qcrm = $t_medicos->find('all', [
                    'conditions' => [
                        'crm' => $entity->crm
                    ]
                ])->count();
                
                if($qcrm > 0)
                {
                    throw new Exception("Existe um médico com o CRM informado.");
                }
            }
            else
            {
                $entity->crm = null;
            }

            $t_medicos->save($entity);
            
            $this->Flash->greatSuccess('O médico foi salvo com sucesso');
            
            $propriedades = $entity->getOriginalValues();
            
            $auditoria = [
                'ocorrencia' => 24,
                'descricao' => 'O usuário cadastrou o novo médico via formulário de cadastro de médicos.',
                'dado_adicional' => json_encode(['id_novo_medico' => $entity->id, 'campos' => $propriedades]),
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
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o médico', [
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
            $t_medicos = TableRegistry::get('Medico');
            $entity = $t_medicos->get($id);

            $t_medicos->patchEntity($entity, $this->request->data());
            
            if($entity->crm != '')
            {
                $qcrm = $t_medicos->find('all', [
                    'conditions' => [
                        'crm' => $entity->crm,
                        'id <>' => $id
                    ]
                ])->count();
                
                if($qcrm > 0)
                {
                    throw new Exception("Existe um médico com o CRM informado.");
                }
            }
            else
            {
                $entity->crm = null;
            }

            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_medicos->save($entity);

            $this->Flash->greatSuccess('O médico foi salvo com sucesso');

            $auditoria = [
                'ocorrencia' => 25,
                'descricao' => 'O usuário modificou os dados de um determinado médico.',
                'dado_adicional' => json_encode(['medico_modificado' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
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
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o médico', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', $id]);
        }
    }
}