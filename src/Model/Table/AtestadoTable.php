<?php

namespace App\Model\Table;

class AtestadoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('atestado');
        $this->primaryKey('id');
        $this->entityClass('Atestado');
    }
}
