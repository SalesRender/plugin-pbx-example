#!/usr/bin/env php
<?php

use SalesRender\Plugin\Core\PBX\Factories\ConsoleAppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap.php';

$factory = new ConsoleAppFactory();
$application = $factory->build();
$application->run();