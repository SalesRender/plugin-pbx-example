<?php
use SalesRender\Plugin\Core\PBX\Factories\WebAppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$factory = new WebAppFactory();
$application = $factory->build();
$application->run();