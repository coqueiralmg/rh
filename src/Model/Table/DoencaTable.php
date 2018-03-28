<?php

namespace App\Model\Table;

class DoencaTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('cid');
        $this->primaryKey('codigo');
    }
}