<?php
/**
 * Created by PhpStorm.
 * User: yury
 * Date: 16.09.2017
 * Time: 16:35
 */

namespace Quadrowin\EaxOctober\Classes;


class EaxInvoker
{

    /**
     * @var \Closure
     */
    private $callback;

    public function __construct(\Closure $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @return mixed
     */
    public function __invoke()
    {
        return call_user_func_array($this->callback, func_get_args());
    }

}