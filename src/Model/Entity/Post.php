<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Text;


class Post extends Entity
{
    protected function _getSlug()
    {
        $titulo = $this->_properties['titulo'];
        $procurar = array(' ', 'ã', 'à', 'á', 'â', 'é', 'ê', 'í', 'ì', 'ó', 'ò', 'õ', 'ô', 'ú', 'ù', 'û', 'ç', ',', '.', '!', '?', ';', '/');
        $substituir = array('_', 'a', 'a', 'a', 'a', 'e', 'e', 'i', 'i', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'c', '', '', '', '', '', '_');
        
        return strtolower(str_replace($procurar, $substituir, $titulo));
    }
}