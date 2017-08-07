<?php

namespace App\Model\Table;

class AcaoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('acao');
        $this->primaryKey('id');
    }
}
