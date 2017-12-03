<?php namespace Quadrowin\EaxOctober\Classes;
/**
 * Created by PhpStorm.
 * User: yury
 * Date: 16.09.2017
 * Time: 13:58
 *
 * @method mixed __get
 */
class InputFilterResult
{

    /**
     * @return array
     */
    public function __toArray()
    {
        return (array)$this;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function remove(string $key)
    {
        $value = $this->{$key};
        unset($this->{$key});
        return $value;
    }

    public function set(array $values)
    {
        foreach ($values as $key => $val) {
            $this->{$key} = $val;
        }
    }

}