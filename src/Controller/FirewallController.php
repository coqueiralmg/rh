<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use \Exception;

class FirewallController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_firewall = TableRegistry::get('Firewall');

        $limite_paginacao = Configure::read('Pagination.limit');
        $condicoes = array();
        $data = array();
        
        if(count($this->request->getQueryParams()) > 3)
        {
            $mostrar = $this->request->query('mostrar');

            if($mostrar != 'T')
            {
                $condicoes["lista_branca"] = ($mostrar == "B") ? "1" : "0";
            }

            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }
        
        $combo_mostra = ["T" => "Todos", "N" => "Lista Negra", "B" => "Lista Branca"];

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes
        ];

        $firewall = $this->paginate($t_firewall);
        $qtd_total = $t_firewall->find('all', ['conditions' => $condicoes])->count();
        
        $this->set('title', 'Firewall');
        $this->set('icon', 'security');
        $this->set('combo_mostra', $combo_mostra);
        $this->set('firewall', $firewall);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('data', $data);
    }

    public function imprimir()
    {
        $t_firewall = TableRegistry::get('Firewall');

        $condicoes = array();
        
        if(count($this->request->getQueryParams()) > 0)
        {
            $mostrar = $this->request->query('mostrar');

            if($mostrar != 'T')
            {
                $condicoes["lista_branca"] = ($mostrar == "B") ? "1" : "0";
            }
        }

        $firewall = $t_firewall->find('all', ['conditions' => $condicoes]);
        $qtd_total = $firewall->count();

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão da lista de IPs cadastrados no Firewall.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }
        
        $this->viewBuilder()->layout('print');

        $this->set('title', 'Firewall');
        $this->set('firewall', $firewall);
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
        $title = ($id > 0) ? 'Editar Registro do Firewall' : 'Novo Registro do Firewall';
        $icon = 'security';

        $t_firewall = TableRegistry::get('Firewall');

        $tipo_lista = array();

        if($id > 0)
        {
            $firewall = $t_firewall->get($id);

            $tipo_lista = [
                ['value' => 'N', 'text' => 'Lista Negra', 'style' => 'margin-left:5px;', 'checked' => (!$firewall->lista_branca)],
                ['value' => 'B', 'text' => 'Lista Branca', 'style' => 'margin-left:15px;', 'checked' => ($firewall->lista_branca)]
            ];

            $this->set('firewall', $firewall);
        }
        else
        {
            $tipo_lista = [
                ['value' => 'N', 'text' => 'Lista Negra', 'style' => 'margin-left:5px;'],
                ['value' => 'B', 'text' => 'Lista Branca', 'style' => 'margin-left:15px;']
            ];
            
            $this->set('firewall', null);
        }

        $this->set('title', $title);
        $this->set('icon', $icon);
        $this->set('id', $id);
        $this->set('tipo_lista', $tipo_lista);
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
            $t_firewall = TableRegistry::get('Firewall');
            $marcado = $t_firewall->get($id);
            $ip = $marcado->ip;
            $propriedades = $marcado->getOriginalValues();

            $t_firewall->delete($marcado);

            $this->Flash->greatSuccess('O registro para o endereço de IP ' . $ip . ' foi excluído com sucesso!');

            $auditoria = [
                'ocorrencia' => 19,
                'descricao' => 'O usuário excluiu um registro do firewall.',
                'dado_adicional' => json_encode(['dado_excluido' => $id, 'dados_registro_excluido' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['controller' => 'firewall', 'action' => 'index']);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao excluir o registro.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['controller' => 'firewall', 'action' => 'index']);
        }
    }

    protected function insert()
    {
        try
        {
            $t_firewall = TableRegistry::get('Firewall');

            $entity = $t_firewall->newEntity($this->request->data());
            $entity->data = date("Y-m-d H:i:s");
            $entity->lista_branca = ($entity->tipo_lista == 'B');

            $t_firewall->save($entity);
            $this->Flash->greatSuccess('Registro salvo com sucesso');

            $propriedades = $entity->getOriginalValues();
            $auditoria = array();

            if($entity->tipo_lista == 'N')
            {
                $auditoria = [
                    'ocorrencia' => 16,
                    'descricao' => 'O usuário criou um novo registro de firewall lista negra.',
                    'dado_adicional' => json_encode(['id_novo_usuario' => $entity->id, 'campos' => $propriedades]),
                    'usuario' => $this->request->session()->read('UsuarioID')
                ];
            }
            elseif($entity->tipo_lista == 'B')
            {
                $auditoria = [
                    'ocorrencia' => 17,
                    'descricao' => 'O usuário criou um novo registro de firewall lista branca.',
                    'dado_adicional' => json_encode(['id_novo_usuario' => $entity->id, 'campos' => $propriedades]),
                    'usuario' => $this->request->session()->read('UsuarioID')
                ];
            }

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['controller' => 'firewall', 'action' => 'cadastro', $entity->id]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o registro.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['controller' => 'firewall', 'action' => 'cadastro', 0]);
        }
    }

    protected function update(int $id)
    {
       try
       {
            $t_firewall = TableRegistry::get('Firewall');
            $entity = $t_firewall->get($id);

            $t_firewall->patchEntity($entity, $this->request->data());

            $entity->lista_branca = ($entity->tipo_lista == 'B');

            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_firewall->save($entity);
            $this->Flash->greatSuccess('Registro salvo com sucesso');

            $auditoria = [
                'ocorrencia' => 18,
                'descricao' => 'O usuário editou um registro do firewall.',
                'dado_adicional' => json_encode(['usuario_modificado' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['controller' => 'firewall', 'action' => 'cadastro', $id]);
       }
       catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o registro.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['controller' => 'firewall', 'action' => 'cadastro', $id]);
        }
    }
}