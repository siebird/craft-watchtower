<?php
namespace siebird\WatchTower\controllers;

use Craft;
use craft\web\Controller as BaseController;
use craft\elements\Asset;
use siebird\WatchTower\WatchTower;

class SettingsController extends BaseController
{

	public $settingsSection;
	public $selectedSidebarItem;
    public $plugin;
    public $settingsNav;
    public $selectedNav;

    protected $allowAnonymous = [
        // 'check-area' => self::ALLOW_ANONYMOUS_LIVE
    ];

	public function init()
    {
        parent::init();
        $this->plugin = WatchTower::$plugin;
        $this->settingsNav = $this->plugin->getSettings()->getSettingsNavItems();
        $this->selectedNav = Craft::$app->getRequest()->getSegment(2);
    }

    public function actionGeneral()
    {
        $meta          = array();
        $navigation    = $this->settingsNav;
    	$settings      = $this->plugin->getSettings();
        $meta['type']           = "form";
        $meta['selectedNav']    = ($this->selectedNav == '' || $this->selectedNav == 'settings') ? 'local' : $this->selectedNav;
        $meta['action']         = $this->settingsNav[$meta['selectedNav']]['action'];

        $this->renderTemplate($this->settingsNav[$meta['selectedNav']]['template'], array(
            'settings'  => $settings,
            'meta'      => $meta,
            'navigation'=> $navigation,
        ));

    }

    public function actionSaveGeneralSettings()
    {

        $this->requirePostRequest();
        $postSettings = Craft::$app->getRequest()->getBodyParam('settings');

        $settings = $this->plugin->getSettings();
        $settings = WatchTower::$app->settings->saveSettings($this->plugin, $postSettings);

        if ($settings->hasErrors())
        {

            Craft::$app->getSession()->setError(Craft::t('watchtower', 'Couldn’t save settings.'));
            Craft::$app->getUrlManager()->setRouteParams([
                'settings' => $settings
            ]);

            return null;

        }

        Craft::$app->getPlugins()->savePluginSettings($this->plugin::getInstance(), $postSettings);
        Craft::$app->getSession()->setNotice(Craft::t('watchtower', 'Settings saved.'));

        return $this->redirectToPostedUrl();

    }

}