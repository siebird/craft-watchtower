# Queue watcher plugin for Craft CMS 3

Watchtower plugin monitors the queue log for bottlenecks and send notifications emails once those thresholds are met. It also has the ability to ping Oh Dear for cron job monitoring.  

### Requirements
 * PHP version 7.1 or higher
 * Craft CMS 3.3 or higher
 * Craft Commerce 3.1.0 or higher

---
### Installation
Open your terminal and go to your Craft project:

```bash
cd /path/to/project
```
Run this command to load the plugin:

```bash
composer require siebird/craft-watchtower
```

In the Control Panel, go to Settings → Plugins and click the “Install” button for "Watchtower".