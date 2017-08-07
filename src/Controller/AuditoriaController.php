<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class AuditoriaController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $this->set('title', ' Auditoria do Sistema');
        $this->set('icon', 'fingerprint');
    }

    public function detalhe(int $id)
    {
        
    }
}