<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Core\Configure;

class AuditoriaHelper extends Helper
{
    /**
    * Busca o nome da ocorrência da auditoria por código
    * @param int Código da ocorrência
    * @return string Nome da ocorrência pré-cadastrada na lista
    */
    public function buscarNomeOcorrencia(int $codigo)
    {
        $ocorrencias = Configure::read('Auditoria.ocorrencias');
        return $ocorrencias[$codigo];
    }

    /**
    * Obtém todas as ocorrências pré definidas do código
    * @return array Coletânea de todas as ocorrências pré definidas
    */
    public function obterOcorrencias()
    {
        $ocorrencias = Configure::read('Auditoria.ocorrencias');
        return $ocorrencias;
    }
}