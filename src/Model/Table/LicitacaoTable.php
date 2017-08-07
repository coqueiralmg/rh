<?php

namespace App\Model\Table;


class LicitacaoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('licitacao');
        $this->primaryKey('id');
    }
}