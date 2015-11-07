<?php
// Start the session so we can save
// query results across pages requests.

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

define("APPNAME", "CNAM");
define("VERSION", "1.3");
define("APIVersion", "1");
define("DEVGITHUB", "https://www.github.com/cedwardsmedia/cnam");
define("DEVELOPER", "Corey Edwards");
define("COPYRIGHTYEAR", "2014 - 2015");
define("COPYRIGHT", "&copy; " . COPYRIGHTYEAR . " " . DEVELOPER);

// Check which version of PHP we're using. If it's too old, die.
if (phpversion() < "5.5") {
   echo(APPNAME . " requires PHP 5.5 or greater. You are currently running PHP " . phpversion() . ". Please upgrade PHP.\n");
   exit(1);
   }

require 'vendor/autoload.php';
require 'APICaller.php';
include 'config.php';
