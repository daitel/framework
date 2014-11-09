<?php
/**
 * Daitel Framework
 * Timer Functions
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 *
 */

/**
 * Timer Start
 *
 * @return float
 */
function DfTimer_start()
{
    $time = microtime();
    $time = explode(' ', $time);
    $time = $time[1] + $time[0];
    return $time;
}

/**
 * Timer Stop
 *
 * @param int $start
 *
 * @return float
 */
function DfTimer_stop($start)
{
    $time = microtime();
    $time = explode(' ', $time);
    $time = $time[1] + $time[0];
    $finish = $time;
    return round(($finish - $start), 4);
}

