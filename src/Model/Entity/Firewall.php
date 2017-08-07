<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Firewall extends Entity
{
    protected function _getWhitelist()
    {
        return $this->_properties['lista_branca'] ? 'Sim' : 'Não';
    }

    protected function _getBloqueiaSite()
    {
        return $this->_properties['site'] ? 'Sim' : 'Não';
    }

    protected function _getAtivado()
    {
        return $this->_properties['ativo'] ? 'Sim' : 'Não';
    }
}    