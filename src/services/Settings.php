<?php
namespace siebird\WatchTower\services;

use Craft;
use craft\base\Plugin;
use craft\helpers\Json;
use yii\base\Component;

class Settings extends Component
{

    public function saveSettings($plugin, $settings)
    {
        $pluginSettings = $plugin->getSettings();
        $settings = $settings['settings'] ?? $settings;

        foreach ($pluginSettings->getAttributes() as $settingHandle => $value)
        {
            if (isset($settings[$settingHandle]))
            {
                $pluginSettings->{$settingHandle} = $settings[$settingHandle] ?? $value;
            }
        }

        if (! $pluginSettings->validate())
        {
            return $pluginSettings;
        }

        Craft::$app->getPlugins()->savePluginSettings($plugin, $pluginSettings->getAttributes());

        return $pluginSettings;
    }

}
