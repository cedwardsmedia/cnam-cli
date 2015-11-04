<?php
// Start the session so we can save
// query results across pages requests.


session_start();

ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE);

require 'vendor/autoload.php';
require 'functions.inc.php';
include 'config.php';


define("APPNAME", "CNAM");
define("VERSION", "1.2");
define("DEVELOPER", "Corey Edwards");
