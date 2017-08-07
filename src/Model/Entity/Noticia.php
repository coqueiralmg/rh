<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Noticia extends Entity
{
    protected function _getResumo()
    {
        $limiteCaracteres = 250;
        $texto = $this->_properties['texto'];
        $texto = strip_tags($texto);
        $reticences = "";

        if (strlen($texto) > $limiteCaracteres){
            $reticences = "...";
            $limite = substr($texto, 0, $limiteCaracteres);
            $posicaoString = strrpos($limite, " ");
            $cortaTexto = ($posicaoString > 0) ? $posicaoString : strlen($limite);
            $texto = substr($limite, 0, $cortaTexto);
        }

        return $texto . $reticences;
    }

    protected function _getParte()
    {
        $limiteCaracteres = 500;
        $texto = $this->_properties['texto'];
        $texto = strip_tags($texto);
        $reticences = "";

        if (strlen($texto) > $limiteCaracteres){
            $reticences = "...";
            $limite = substr($texto, 0, $limiteCaracteres);
            $posicaoString = strrpos($limite, " ");
            $cortaTexto = ($posicaoString > 0) ? $posicaoString : strlen($limite);
            $texto = substr($limite, 0, $cortaTexto);
        }

        return $texto . $reticences;
    }

    protected function _getRaw()
    {
        $texto = $this->_properties['texto'];

        return strip_tags($texto);
    }
}