<?php

namespace App\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Table;

class BaseTable extends Table
{
    /**
     * Determina a conexão de banco de dados de acordo com a requisição do sistema.
     * Utilizado para permitir a portabilidade de migração dos ambientes de desenvolvimento/produção pora ambientes de tes.
     *
     * @return string Nome da conexão
     */
    public static function defaultConnectionName()
    {
        return Configure::read('Database.datasource');
    }
}