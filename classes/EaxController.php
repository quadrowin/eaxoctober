<?php
/**
 * Created by PhpStorm.
 * User: yury
 * Date: 28.09.2017
 * Time: 23:19
 */

namespace Quadrowin\EaxOctober\Classes;

use Backend\Classes\Controller;
use Illuminate\Support\Facades\App;

class EaxController extends Controller
{

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
    ];

    /**
     * @param mixed $input
     * @param array $fields
     * @return InputFilterResult|object
     */
    public function inputFilter($input, array $fields)
    {
        return $this->sl(InputFilter::class)->filter($input, $fields);
    }

    /**
     * @param array $fields
     * @return InputFilterResult|object
     */
    public function inputFilterValues(array $fields)
    {
        $input = new InputFilterSourceArray($_REQUEST);
        $filter = new InputFilter();
        return $filter->filter($input, $fields);
    }

    /**
     * Service Locator
     * @param string $class_name
     * @return object|mixed
     */
    public function sl($class_name)
    {
        $value = App::make($class_name);
        if (!$value) {
            $value = new $class_name;
            App::bind($class_name, $value);
        }
        return $value;
    }

    /**
     * @param string $partial
     * @param mixed $options
     * @return string
     */
    public function twigPartial($partial, $options = null)
    {
        $partialPath = $this->getViewPath($partial);
        $content = file_get_contents($partialPath);
        return Twig::parse($content, $options);
    }

}
