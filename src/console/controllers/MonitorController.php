<?php

namespace siebird\WatchTower\console\controllers;

use siebird\WatchTower\WatchTower;

use Craft;
use yii\console\Controller;
use yii\helpers\Console;

class MonitorController extends Controller
{
    /**
     * Command to monitor current queues and fire email if uncommon activity happend like failed queues or pileup lots of queues.
     * ./craft siebird/monitor
     */
    public function actionIndex()
    {
        WatchTower::$plugin->monitor->fetchInfo();
    }

}
