<?php

return[
    /**
     * Security and encryption configuration
     *
     * - salt - A random string used in security hashing methods.
     *   The salt value is also used as the encryption key.
     *   You should treat it as extremely sensitive data.
     */
    'Security' => [
        'salt' => env('SECURITY_SALT', 'UmVjdXJzb3MgaHVtYW5vcyBkYSBQcmVmZWl0dXJhIE11bmljaXBhbCBkZSBDb3F1ZWlyYWwgLSBBbW9yIFBvciBOb3NzYSBHZW50ZQ=='),
        'login' => [
            'attemps' => [
                'max' => 5,
                'warning' => 3
            ],
            'access' => 'public'
        ]
    ]
];