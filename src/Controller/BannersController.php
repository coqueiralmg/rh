<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class BannersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $this->set('title', 'Banners');
        $this->set('icon', 'slideshow');
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
        $title = ($id > 0) ? 'Edição do Banner' : 'Nova Banner';
        $icon = ($id > 0) ? 'slideshow' : 'slideshow';

        $this->set('title', $title);
        $this->set('icon', $icon);
    }

}