<?php namespace Quadrowin\EaxOctober\Classes;

/**
 * @author Shvedov_U
 */
class InputFilterSourceObject implements InputFilterSourceInterface
{

    /**
     * @var \object
     */
    private $obj;

    /**
     * @param object $obj
     */
    public function __construct($obj)
    {
        $this->obj = $obj;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getInputValue($name)
    {
        return isset($this->obj->{$name}) ? $this->obj->{$name} : null;
    }

}