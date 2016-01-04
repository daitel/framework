<?php
/**
 * @link https://github.com/daitel/framework
 */
namespace daitel\framework\utils;

/**
 * Timer is base class
 *
 * Timer class provide functions for timers operation
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.1.6
 */
class Timer
{
    /**
     * Timers array
     * @var array
     */
    private $timers = [];

    /**
     * Timer start
     * @param string $name
     * @return bool
     */
    public function start($name = 'default')
    {
        $time = $this->getTime();

        if (!isset($this->timers[$name])) {
            $this->timers[$name] = $time;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Time
     * @return array|mixed
     */
    private function getTime()
    {
        $time = microtime();
        $time = explode(' ', $time);
        $time = $time[1] + $time[0];
        return $time;
    }

    /**
     * Timer stop
     * @param string $name
     * @param int $round
     * @return bool|float
     */
    public function stop($name = 'default', $round = 4)
    {
        if (isset($this->timers[$name])) {
            $time = round(($this->getTime() - $this->timers[$name]), $round);
            unset($this->timers[$name]);
            return $time;
        } else {
            return false;
        }
    }
}