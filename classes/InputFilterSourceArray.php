<?php namespace Quadrowin\EaxOctober\Classes;

/**
 * @author Shvedov_U
 */
class InputFilterSourceArray implements InputFilterSourceInterface
{

    /**
     * @var array
     */
    private $arr;

    /**
     * @param array $arr
     */
    public function __construct(array $arr)
    {
        $this->arr = $arr;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getInputValue($name)
    {
        return isset($this->arr[$name]) ? $this->arr[$name] : null;
    }

}