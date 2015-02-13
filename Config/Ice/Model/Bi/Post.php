<?php
return [
    'time' => '2015-02-12 18:35:46',
    'revision' => '02121835',
    'tableName' => 'bi_post',
    'dataSourceKey' => 'Ice\\Data\\Source\\Mysqli/default.test',
    'Ice\\Core\\Model' => [
        'post_pk' => 'post_pk',
        'post_name' => 'post_name',
        'post_translit' => 'post_translit',
        'post_text' => 'post_text',
        'post_active' => 'post_active',
        'post_created' => 'post_created',
        'blog__fk' => 'blog__fk',
    ],
    'Ice\\Core\\Model_Scheme' => [
        'columns' => [
            'post_pk' => [
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
            'post_name' => [
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
            'post_translit' => [
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
            'post_text' => [
                'extra' => '',
                'type' => 'text',
                'dataType' => 'text',
                'length' => '65535',
                'characterSet' => 'utf8',
                'nullable' => true,
                'default' => null,
                'comment' => '',
                'is_primary' => false,
                'is_foreign' => false,
            ],
            'post_active' => [
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
            'post_created' => [
                'extra' => '',
                'type' => 'timestamp',
                'dataType' => 'timestamp',
                'length' => '0',
                'characterSet' => null,
                'nullable' => true,
                'default' => null,
                'comment' => '',
                'is_primary' => false,
                'is_foreign' => false,
            ],
            'blog__fk' => [
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
        ],
        'indexes' => [
            'PRIMARY KEY' => [
                'PRIMARY' => [
                    1 => 'post_pk',
                ],
            ],
            'FOREIGN KEY' => [
                'fk_bi_post_bi_blog' => [
                    'fk_bi_post_bi_blog' => 'blog__fk',
                ],
            ],
            'UNIQUE' => [],
        ],
    ],
    'Ice\\Core\\Validator' => [
        'post_pk' => [
            0 => 'Ice:Not_Null',
        ],
        'post_name' => [],
        'post_translit' => [],
        'post_text' => [],
        'post_active' => [
            0 => 'Ice:Not_Null',
        ],
        'post_created' => [],
        'blog__fk' => [],
    ],
    'Ice\\Core\\Form' => [
        'post_pk' => 'Number',
        'post_name' => 'Text',
        'post_translit' => 'Text',
        'post_text' => 'Textarea',
        'post_active' => 'Checkbox',
        'post_created' => 'Date',
        'blog__fk' => 'Number',
    ],
    'Ice\\Core\\Data' => [
        'post_pk' => 'text',
        'post_name' => 'text',
        'post_translit' => 'text',
        'post_text' => 'text',
        'post_active' => 'text',
        'post_created' => 'text',
        'blog__fk' => 'text',
    ],
];