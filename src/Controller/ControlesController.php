<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class ControlesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $this->set('title', 'Controles');
        $this->set('icon', 'gamepad');
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
        $title = ($id > 0) ? 'Edição do Controle' : 'Novo Controle';
        $icon = 'gamepad';

        $this->set('title', $title);
        $this->set('icon', $icon);
    }

}