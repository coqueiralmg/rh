<?php

namespace App\Model\Table;

class AtestadoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('atestado');
        $this->primaryKey('id');
        $this->entityClass('Atestado');

        $this->belongsTo('Funcionario', [
            'className' => 'Funcionario',
            'foreignKey' => 'funcionario',
            'propertyName' => 'funcionario',
            'joinType' => 'INNER'
        ]);
    }
}
