<?php

namespace App\Model\Table;

class CidTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('cid');
        $this->primaryKey('id');
        $this->entityClass('Cid');
    }
}