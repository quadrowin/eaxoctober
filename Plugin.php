<?php namespace Quadrowin\EaxOctober;

use Quadrowin\EaxOctober\Classes\Bootstrap as EaxOctoberBootstrap;
use Quadrowin\EaxOctober\Console\Func;
use System\Classes\PluginBase;

/**
 * naming Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'EaxOctober',
            'description' => 'Стандартное расширение Quadrowin',
            'author'      => 'quadrowin',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    public function registerMarkupTags()
    {
        return [];
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        require __DIR__ . '/facades/debug.php';
        EaxOctoberBootstrap::run();
        $this->registerConsoleCommand('eax:func', Func::class);
        return null;
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [];
    }

    public function registerFormWidgets()
    {
        return [];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [];
    }
}
