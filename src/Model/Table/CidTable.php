<?php

namespace App\Model\Table;

class CidTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('cid');
        $this->primaryKey('codigo');
        $this->entityClass('Cid');
    }
}