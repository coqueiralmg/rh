<?php

namespace App\Model\Table;


class GrupoFuncaoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('grupos_funcoes');
        $this->primaryKey('id');
        $this->entityClass('GrupoFuncao');
    }
}