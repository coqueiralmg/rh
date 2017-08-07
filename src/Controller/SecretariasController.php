<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class SecretariasController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $this->set('title', 'Secretarias');
        $this->set('icon', 'business_center');
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
        $title = ($id > 0) ? 'Edição da Secretaria' : 'Nova Secretaria';
        $icon = ($id > 0) ? 'business_center' : 'business_center';

        $this->set('title', $title);
        $this->set('icon', $icon);
    }

}