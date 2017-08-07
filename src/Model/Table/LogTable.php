<?php

namespace App\Model\Table;


class LogTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('log');
        $this->primaryKey('id');

        $this->belongsTo('Usuario', [
            'className' => 'Usuario',
            'foreignKey' => 'usuario',
            'propertyName' => 'usuario',
            'joinType' => 'INNER'
        ]);
    }
}