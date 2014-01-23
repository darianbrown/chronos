# Chronos

Chronos is a simple abstraction layer for PHP's date and time functions with the aim of standardising using dates and times within an application.

## Current Build Status

[![Build Status](https://travis-ci.org/darianbrown/chronos.png)](https://travis-ci.org/darianbrown/chronos)

## Usage

### Creating a new instance of Chronos
```php
<?php

use Succinct\Chronos\Chronos;

// create a Chronos instance with date reference of yesterday
$chronos = Chronos::yesterday();

// create a Chronos instance with date reference of tomorrow
$chronos = Chronos::tomorrow();

// create a Chronos instance with date reference of today
$chronos = Chronos::today();

// create a Chronos instance with the current time
$chronos = new Chronos();

// create a Chronos instance with the following timestamp
$chronos = new Chronos(1347690188);

// create a Chronos instance matching the date string (any valid date string works)
$chronos = new Chronos('-3 weeks -1 day +2 hours');

````

### Displaying a date
```php
<?php

// echos Y-m-d (e.g. 2012-02-12)
echo $chronos->ymd() . PHP_EOL;

// echos Y-m-d (e.g. 2012/02/12)
echo $chronos->ymd('/') . PHP_EOL;

// displays current unix timestamp (e.g. 1347690188)
echo $chronos->timestamp() . PHP_EOL;

// display the current day (e.g. Tue)
echo $chronos->day() . PHP_EOL

```
