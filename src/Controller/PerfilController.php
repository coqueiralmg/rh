<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class PerfilController extends AppController
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
        $t_usuarios = TableRegistry::get('Usuario');
        $usuario = $t_usuarios->get($this->request->session()->read('UsuarioID'), ['contain' => ['GrupoUsuario']]);
        
        $this->set('title', 'Perfil de Usuário');
        $this->set('icon', 'account_box');
        $this->set('usuario', $usuario);
    }

    public function edicao()
    {
        $t_usuarios = TableRegistry::get('Usuario');
        $t_grupos = TableRegistry::get('GrupoUsuario');
        $id = $this->request->session()->read('UsuarioID');

        $usuario = $t_usuarios->get($id);

        $grupos = $t_grupos->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'conditions' => [
                'ativo' => true
            ]
        ]);

        $this->set('title', 'Edição de Perfil');
        $this->set('icon', 'account_box');
        $this->set('usuario', $usuario);
        $this->set('grupos', $grupos);
        $this->set('id', $id);
    }

    public function senha()
    {
        $t_usuarios = TableRegistry::get('Usuario');
        $id = $this->request->session()->read('UsuarioID');
        
        $usuario = $t_usuarios->get($id);

        if ($this->request->is('put')) 
        {
            $t_usuarios->patchEntity($usuario, $this->request->data());

            $usuario->senha = sha1($usuario->nova);

            $propriedades = $this->Auditoria->changedOriginalFields($usuario);
            $modificadas = $this->Auditoria->changedFields($usuario, $propriedades);

            $t_usuarios->save($usuario);
            $this->Flash->greatSuccess('A senha foi modificada com sucesso.');

            $auditoria = [
                'ocorrencia' => 31,
                'descricao' => 'O usuário modificou sua própria senha.',
                'dado_adicional' => json_encode(['usuario_modificado' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if ($this->request->session()->read('UsuarioSuspeito')) 
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['controller' => 'perfil', 'action' => 'index']);
        }
        else
        {
            $this->set('title', 'Mudança de Senha');
            $this->set('icon', 'vpn_key');
            $this->set('usuario', $usuario);
            $this->set('id', $id);
        }
    }

    public function save(int $id)
    {
        if ($this->request->is('put')) 
        {
            try 
            {
                $usuarios = TableRegistry::get('Usuario');
                $entity = $usuarios->get($id);

                $usuarios->patchEntity($entity, $this->request->data());

                $propriedades = $this->Auditoria->changedOriginalFields($entity);
                $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

                $usuarios->save($entity);
                $this->Flash->greatSuccess('Dados salvos com sucesso');

                $auditoria = [
                    'ocorrencia' => 30,
                    'descricao' => 'O usuário modificou seus próprios dados.',
                    'dado_adicional' => json_encode(['usuario_modificado' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                    'usuario' => $this->request->session()->read('UsuarioID')
                ];
    
                $this->Auditoria->registrar($auditoria);
    
                if ($this->request->session()->read('UsuarioSuspeito')) 
                {
                    $this->Monitoria->monitorar($auditoria);
                }
    
                $this->redirect(['controller' => 'perfil', 'action' => 'edicao']);
            } 
            catch (Exception $ex) 
            {
                $this->Flash->exception('Ocorreu um erro no sistema ao salvar seus dados de usuário', [
                    'params' => [
                        'details' => $ex->getMessage()
                    ]
                ]);

                $this->redirect(['controller' => 'perfil', 'action' => 'edicao']);
            }
        }
    }
}