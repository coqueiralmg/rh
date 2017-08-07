<?php

namespace App\Model\Table;


class FirewallTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('firewall');
        $this->primaryKey('id');
        $this->entityClass('Firewall');
    }
}