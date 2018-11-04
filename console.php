<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Commands\EventsDailyListCommand;
use App\Commands\QuickAddEventCommand;
use Symfony\Component\Console\Application;

define('ROOT_DIR', __DIR__);

$app = new Application();
$app->add(new QuickAddEventCommand());
$app->add(new EventsDailyListCommand());
$app->run();