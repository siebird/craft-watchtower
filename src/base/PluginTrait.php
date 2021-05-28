<?php
namespace siebird\WatchTower\base;

use Craft;
use siebird\WatchTower\WatchTower;
use siebird\WatchTower\libraries\General;
use siebird\WatchTower\libraries\Monitor;
use siebird\WatchTower\libraries\Email;

trait PluginTrait
{

    public static $plugin;

    private function _setPluginComponents()
    {
        $this->setComponents([
            'general' => General::class,
            'monitor' => Monitor::class,
            'email' => Email::class,
        ]);
    }

}