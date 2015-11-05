<?php
// Start the session so we can save
// query results across pages requests.


session_start();

ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE);

require 'vendor/autoload.php';
require 'APICaller.php';
include 'config.php';


define("APPNAME", "CNAM");
define("VERSION", "1.3");
define("DEVGITHUB", "https://www.github.com/cedwardsmedia/cnam");
define("DEVELOPER", "Corey Edwards");
define("COPYRIGHTYEAR", "2014 - 2015");
define("COPYRIGHT", "&copy; " . COPYRIGHTYEAR . " " . DEVELOPER);
