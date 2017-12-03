<?php namespace Quadrowin\EaxOctober\Classes;

/**
 * @author Shvedov_U
 */
class InputFilterSourceCallback implements InputFilterSourceInterface
{

    /**
     * @var \Closure
     */
    private $callback;

    /**
     * @param \Closure $callback
     */
    public function __construct(\Closure $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getInputValue($name)
    {
        $cb = $this->callback;
        return $cb($name);
    }

}