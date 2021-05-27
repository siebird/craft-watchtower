<?php
namespace siebird\WatchTower\base;

use Craft;
use siebird\WatchTower\WatchTower;
use siebird\WatchTower\libraries\General;

trait PluginTrait
{

    public static $plugin;

    private function _setPluginComponents()
    {
        $this->setComponents([
            'general' 		=> General::class,
        ]);
    }

}