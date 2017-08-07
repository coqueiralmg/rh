<?php

namespace App\Model\Table;

class UsuarioTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('usuario');
        $this->primaryKey('id');
        $this->entityClass('Usuario');

        $this->belongsTo('GrupoUsuario', [
            'className' => 'GrupoUsuario',
            'foreignKey' => 'grupo',
            'propertyName' => 'grupoUsuario',
            'joinType' => 'INNER'
        ]);
    }
}
