<?php
/**
 * @link https://github.com/daitel/framework
 */

/**
 * Test Bootstrap
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.3.0
 */

require __DIR__.'/config.php';
require __DIR__.'/DfTests.php';

//start tests class
DfTests::start(__DIR__, $config);

//require framework
require dirname(__DIR__).'/framework/Df.php';
