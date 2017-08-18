<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Atestado extends Entity
{
    protected function _getAfastado()
    {
        return $this->_properties['inss'] ? 'Sim' : 'Não';
    }
}