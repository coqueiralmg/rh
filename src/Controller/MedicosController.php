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
        
    }

    public function imprimir()
    {
        
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

    public function insert()
    {
        
    }
}