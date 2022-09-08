# Queue watcher plugin for Craft CMS 4

Watchtower plugin monitors the queue log for bottlenecks and send notifications emails once those thresholds are met. It also has the ability to ping Oh Dear for cron job monitoring.

### Requirements
 * PHP version 8.0.2 or higher
 * Craft CMS 4.0 or higher

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