<?php

namespace App\Model\Table;


class PostTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('post');
        $this->primaryKey('id');

         $this->belongsTo('Usuario', [
            'className' => 'Usuario',
            'foreignKey' => 'autor',
            'propertyName' => 'autor',
            'joinType' => 'INNER'
        ]);
    }
}