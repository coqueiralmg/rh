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
}