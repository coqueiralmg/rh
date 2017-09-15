<?php

namespace App\Model\Table;


class AuditoriaTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('auditoria');
        $this->primaryKey('id');

        $this->belongsTo('Usuario', [
            'className' => 'Usuario',
            'foreignKey' => 'usuario',
            'propertyName' => 'usuario',
            'joinType' => 'LEFT OUTER'
        ]);
    }
}