<?php
namespace siebird\WatchTower\libraries;

use Craft;
use siebird\WatchTower\WatchTower;
use craft\db\Table;
use yii\db\Query;
use craft\helpers\App;

class Email
{
	public function send($variables, $settings)
	{

        $variables['settings'] = $settings;

        if(! empty($settings['overrideEmailTemplate']))
        {
            Craft::$app->getView()->setTemplatesPath(Craft::$app->getPath()->getSiteTemplatesPath());
            $html = Craft::$app->getView()->renderTemplate($settings['overrideEmailTemplate'], $variables);
            Craft::$app->getView()->setTemplatesPath(Craft::$app->getPath()->getCpTemplatesPath());
        }
        else
        {
            Craft::$app->getView()->setTemplatesPath(Craft::$app->getPath()->getCpTemplatesPath());
            $html = Craft::$app->getView()->renderTemplate("watchtower/_emails/notification", $variables);
        }

        $craftMailSettings = App::mailSettings();
        $fromEmail = Craft::parseEnv($craftMailSettings->fromEmail);
        $fromName = Craft::parseEnv($craftMailSettings->fromName);

        $site = Craft::$app->getSites()->getCurrentSite();
        $siteName = Craft::t('site', $site->getName());
        $subject = "Watchtower Queue Bottleneck at " . $siteName;
        $to = explode(',', $settings['emails']);
        foreach ($to as $key => &$value) {
            $value = trim($value);
        }

        $mailer = Craft::$app
           ->getMailer()
           ->compose()
           ->setTo($to)
           ->setFrom(($fromEmail != "" ? ([$fromEmail => $fromEmail]): $fromEmail))
           ->setSubject($subject);

        $mailer->setHtmlBody($html);
        return $mailer->send();

	}
}