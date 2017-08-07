<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

/**
 * Classe que representa o componente de acesso e bloqueio ao sistema, a partir de uma determinada máquina (Firewall).
 * @package App\Controller\Component
 */
class FirewallComponent extends Component
{
    /**
     * Bloqueia um determinado endereço de IP do sistema
     *
     * @param string $motivo Motivo do bloqueio ter sido ocorrido.
     * @return int|mixed Código do registro de bloqueio, se salvo com sucesso.
     */
    public function bloquear(string $motivo = 'Não definido', string $ip = '')
    {
        $id = 0;

        if($this->verificar())
        {
            $table = TableRegistry::get('Firewall');
            $bloqueado = $table->newEntity();

            $bloqueado->ip = ($ip == '') ? $_SERVER['REMOTE_ADDR'] : $ip;
            $bloqueado->data = date("Y-m-d H:i:s");
            $bloqueado->lista_branca = false;
            $bloqueado->site = false;
            $bloqueado->ativo = true;
            $bloqueado->motivo = $motivo;

            if($table->save($bloqueado))
            {
                $id = $bloqueado->id;
            }
        }

        return $id;
    }

    /**
    * Verifica se o Endereço de IP de acesso possui a permissão de acessar o sistema
    * @return bool Se o IP possui o acesso ao sistema.
    */
    public function verificar()
    {
        $table = TableRegistry::get('Firewall');
        $ip = $_SERVER['REMOTE_ADDR'];

        $query = $table->find('all', [
            'conditions' => [
                'ip' => $ip,
                'lista_branca' => false,
                'ativo' => true
            ]
        ]);

        return ($query->count() == 0);
    }
}