![ProxyBonanza for Symfony 3 and 4](http://cdn.wow-apps.pro/proxybonanza/proxybonanza-banner-v2.png)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a42c70a3-fdbb-4b66-8e7f-b9feefd37bb2/big.png?version=none)](https://insight.sensiolabs.com/projects/a42c70a3-fdbb-4b66-8e7f-b9feefd37bb2)

[![Packagist Pre Release](https://img.shields.io/packagist/v/wow-apps/symfony-proxybonanza.svg?maxAge=2592000&style=flat-square&version=none)](https://packagist.org/packages/wow-apps/symfony-proxybonanza)
[![Packagist](https://img.shields.io/packagist/dt/wow-apps/symfony-proxybonanza.svg)](https://packagist.org/packages/wow-apps/symfony-proxybonanza)
[![Build Status](https://scrutinizer-ci.com/g/wow-apps/symfony-proxybonanza/badges/build.png?b=master)](https://scrutinizer-ci.com/g/wow-apps/symfony-proxybonanza/build-status/master)
[![Code Climate](https://codeclimate.com/github/wow-apps/symfony-proxybonanza/badges/gpa.svg)](https://codeclimate.com/github/wow-apps/symfony-proxybonanza)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/6735a58510de4603a8605feb34d7426d)](https://www.codacy.com/app/lion-samara/symfony-proxybonanza?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=wow-apps/symfony-proxybonanza&amp;utm_campaign=Badge_Grade)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a42c70a3-fdbb-4b66-8e7f-b9feefd37bb2/mini.png)](https://insight.sensiolabs.com/projects/a42c70a3-fdbb-4b66-8e7f-b9feefd37bb2)

# ProxyBonanza API for Symfony

Symfony 3 and 4 Bundle for easy update, test and use proxy list from [ProxyBonanza](http://proxybonanza.com/) service.

## Requires:

* PHP 7.0+
* Symfony 3.0+
* Guzzle Client 6.0+
* Doctrine ORM 2.5+

## Installation:

### Step 1: Download the Bundle

```json
"require": {
        "wow-apps/symfony-proxybonanza": "^2.0.1"
}
```

or

```bash
$ composer require wow-apps/symfony-proxybonanza
```

### Step 2: Enable the Bundle (skip for Symfony 4)

```php
// ./app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new WowApps\ProxybonanzaBundle\WowAppsProxybonanzaBundle(),
    );

    // ...

    return $bundles
}
```


### Step 3: Add configuration

#### Symfony 3:
```yaml
# ProxyBonanza API
wow_apps_proxybonanza:
    api_url: "https://api.proxybonanza.com/v1/"
    api_key: "testAPIkey" # API key can be obtained in user panel in 'Account settings'.
```

#### Symfony 4:

```bash
$ echo "WOW_APPS_PROXYBONANZA_API_KEY={your api key}" >> .env
```

### Step 4: Update DB structure

Run command:

```bash
./bin/console doctrine:schema:update --force
```

### Step 5: Test your configuration

Run command to test your configuration:

```bash
./bin/console wowapps:proxybonanza:test
```

![Test command result preview](http://cdn.wow-apps.pro/proxybonanza/symfony-proxybonanza_command-test.jpg)

# Documentation

* [Documentation home](https://github.com/wow-apps/symfony-proxybonanza/wiki)
* [Commands](https://github.com/wow-apps/symfony-proxybonanza/wiki/Commands)
* [Usage](https://github.com/wow-apps/symfony-proxybonanza/wiki/Usage)

# News and updates:

Follow news and updates in my Telegram channel [@wow_apps_pro](https://t.me/wow_apps_pro) or Twitter [@alexey_samara_](https://twitter.com/alexey_samara_)

# Changelog:

* 2.0.1
    * Added copyrights to all php files
    * Added prefix `wowapps:` to all commands
    * Changed container for Symfony 4 Flex
    * Changed namespaces
    * Removed empty controller and view

* 2.0.0
    * Added compatibility for Symfony 3.1 up to 4.0
