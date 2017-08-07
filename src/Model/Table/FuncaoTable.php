<?php

namespace App\Model\Table;


class FuncaoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('funcoes');
        $this->primaryKey('id');
        $this->entityClass('Funcao');

        $this->belongsToMany('GrupoUsuario', [
            'joinTable' => 'funcoes_grupos',
            'foreignKey' => 'funcoes_id',
            'targetForeignKey' => 'grupos_id',
            'propertyName' => 'grupos'
        ]);
    }
}