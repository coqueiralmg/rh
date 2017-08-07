<?php

return[
    'limitPagination' => 15,
    'security' => [
        'login' => [
            'maxAttemps' => 5,
            'warningAttemp' => 3
        ]
    ],
    'system' => [
        'name'=> 'Painel de Controle | Prefeitura Municipal de Coqueiral',
        'shortName' => 'Prefeitura de Coqueiral',
        'version' => '1.0',
        'fullVersion' => '1.0.0',
        'yearRelease' => '2017'
    ],
    'author' => [
        'name' => 'Prefeitura Municipal de Coqueiral',
        'company' => 'Prefeitura Municipal de Coqueiral',
        'local' => 'Coqueiral - MG',
        'site' => 'coqueiral.mg.gov.br',
        'email' => 'ti@coqueiral.mg.gov.br',
        'developer' => [
            'name' => 'Fábio Valentim',
            'site' => 'www.baudovalentim.net',
            'email' => 'valentim@baudovalentim.net'
        ]
    ],
    'host' => [
        'developer' => 'localhost',
        'release' => 'coqueiral.mg.gov.br'
    ]
];