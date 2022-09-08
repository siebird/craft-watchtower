<?php

namespace siebird\WatchTower\console\controllers;

use siebird\WatchTower\WatchTower;

use Craft;
use yii\console\Controller;
use yii\helpers\Console;

class MonitorController extends Controller
{
    /**
     * Command to monitor current jobs in queue and fire email if a backlog of pending or failed jobs in queue.
     * ./craft watchtower/monitor
     */
    public function actionIndex()
    {
        WatchTower::$plugin->monitor->fetchInfo();
    }

}
