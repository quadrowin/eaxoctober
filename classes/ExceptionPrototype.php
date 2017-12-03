<?php
/**
 * Created by PhpStorm.
 * User: yury
 * Date: 10.11.2017
 * Time: 21:32
 */

namespace Quadrowin\EaxOctober\Classes;


use Illuminate\Support\Facades\Request;
use October\Rain\Exception\AjaxException;
use October\Rain\Exception\ApplicationException;

/**
 * Объект для хранения исключения, которые позже могут быть вызваны
 * @package Quadrowin\EaxOctober\Classes
 */
class ExceptionPrototype
{

    public $message = 'Произошла ошибка';

    public $data = null;

    public static $suitableExceptionType = ApplicationException::class;

    public static function createSimple($message, array $data = []): self
    {
        $exc = new static;
        $exc->message = $message;
        $exc->data = $data;
        return $exc;
    }

    /**
     * @param string $message
     * @param array $data
     * @return \Exception
     */
    public static function createSuitable(string $message, array $data = []): \Exception
    {
        return self::createSimple($message, $data)->toSuitableException();
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public static function init()
    {
        if (Request::ajax()) {
            self::$suitableExceptionType = AjaxException::class;
        }
    }

    /**
     * @return string
     */
    public function suitableExceptionType(): string
    {
        return AjaxException::class;
    }

    public function toSuitableException(): \Exception
    {
        if (Request::ajax()) {
            return new AjaxException($this->getMessage());
        }
        return new ApplicationException($this->getMessage());
    }

}