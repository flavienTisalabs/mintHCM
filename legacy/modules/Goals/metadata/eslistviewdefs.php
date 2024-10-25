<?php

$module_name = 'Goals';
$ESListViewDefs['Goals'] = [
    'columns' => [
        'name' => [
            'link' => true,
            'default' => true,
        ],
        'status' => [
            'type' => 'enum',
            'default' => true,
        ],
        'date_start' => [
            'default' => true,
        ],
        'date_end' => [
            'default' => true,
        ],
        'employee_name' => [
            'link' => true,
            'default' => true,
        ],
        'date_modified' => [
        ],
        'date_entered' => [
        ],
        'assigned_user_name' => [
            'default' => true,
        ],
    ],
    'search' => [
        'name' => [],
        'date_start' => [],
        'date_end' => [],
        'status' => [],
        'employee_name' => [],
        'assigned_user_name' => [],
        'date_entered' => [],
        'date_modified' => [],
        'created_by_name' => [],
        'modified_by_name' => [],
    ],
];
