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
            'foreignKey' => 'funcoes_id',
            'targetForeignKey' => 'grupos_id',
            'propertyName' => 'grupos'
        ]);
    }
}
