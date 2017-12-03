<?php
/**
 * Created by PhpStorm.
 * User: yury
 * Date: 09.09.2017
 * Time: 11:47
 */

/**
 * var_dump and die
 * @param array ...$data
 */
function vd(...$data)
{
    if (ini_get('xdebug.overload_var_dump')) {
        array_map('var_dump', func_get_args());
        die();
    }

    $escape = php_sapi_name() !== 'cli'
        && filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH') !== 'XMLHttpRequest';

    if ($escape) {
        echo "<pre>\n";
    }

    ob_start(function ($dump) use ($escape) {
        $dump = str_replace("]=>\n  ", ']=>', $dump);
        return $escape ? str_replace(['<', '>'], ['&lt;', '&gt;'], $dump) : $dump;
    }, 4096);

    foreach ($data as $var) {
        if (is_object($var) && isset($var->xpdo)) {
            unset($var->xpdo);
        }
        var_dump($var);
        echo "\n";
    }
    ob_end_flush();

    if ($escape) {
        echo "</pre>\n";
    }

    die();
}

/**
 * var_dump and die safe
 * @param array ...$data
 */
function vds(...$data)
{
    if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        echo '<pre>';
    }
    foreach ($data as $d) {
        var_dump($d);
    }
    die();
}