<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class LegislacaoController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $this->set('title', 'Legislação');
        $this->set('icon', 'location_city');
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
        $title = ($id > 0) ? 'Edição da Legislação' : 'Nova Legislação';
        $icon = 'location_city';

        $this->set('title', $title);
        $this->set('icon', $icon);
    }

    public function categorias()
    {
        $this->set('title', 'Categorias da Legislação');
        $this->set('icon', 'storage');
    }

    public function categoria(int $id)
    {
        $title = ($id > 0) ? 'Edição da Categoria da Legislação' : 'Nova Categoria da Legislação';
        $icon = 'storage';

        $this->set('title', $title);
        $this->set('icon', $icon);
    }

}