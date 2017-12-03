<?php namespace Quadrowin\EaxOctober\Classes;

/**
 * Created by PhpStorm.
 * User: yury
 * Date: 16.09.2017
 * Time: 13:35
 */

class Bootstrap
{

    private static $inited = false;

    public static function run()
    {
        if (self::$inited) {
            return;
        }
        self::$inited = true;

        require __DIR__ . '/EaxComponentBase.php';
        require __DIR__ . '/EaxModel.php';
        require __DIR__ . '/InputFilter.php';
        require __DIR__ . '/InputFilterResult.php';

        ExceptionPrototype::init();
    }

}