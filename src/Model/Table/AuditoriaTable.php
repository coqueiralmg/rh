<?php

namespace App\Model\Table;


class AuditoriaTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('auditoria');
        $this->primaryKey('id');
    }
}