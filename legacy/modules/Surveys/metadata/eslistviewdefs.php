<?php

$module_name = 'Surveys';
$ESListViewDefs['Surveys'] = [
    'columns' => [
        'name' => [
            'link' => true,
            'default' => true,
        ],
        'assigned_user_name' => [
            'default' => true,
        ],
        'status' => [
            'default' => false,
            'type' => 'enum',
        ],
        'date_entered' => [],
        'date_modified' => [],
        'created_by_name' => [
            'link' => true,
        ],
        'modified_by_name' => [
            'link' => true,
        ],
    ],
    'search' => [
        'name' => [],  
        'assigned_user_name' => [],
        'status' => [],
        'date_entered' => [],
        'date_modified' => [],
        'created_by_name' => [],
        'modified_by_name' => [],
    ],
];
