<?php
return [
    'Ice\\Core\\Model' => [
        'user__fk' => 'user__fk',
        'role__fk' => 'role__fk',
    ],
    'Ice\\Core\\Validator' => [
        'user__fk' => [],
        'role__fk' => [],
    ],
    'Ice\\Core\\Form' => [
        'user__fk' => 'Number',
        'role__fk' => 'Number',
    ],
    'Ice\\Core\\Data' => [
        'user__fk' => 'text',
        'role__fk' => 'text',
    ],
];