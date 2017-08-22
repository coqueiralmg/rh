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

        $this->belongsTo('Empresa', [
            'className' => 'Empresa',
            'foreignKey' => 'empresa',
            'propertyName' => 'empresa',
            'joinType' => 'INNER'
        ]);
    }
}
