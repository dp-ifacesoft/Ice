<?php
return [
    'time' => '2015-02-12 18:29:16',
    'revision' => '02121829',
    'tableName' => 'ice_account',
    'dataSourceKey' => 'Ice\\Data\\Source\\Mysqli/default.test',
    'Ice\\Core\\Model' => [
        'account_pk' => 'account_pk',
        'user__fk' => 'user__fk',
        'login' => 'login',
        'password' => 'password',
        'account_active' => 'account_active',
    ],
    'Ice\\Core\\Model_Scheme' => [
        'columns' => [
            'account_pk' => [
                'extra' => 'auto_increment',
                'type' => 'bigint(20)',
                'dataType' => 'bigint',
                'length' => '19,0',
                'characterSet' => null,
                'nullable' => false,
                'default' => null,
                'comment' => '',
                'is_primary' => false,
                'is_foreign' => false,
            ],
            'user__fk' => [
                'extra' => '',
                'type' => 'bigint(20)',
                'dataType' => 'bigint',
                'length' => '19,0',
                'characterSet' => null,
                'nullable' => true,
                'default' => null,
                'comment' => '',
                'is_primary' => false,
                'is_foreign' => false,
            ],
            'login' => [
                'extra' => '',
                'type' => 'varchar(255)',
                'dataType' => 'varchar',
                'length' => '255',
                'characterSet' => 'utf8',
                'nullable' => true,
                'default' => null,
                'comment' => '',
                'is_primary' => false,
                'is_foreign' => false,
            ],
            'password' => [
                'extra' => '',
                'type' => 'varchar(255)',
                'dataType' => 'varchar',
                'length' => '255',
                'characterSet' => 'utf8',
                'nullable' => true,
                'default' => null,
                'comment' => '',
                'is_primary' => false,
                'is_foreign' => false,
            ],
            'account_active' => [
                'extra' => '',
                'type' => 'tinyint(1)',
                'dataType' => 'tinyint',
                'length' => '3,0',
                'characterSet' => null,
                'nullable' => false,
                'default' => '1',
                'comment' => '',
                'is_primary' => false,
                'is_foreign' => false,
            ],
        ],
        'indexes' => [
            'PRIMARY KEY' => [
                'PRIMARY' => [
                    1 => 'account_pk',
                ],
            ],
            'FOREIGN KEY' => [
                'fk_ice_account_ice_user' => [
                    'fk_ice_account_ice_user' => 'user__fk',
                ],
            ],
            'UNIQUE' => [],
        ],
    ],
    'Ice\\Core\\Validator' => [
        'account_pk' => [
            0 => 'Ice:Not_Null',
        ],
        'user__fk' => [],
        'login' => [],
        'password' => [],
        'account_active' => [
            0 => 'Ice:Not_Null',
        ],
    ],
    'Ice\\Core\\Form' => [
        'account_pk' => 'Number',
        'user__fk' => 'Number',
        'login' => 'Text',
        'password' => 'Text',
        'account_active' => 'Checkbox',
    ],
    'Ice\\Core\\Data' => [
        'account_pk' => 'text',
        'user__fk' => 'text',
        'login' => 'text',
        'password' => 'text',
        'account_active' => 'text',
    ],
];