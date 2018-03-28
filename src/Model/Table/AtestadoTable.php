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
        
        $this->belongsTo('Medico', [
            'className' => 'Medico',
            'foreignKey' => 'medico',
            'propertyName' => 'medico',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Doenca', [
            'foreignKey' => 'cid',
            'propertyName' => 'cid',
            'joinType' => 'LEFT'
        ]);
    }
}
