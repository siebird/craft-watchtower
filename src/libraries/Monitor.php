<?php
namespace siebird\WatchTower\libraries;

use Craft;
use siebird\WatchTower\WatchTower;
use craft\db\Table;
use yii\db\Query;
use craft\console\Application as ConsoleApplication;

class Monitor
{

	public $tableName = Table::QUEUE;
	public $channel = 'queue';

	public $ignoreRepeated = true;

	public function fetchInfo()
	{
		$mailSent = false;
		$status = "Normal";
		$settings = WatchTower::$plugin->general->getSettings();
		if(empty($settings['emails'])) return false;

		$this->ignoreRepeated = $settings['ignoreRepeated'];

		$variables = [
			'totalPileups' => $this->_createWaitingJobQuery()->count(),
			'totalFailed' => $this->_createFailedJobQuery()->count()
		];

		if($variables['totalPileups'] >= $settings['pileUpQueueLimit'] || $variables['totalFailed'] >= $settings['failedQueueLimit'])
		{
			$status = "Count ";
			$mailSent = WatchTower::$plugin->email->send($variables, $settings);
		}

		// If ping url, always ping Oh dear on each command
		if (! empty($settings['ohDearPingUrl'])) {
			@file_get_contents($settings['ohDearPingUrl']);
		}

		if (Craft::$app instanceof ConsoleApplication) {
			echo "——————————————————————————————\n";
			echo "|  Queue          |  " . $status . "  |\n";
			echo "——————————————————————————————\n";
			echo "|  Pending Jobs   | " . "   " . $variables['totalPileups'] . ($variables['totalPileups'] <= 999 ? ' ' : '') . ($variables['totalPileups'] <= 99 ? ' ' : '') . ($variables['totalPileups'] <= 9 ? ' ' : '') . "  |\n";
			echo "——————————————————————————————\n";
			echo "|  Failed Jobs    | " . "   " . $variables['totalFailed'] . ($variables['totalFailed'] <= 999 ? ' ' : '') . ($variables['totalFailed'] <= 99 ? ' ' : '') . ($variables['totalFailed'] <= 9 ? ' ' : '') . "  |\n";
			echo "——————————————————————————————\n";
		} else {
			echo "————————————————<br>";
			echo "| &nbsp;&nbsp;&nbsp;&nbsp;Status &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | " . " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . ($status != 'Normal' ? '&nbsp;' : '') . trim($status) . ($status != 'Normal' ? '&nbsp;&nbsp;' : '') . "&nbsp;&nbsp;&nbsp;&nbsp; |<br>";
			echo "————————————————<br>";
			echo "| &nbsp;&nbsp;&nbsp;&nbsp;Pending Jobs &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | " . " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $variables['totalPileups'] . ($variables['totalPileups'] <= 999 ? '&nbsp;&nbsp;' : '') . ($variables['totalPileups'] <= 99 ? '&nbsp;&nbsp;' : '') . ($variables['totalPileups'] <= 9 ? '&nbsp;&nbsp;' : '') . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |<br>";
			echo "————————————————<br>";
			echo "| &nbsp;&nbsp;&nbsp;&nbsp;Failed Jobs &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | " . " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $variables['totalFailed'] . ($variables['totalFailed'] <= 999 ? '&nbsp;&nbsp;' : '') . ($variables['totalFailed'] <= 99 ? '&nbsp;&nbsp;' : '') . ($variables['totalFailed'] <= 9 ? '&nbsp;&nbsp;' : '') . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |<br>";
			echo "————————————————<br>";
		}

		exit();

	}

	private function _createWaitingJobQuery(): Query
    {
        $query = $this->_createJobQuery()
            ->andWhere(['fail' => false, 'timeUpdated' => null])
            ->andWhere('[[timePushed]] + [[delay]] <= :time', ['time' => time()]);

        return $this->_postOperation($query);

    }

    private function _createFailedJobQuery(): Query
    {
        return $this->_createJobQuery()->andWhere(['fail' => true]);
    }

    private function _postOperation($query): Query
    {
        if($this->ignoreRepeated)
        {
        	$query->groupBy('job');
        }

        return $query;
    }

	private function _createJobQuery(): Query
    {
        return (new Query())
			->select('job')
            ->from($this->tableName)
            ->where(['channel' => $this->channel]);
    }
}