<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Filesystem\File;
use Cake\Log\Log;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use Cake\Utility\Xml;
use \Exception;

class RelatoriosController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_usuarios = TableRegistry::get('Usuario');
        $t_funcionarios = TableRegistry::get('Funcionario');
        $t_atestados = TableRegistry::get('Atestado');
        $t_medicos = TableRegistry::get('Medico');

        $usuarios = $t_usuarios->find('all')->count();
        $funcionarios = $t_funcionarios->find('all')->count();
        $atestados = $t_atestados->find('all')->count();
        $medicos = $t_medicos->find('all')->count();
        
        $this->set('title', 'Visão Geral dos Relatórios');
        $this->set('icon', 'library_books');
        $this->set('usuarios', $usuarios);
        $this->set('funcionarios', $funcionarios);
        $this->set('atestados', $atestados);
        $this->set('medicos', $medicos);
    }
}