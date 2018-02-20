<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Cid extends Entity
{
    protected function _getCid()
    {
        $subitem = $this->_properties['subitem'];
        $codigo = $this->_properties['codigo'];
        $detalhamento = $this->_properties['detalhamento'];

        return ($subitem) ? $codigo . '.' . $detalhamento : $codigo;
    }
}