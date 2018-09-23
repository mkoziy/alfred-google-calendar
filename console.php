<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Commands\QuickAddEventCommand;
use Symfony\Component\Console\Application;

define('ROOT_DIR', __DIR__);

$app = new Application();
$app->add(new QuickAddEventCommand());
$app->run();