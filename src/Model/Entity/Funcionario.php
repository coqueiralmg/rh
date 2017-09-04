<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Funcionario extends Entity
{
    protected function _getAtivado()
    {
        return $this->_properties['ativo'] ? 'Sim' : 'Não';
    }

    protected function _getEstagio()
    {
        return $this->_properties['probatorio'] ? 'Sim' : 'Não';
    }
}