<?php
/**
 * DfListException is class for handling exception in list
 *
 * DfListException class implements ArrayAccess, Iterator for DfExceptions
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.base
 * @since 0.2.1
 */
class DfListExceptions extends DfException implements ArrayAccess, Iterator
{
    /**
     * List
     * @var array
     */
    protected $_list = [];

    /**
     * __construct
     */
    public function __construct()
    {

    }

    /**
     * Offset Exists
     * @param mixed $index
     * @return bool
     */
    public function offsetExists($index)
    {
        return isset($this->_list[$index]);
    }

    /**
     * Offset Get
     * @param mixed $index
     * @return mixed
     */
    public function offsetGet($index)
    {
        return $this->_list[$index];
    }

    /**
     * Offset Set
     * @param mixed $index
     * @param mixed $value
     */
    public function offsetSet($index, $value)
    {
        if (isset($index)) {
            $this->_list[$index] = $value;
        } else {
            $this->_list[] = $value;
        }
    }

    /**
     * Offset Unset
     * @param mixed $index
     */
    public function offsetUnset($index)
    {
        unset($this->_list[$index]);
    }

    /**
     * Key
     * @return mixed
     */
    public function key()
    {
        return key($this->_list);
    }

    /**
     * Next
     * @return mixed
     */
    public function next()
    {
        return next($this->_list);
    }

    /**
     * Rewind
     * @return mixed
     */
    public function rewind()
    {
        return reset($this->_list);
    }

    /**
     * Valid
     * @return bool
     */
    public function valid()
    {
        return (bool)$this->current();
    }

    /**
     * Current
     * @return mixed
     */
    public function current()
    {
        return current($this->_list);
    }
}