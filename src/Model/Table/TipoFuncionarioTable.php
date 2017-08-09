<?php

namespace App\Model\Table;

class TipoFuncionarioTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('tipo_funcionario');
        $this->primaryKey('id');
    }
}