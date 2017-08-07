<?php

namespace App\Model\Table;

class FuncaoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('funcao');
        $this->primaryKey('id');
        $this->entityClass('Funcao');

        $this->belongsToMany('GrupoUsuario', [
            'joinTable' => 'funcao_grupo',
            'foreignKey' => 'funcao_id',
            'targetForeignKey' => 'grupo_id',
            'propertyName' => 'grupos'
        ]);
    }
}
