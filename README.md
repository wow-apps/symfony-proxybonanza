![ProxyBonanza for Symfony 3](http://cdn.wow-apps.pro/proxybonanza/proxybonanza-banner.jpg)

# symfony-proxybonanza
ProxyBonzana API for Symfony 3

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/9e427ba8-ceee-47a4-aeef-a788b9875064/big.png)](https://insight.sensiolabs.com/projects/9e427ba8-ceee-47a4-aeef-a788b9875064)

[![Packagist Pre Release](https://img.shields.io/packagist/v/wow-apps/symfony-proxybonanza.svg?maxAge=2592000?style=flat-square)](https://packagist.org/packages/wow-apps/symfony-proxybonanza)
[![AppVeyor](https://img.shields.io/appveyor/ci/gruntjs/grunt.svg?maxAge=2592000?style=flat-square)]()
[![PHP version](https://img.shields.io/badge/PHP-%5E7.0-blue.svg?style=flat-square)](http://php.net/manual/ru/migration70.new-features.php)
[![Symfony version](https://img.shields.io/badge/Symfony-%5E3.0-green.svg?style=flat-square)](http://symfony.com/)
[![GitHub license](https://img.shields.io/badge/license-Apache%202-blue.svg?style=flat-square)](https://raw.githubusercontent.com/wow-apps/symfony-slack-bot/master/LICENSE)
[![Coding Style](https://img.shields.io/badge/Coding%20Style-PSR--2-brightgreen.svg)](http://www.php-fig.org/psr/psr-2/)
[![Code Climate](https://codeclimate.com/github/wow-apps/symfony-proxybonanza/badges/gpa.svg)](https://codeclimate.com/github/wow-apps/symfony-proxybonanza)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/ce3fffd811f2463a94ed4065a341885a)](https://www.codacy.com/app/lion-samara/symfony-proxybonanza?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=wow-apps/symfony-slack-bot&amp;utm_campaign=Badge_Grade)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/9e427ba8-ceee-47a4-aeef-a788b9875064/mini.png)](https://insight.sensiolabs.com/projects/9e427ba8-ceee-47a4-aeef-a788b9875064)
[![Twitter](https://img.shields.io/twitter/url/https/github.com/wow-apps/symfony-proxybonanza.svg?style=social?style=flat-square)](https://twitter.com/intent/tweet?text=SlackBot+for+Symfony+3&url=%5Bobject%20Object%5D)


Simple Symfony 3 Bundle for sending messages to Slack via [incoming webhooks](https://api.slack.com/incoming-webhooks).

## Installation:

### Requires:

* PHP 7.0+
* Symfony 3.0+
* Guzzle Client 6.0+

### Step 1: Download the Bundle

```json
"require": {
        "wow-apps/symfony-proxybonanza": "^1.0.0"
}
```

or

```bash
$ composer require wow-apps/symfony-slack-bot 
```

### Step 2: Enable the Bundle

```php
// ./app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new WowApps\ProxyBonanzaBundle\WowAppsProxyBonanzaBundle()
    );

    // ...

    return $bundles
}
```


### Step 3: Add configuration

```yaml
# ProxyBonanza API
wow_apps_proxy_bonanza:
    api_url: "https://api.proxybonanza.com/v1/"
    api_key: "testAPIkey" # your API key
```

## Update DB structure:

Run command:

```bash
./bin/console doctrine:schema:update --force
```

![Test command result preview](http://cdn.wow-apps.pro/slackbot/slackbot_preview.jpg)


# Documentation

* [Home](https://github.com/wow-apps/symfony-slack-bot/wiki)
    * [Installation](https://github.com/wow-apps/symfony-slack-bot/wiki/1.-Installation)
    * [Using SlackBot](https://github.com/wow-apps/symfony-slack-bot/wiki/2.-Using-SlackBot)
    * [Additional helpers](https://github.com/wow-apps/symfony-slack-bot/wiki/3.-Additional-helpers)