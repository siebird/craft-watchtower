<?php
namespace siebird\WatchTower\models;

use Craft;
use craft\base\Model;
use craft\elements\Category;

class Settings extends Model
{

    public $pluginName = 'Watch Tower';
    public $pileUpQueueLimit = '50';
    public $failedQueueLimit = '5';
    public $ignoreRepeated = true;
    public $emails = "";
    public $ohDearPingUrl = "";

    public function getSettingsNavItems()
    {

        $ret =  [
            'local' => [
                'label' => Craft::t('watchtower', 'General Settings'),
                'url' => 'watchtower',
                'action' => 'watchtower/settings/save-general-settings',
                'selected' => 'local',
                'template' => 'watchtower/_templates/general'
            ],
        ];

        return $ret;

    }

    public function rules()
    {
        return [
            [['pluginName', 'pileUpQueueLimit', 'failedQueueLimit', 'emails'], 'required'],
            $rules[] = [['pileUpQueueLimit'], 'number', 'integerOnly' => true]
        ];
    }

}