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
    'name' => 'basic',
    'errors' => [
        //change it to false on production
        'debug' => true,
        //call for errors view, works on debug => false
        'error_call' => [
            'controller' => 'error',
            'action' => 'index',
            'id' => ''
        ]
    ],
    'logger' => [
        'path' => DfApp::getRuntimePath(true) . "app/logs/log.txt"
    ],
    'router' => [
        'default' => [
            'controller' => 'hello'
        ]
    ]
];