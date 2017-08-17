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
        $t_medicos = TableRegistry::get('Medico');
        
        if ($this->request->is('ajax'))
        {
            $this->autoRender = false;
            $mensagem = null;
            $entity = $t_medicos->newEntity($this->request->data());

            if($entity->crm != '')
            {
                $qcrm = $t_medicos->find('all', [
                    'conditions' => [
                        'crm' => $entity->crm
                    ]
                ])->count();
                
                if($qcrm > 0)
                {
                    $mensagem = 'Existe um médico com o CRM selecionado';
                }
            }
            else
            {
                $entity->crm = null;
            }
            

            
        }
        else
        {

        }
    }
}