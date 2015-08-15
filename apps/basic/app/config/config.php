<?php
/**
 * Daitel Framework
 * Basic Application Config
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 */

$config = [
    'errors' => [
        'display' => true,
        'level' => E_ALL
    ],
    'logger' => [
        'path' => DF_APP_PATH . "/app/logs/log.txt"
    ],
    'router' => [
        'default' => [
            'controller' => 'hello'
        ]
    ]
];