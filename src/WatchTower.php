<?php
namespace siebird\WatchTower;

use Craft;
use yii\base\Event;
use craft\base\Plugin;
use craft\console\Application as ConsoleApplication;
use craft\commerce\elements\Order;
use craft\events\RegisterUrlRulesEvent;
use craft\helpers\UrlHelper;
use craft\web\UrlManager;

use siebird\WatchTower\base\PluginTrait;
use siebird\WatchTower\models\Settings;
use siebird\WatchTower\services\App;

use GuzzleHttp\Client;

class WatchTower extends Plugin
{

	use PluginTrait;

	public static $app;
	public static Plugin $plugin;
	public bool $hasCpSection 		= false;
	public bool $hasCpSettings 		= true;
    public string $pluginHandle     = 'watchtower';
	public string $schemaVersion 	= '4.0.0';

	public function init(): void
	{
	    parent::init();
	    self::$plugin = $this;
	    self::$app = new App();

	    // Add in our console commands
	    if (Craft::$app instanceof ConsoleApplication) {
	    	$this->controllerNamespace = 'siebird\WatchTower\console\controllers';
	    }

	    $this->_registerCpRoutes();
	    $this->_setPluginComponents();
	    $this->_registerEvents();
	}

	private function _registerCpRoutes(): void
    {
        Event::on(UrlManager::class, UrlManager::EVENT_REGISTER_CP_URL_RULES, function(RegisterUrlRulesEvent $event) {
            $event->rules = array_merge($event->rules, [
                'watchtower' 			=> 'watchtower/settings/general',
    			'watchtower/settings' 	=> 'watchtower/settings/general',

    			// temporary route to test codes
    			'watchtower/test' 	=> 'watchtower/settings/test',
            ]);
        });
    }

	private function _registerEvents(): void
	{

	}

    public function getCpNavItem(): ?array
	{

	    $parent = parent::getCpNavItem();
	    $parent['label'] = $this->getSettings()->pluginName;
        $parent['url'] = 'watchtower';

	    if($parent['label'] == "")
	    {
	    	$parent['label'] = "Watchtower";
	    }

		return $parent;

	}

    protected function cpNavIconPath(): ?string
	{
	    $path = $this->getBasePath() . DIRECTORY_SEPARATOR . 'icon-mask.svg';
	    return is_file($path) ? $path : null;
	}

    protected function createSettingsModel(): ?\craft\base\Model
	{
	    return new Settings();
	}

	public function getSettingsResponse(): mixed
    {
        return Craft::$app->getResponse()->redirect(UrlHelper::cpUrl('watchtower/settings'));
    }

	protected function afterInstall(): void
	{

	}

	public function beforeUninstall(): void
	{

	}

}