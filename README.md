# Queue watcher plugin for Craft CMS 4

Watchtower plugin monitors the queue log for bottlenecks and send notifications emails once those thresholds are met. It also has the ability to ping [Oh Dear](https://ohdear.app/) for cron job monitoring. 

### Requirements
 * PHP version 8.0.2 or higher
 * Craft CMS 4.0 or higher

---
### Installation
To install this plugin, copy the command above to your terminal:

```bash
composer require siebird/craft-watchtower -w && php craft plugin/install watchtower
```

In the control panel, go to settings, find Watchtower and click to configure.

## Configure cron job to trigger Watchtower
To monitor the queue manager log, set up a console command to run at your prefered interval (ie. hourly)
```bash
0 * * * * php craft watchtower/monitor
```

## Custom Email Template
Review the default email template (`./src/templates/_emails/notification`) as a starting point. Enter the updated path in the custom email template field relative to Craft's `./templates` folder.