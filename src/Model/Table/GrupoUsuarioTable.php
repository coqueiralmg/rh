<?php

namespace App\Model\Table;

class GrupoUsuarioTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('grupos');
        $this->primaryKey('id');
        $this->entityClass('GrupoUsuario');

         $this->belongsToMany('Funcao', [
            'joinTable' => 'funcoes_grupos',
            'foreignKey' => 'grupos_id',
            'targetForeignKey' => 'funcoes_id',
            'propertyName' => 'funcoes'
        ]); 
    }
}