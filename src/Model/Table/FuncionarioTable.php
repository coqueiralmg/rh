<?php

namespace App\Model\Table;

class FuncionarioTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('funcionario');
        $this->primaryKey('id');
        $this->entityClass('Funcionario');
        
        $this->belongsTo('TipoFuncionario', [
            'className' => 'TipoFuncionario',
            'foreignKey' => 'tipo',
            'propertyName' => 'tipo',
            'joinType' => 'INNER'
        ]);
    }
}
