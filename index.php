<?php

session_start();

require "ClassLoader.php";

use App\App;

$app = new App();
$app->run();