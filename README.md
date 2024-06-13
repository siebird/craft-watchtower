# Queue watcher plugin for Craft CMS 5

Watchtower plugin monitors the Craft queue manager for bottlenecks and send notifications emails once those thresholds are met.

For added monitoring, you can also ping [*Oh Dear*](https://ohdear.app/) for scheduled task monitoring.

### Requirements
 * PHP version 8.0.2 or higher
 * Craft CMS 5.0 or higher

---
## Installation
To install this plugin, copy the command above to your terminal:

```bash
composer require siebird/craft-watchtower -w && php craft plugin/install watchtower
```

In the control panel, go to settings, find Watchtower plugin and click to configure settings.

## Configure cron job to trigger Watchtower
In order for Watchtower to monitor the queue manager–it needs to be run via a cron job. Configure a cron job to run a console command to hourly or at your desired interval. Example below runs every hour on the hour.

*Cron Job (linux)*
```bash
0 * * * * php craft watchtower/monitor
```

## Custom Email Template
Review the default email template (`./src/templates/_emails/notification`) as a starting point. Enter the updated path in the custom email template field relative to Craft's `./templates` folder.