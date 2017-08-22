<?php

namespace App\Model\Table;

class EmpresaTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('empresa');
        $this->primaryKey('id');
        $this->entityClass('Empresa');
    }
}