<?php

namespace App\Model\Table;

class MedicoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('medico');
        $this->primaryKey('id');
        $this->entityClass('Medico');
    }
}