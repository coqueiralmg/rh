<?php

namespace App\Model\Table;

class GrupoFuncaoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('grupo_funcao');
        $this->primaryKey('id');
        $this->entityClass('GrupoFuncao');
    }
}
