<?php
namespace siebird\WatchTower\libraries;

use Craft;
use siebird\WatchTower\WatchTower;

class General
{

	public $plugin;

	function __construct()
	{
		$this->plugin = WatchTower::$plugin;
	}

	function getSettings($key = "")
	{

		$settings = $this->plugin->getSettings();

		if($key == "")
		{
			return $settings->getAttributes();
		}
		else
		{
			return isset($settings->$key) ? $settings->$key : "";
		}

	}

}