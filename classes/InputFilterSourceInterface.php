<?php namespace Quadrowin\EaxOctober\Classes;

/**
 * @author Shvedov_U
 */
interface InputFilterSourceInterface
{

    /**
     * @param string $name
     * @return mixed
     */
    function getInputValue($name);

}