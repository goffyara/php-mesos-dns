php-mesos-dns
=========

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/1655b15adcc040ff841ba45d3533f39c)](https://www.codacy.com/app/goffyara/php-mesos-dns?utm_source=github.com&utm_medium=referral&utm_content=goffyara/php-mesos-dns&utm_campaign=badger)
[![Latest Stable Version](https://poser.pugx.org/goffyara/php-mesos-dns/v/stable)](https://packagist.org/packages/goffyara/php-mesos-dns)
[![Latest Unstable Version](https://poser.pugx.org/goffyara/php-mesos-dns/v/unstable)](https://packagist.org/packages/goffyara/php-mesos-dns)
[![License](https://poser.pugx.org/goffyara/php-mesos-dns/license)](https://packagist.org/packages/goffyara/php-mesos-dns)
[![Total Downloads](https://poser.pugx.org/goffyara/php-mesos-dns/downloads)](https://packagist.org/packages/goffyara/php-mesos-dns)
[![Monthly Downloads](https://poser.pugx.org/goffyara/php-mesos-dns/d/monthly)](https://packagist.org/packages/goffyara/php-mesos-dns)
[![Daily Downloads](https://poser.pugx.org/goffyara/php-mesos-dns/d/daily)](https://packagist.org/packages/goffyara/php-mesos-dns)

## Install

Either run

```sh
$ php composer.phar goffyara/php-mesos-dns "@dev"
```

or add

```sh
"goffyara/php-mesos-dns": "@dev"
```

to the ```require``` section of your `composer.json` file.

## Usage

available methods - api, dns

```php
use mesosdns\MesosDns;

$MesosDns = new MesosDns([
    'url' => 'http://mesos-dns-url:8123/v1/',
    'method' => 'api'
]);
```