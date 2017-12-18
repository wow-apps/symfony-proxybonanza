![ProxyBonanza for Symfony 3 and 4](http://cdn.wow-apps.pro/proxybonanza/proxybonanza-banner-v2.png)

# ProxyBonanza API for Symfony
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a42c70a3-fdbb-4b66-8e7f-b9feefd37bb2/big.png?version=none)](https://insight.sensiolabs.com/projects/a42c70a3-fdbb-4b66-8e7f-b9feefd37bb2)

[![Packagist Pre Release](https://img.shields.io/packagist/v/wow-apps/symfony-proxybonanza.svg?maxAge=2592000&style=flat-square&version=none)](https://packagist.org/packages/wow-apps/symfony-proxybonanza)
[![Packagist](https://img.shields.io/packagist/dt/wow-apps/symfony-proxybonanza.svg)](https://packagist.org/packages/wow-apps/symfony-proxybonanza)
[![Build Status](https://scrutinizer-ci.com/g/wow-apps/symfony-proxybonanza/badges/build.png?b=master)](https://scrutinizer-ci.com/g/wow-apps/symfony-proxybonanza/build-status/master)
[![PHP version](https://img.shields.io/badge/PHP-%5E7.0-blue.svg?style=flat-square)](http://php.net/manual/ru/migration70.new-features.php)
[![Symfony version](https://img.shields.io/badge/Symfony-3-green.svg?style=flat-square)](http://symfony.com/)
[![Symfony version](https://img.shields.io/badge/Symfony-4-green.svg?style=flat-square)](http://symfony.com/)
[![GitHub license](https://img.shields.io/badge/license-Apache%202-blue.svg?style=flat-square)](https://raw.githubusercontent.com/wow-apps/symfony-proxybonanza/master/LICENSE)
[![Coding Style](https://img.shields.io/badge/Coding%20Style-PSR--2-orange.svg?style=flat-square)](http://www.php-fig.org/psr/psr-2/)
[![Code Climate](https://codeclimate.com/github/wow-apps/symfony-proxybonanza/badges/gpa.svg)](https://codeclimate.com/github/wow-apps/symfony-proxybonanza)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/6735a58510de4603a8605feb34d7426d)](https://www.codacy.com/app/lion-samara/symfony-proxybonanza?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=wow-apps/symfony-proxybonanza&amp;utm_campaign=Badge_Grade)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a42c70a3-fdbb-4b66-8e7f-b9feefd37bb2/mini.png)](https://insight.sensiolabs.com/projects/a42c70a3-fdbb-4b66-8e7f-b9feefd37bb2)
[![Twitter](https://img.shields.io/twitter/url/https/github.com/wow-apps/symfony-proxybonanza.svg?style=social?style=flat-square)](https://twitter.com/intent/tweet?text=ProxyBonzana+API+for+Symfony+3&url=%5Bobject%20Object%5D)


Symfony 3 and 4 Bundle for easy update, test and use proxy list from [ProxyBonanza](http://proxybonanza.com/) service.

## Installation:

### Requires:

* PHP 7.0+
* Symfony 3.0+
* Guzzle Client 6.0+
* Doctrine ORM 2.5+

### Step 1: Download the Bundle

```json
"require": {
        "wow-apps/symfony-proxybonanza": "^2"
}
```

or

```bash
$ composer require wow-apps/symfony-proxybonanza
```

### Step 2: Enable the Bundle

```php
// ./app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Wowapps\ProxyBonanzaBundle\WowappsProxyBonanzaBundle()
    );

    // ...

    return $bundles
}
```


### Step 3: Add configuration

```yaml
# ProxyBonanza API
wowapps_proxy_bonanza:
    api_url: "https://api.proxybonanza.com/v1/"
    api_key: "testAPIkey" # API key can be obtained in user panel in 'Account settings'.
```

### Step 4: Update DB structure

Run command:

```bash
./bin/console doctrine:schema:update --force
```

# Documentation

* [Documentation home](https://github.com/wow-apps/symfony-proxybonanza/wiki)
* [Commands](https://github.com/wow-apps/symfony-proxybonanza/wiki/Commands)
* [Usage](https://github.com/wow-apps/symfony-proxybonanza/wiki/Usage)

![Test command result preview](http://cdn.wow-apps.pro/proxybonanza/symfony-proxybonanza_command-test.jpg)

# News and updates:

Follow news and updates in my Telegram channel [@wow_apps_pro](https://t.me/wow_apps_pro) or Twitter [@alexey_samara_](https://twitter.com/alexey_samara_)

# Changelog:

* 2.0.0
    * Added compatibility for Symfony 3.1 up to 4.0
