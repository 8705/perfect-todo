<?php

require '../bootstrap.php';
require '../PerfectApplication.php';
error_reporting(E_ALL);
$app = new PerfectApplication(true);
$app->run();
