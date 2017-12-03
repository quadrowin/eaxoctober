<?php namespace Quadrowin\EaxOctober\Classes;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\App;
use October\Rain\Exception\AjaxException;
use October\Rain\Support\Facades\Twig;
use Quadrowin\Naming\Models\NcAccess;

/**
 * Created by PhpStorm.
 * User: yury
 * Date: 16.09.2017
 * Time: 13:19
 */

abstract class EaxComponentBase extends ComponentBase
{

    /**
     * @param mixed $input
     * @param array $fields
     * @return InputFilterResult
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
     * Call: return $this->make404();
     * @return string
     */
    protected function make404()
    {
        return $this->controller->run('404');
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
     * @param string $function
     * @param array $vars
     * @return string
     */
    public function twigMethod($function, $vars = [])
    {
        return $this->twigPartial($this->name . '::' . $function, $vars);
    }

    /**
     * @param string $partial
     * @param array $vars
     * @return string
     * @throws AjaxException
     */
    public function twigPartial($partial, $vars = [])
    {
        list($comp_name, $function) = explode('::', $partial);
        $class_name = get_class($this);
        $possible = [
            $this->assetPath . '/components/' . strtolower($comp_name) . '/' . $function . '.twig',
            $this->assetPath . '/components/' . strtolower(substr($class_name, strrpos($class_name, '\\') + 1)) . '/' . $function . '.twig',
        ];
        $root = base_path();
        foreach ($possible as $partialPath) {
            $partialPath = $root . $partialPath;
            if (file_exists($partialPath)) {
                $content = file_get_contents($partialPath);
                return Twig::parse($content, $vars);
            }
        }
        throw new AjaxException('Twig template not found ' . $partial);
    }

}