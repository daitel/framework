<?php
/**
 * DfTimer is base class
 *
 * DfTimer class provide functions for timers operation
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.base
 * @since 0.1.6
 */
class DfTimer
{
    /**
     * Timers array
     * @var array
     */
    private $timer = [];

    /**
     * Timer start
     * @param string $name
     * @return bool
     */
    public function start($name = 'default')
    {
        $time = $this->getTime();

        if (!isset($this->timer[$name])) {
            $this->timer[$name] = $time;
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
    function stop($name = 'default', $round = 4)
    {
        if (isset($this->timer[$name])) {
            $time = round(($this->getTime() - $this->timer[$name]), $round);
            unset($this->timer[$name]);
            return $time;
        } else {
            return false;
        }
    }
}