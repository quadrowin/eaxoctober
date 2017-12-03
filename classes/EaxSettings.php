<?php
/**
 * Created by PhpStorm.
 * User: yury
 * Date: 03.12.2017
 * Time: 14:28
 */

namespace Quadrowin\EaxOctober\Classes;

class EaxSettings extends EaxModel
{

    public $implement = ['System.Behaviors.SettingsModel'];

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';

}