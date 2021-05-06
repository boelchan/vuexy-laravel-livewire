<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => true,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'administrator' => [
            'permisi' => 'i,c,r,u,d',
            'profile' => 'i,c,r,u,d',
        ],
        'user' => [
            'permisi' => 'i,r',
            'profile' => 'i,r,u',
        ]
    ],

    'permissions_map' => [
        'i' => 'index',
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
