<?php
/**
 * Created by PhpStorm.
 * User: yury
 * Date: 29.09.2017
 * Time: 23:21
 */

namespace Quadrowin\EaxOctober\Classes;

class Dates
{

    private static $month_n = [
        1 => 'января',
        2 => 'февраля',
        3 => 'марта',
        4 => 'апреля',
        5 => 'мая',
        6 => 'июня',
        7 => 'июля',
        8 => 'августа',
        9 => 'сентября',
        10 => 'октября',
        11 => 'ноября',
        12 => 'декабря',
    ];

    /**
     * @param string $dt
     * @return string "11 августа 2017, 23:59 (МСК)"
     */
    public static function strftimeMsk($dt): string
    {
        $dt = strtotime($dt);
        $m = (int)date('m', $dt);
        return date('d ', $dt) . self::$month_n[$m] . date(' Y, H:i', $dt) . ' (МСК)';
    }

    /**
     * @param $dt
     * @return string
     */
    public static function dateDMonthY($dt): string
    {
        $dt = strtotime($dt);
        $m = (int)date('m', $dt);
        return date('d ', $dt) . self::$month_n[$m] . date(' Y');
    }

    /**
     * @return string
     */
    public static function now(): string
    {
        return date('Y-m-d H:i:s');
    }

    public static function nowModify(string $mod): string
    {
        return date('Y-m-d H:i:s', strtotime($mod));
    }

    /**
     * @param string $time "Y-m-d H:i:s"
     * @param string $change "+1 day" for example
     * @return string "Y-m-d H:i:s"
     */
    public static function timeModify(string $time, string $change): string
    {
        $dt = strtotime($time);
        return date('Y-m-d H:i:s', strtotime($change, $dt));
    }

}