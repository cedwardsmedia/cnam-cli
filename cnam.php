#!/usr/bin/php
<?php

// Turn off error reporting
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE);

// Define our constants
define("APPNAME", "CNAM");
define("VERSION", "1.4.0");
define("APIVersion", "1");
define("DEVGITHUB", "https://www.github.com/cedwardsmedia/cnam");
define("DEVELOPER", "Corey Edwards");
define("COPYRIGHTYEAR", "2014 - 2015");
define("COPYRIGHT", "&copy; " . COPYRIGHTYEAR . " " . DEVELOPER);
define("OS", strtoupper(php_uname('s')));

// Check which version of PHP we're using. If it's too old, die.
if (phpversion() < "5.3") {
   echo(APPNAME . " requires PHP 5.5 or greater. You are currently running PHP " . phpversion() . ". Please upgrade PHP.\n");
   exit(1);
}

// Determine our config path
if (OS == "DARWIN" || OS == "LINUX" || stristr(OS, "BSD") || stristr(OS, "UNIX")){
    define("CONFIGPATH", $_SERVER['HOME'] . DIRECTORY_SEPARATOR . ".cnam" . DIRECTORY_SEPARATOR);
} elseif (OS == stristr(OS, "WINDOWS")){
    define("CONFIGPATH", $_SERVER['HOMEDRIVE'] . $_SERVER['HOMEPATH'] . DIRECTORY_SEPARATOR . ".cnam" . DIRECTORY_SEPARATOR);
}

// Define our config file
define("CONFIGFILE", CONFIGPATH . "cnam.conf");

// Load our config
$config = parse_ini_file(CONFIGFILE);


// Include our Composer dependencies
require 'vendor/autoload.php';

   // Process our arguments and flags

   // Get CLI arguments and flags
   $ARGS = $_SERVER['argv'];

   //print_r($ARGS); die();
   if ( array_key_exists("1",$ARGS) ) {

      // Check for debug flag
      if (in_array("--debug", $ARGS) || in_array("-d", $ARGS)){
            debug();

      // Check for help flags.

         } elseif (in_array("--help", $ARGS) || in_array("-h", $ARGS)){
            help();
         } elseif (in_array("--version", $ARGS) || in_array("-v", $ARGS)){
      // Check for version flags
            version();
         } else {

      // Check for data point selection
            $data=array();
            if (in_array("--name", $ARGS)) { array_push($data,"name"); }
            if (in_array("--profile", $ARGS)){ array_push($data,"profile"); }
            if (in_array("--cnam", $ARGS)){ array_push($data,"cnam"); }
            if (in_array("--gender", $ARGS)){ array_push($data,"gender"); }
            if (in_array("--image", $ARGS)){ array_push($data,"image"); }
            if (in_array("--address", $ARGS)){ array_push($data,"address"); }
            if (in_array("--location", $ARGS)){ array_push($data,"location"); }
            if (in_array("--provider", $ARGS)){ array_push($data,"line_provider"); }
            if (in_array("--carrier", $ARGS)){ array_push($data,"carrier"); }
            if (in_array("--carrier_o", $ARGS)){ array_push($data,"carrier_o"); }
            if (in_array("--linetype", $ARGS)){ array_push($data,"linetype"); }

            // Check for test flag to set testing number
            if (in_array("--test", $ARGS) || in_array("-t", $ARGS)){
                $phone = "5551234567";
            } else {
                $phone = $ARGS[1];
            }

            $api = new EveryonePHP();
            $api->sid = $config["SID"];
            $api->token = $config["TOKEN"];
            $api->query($phone, $data);


            /* Let's check for API errors. They'll be returned in
            $api->error. So if this variable is set, let's print the error and exit */

            // Print the error and die
            if ($api->error) { // If there's an error
               echo "Error: $api->error\n"; // Print it out
               exit(1); // Exit with status 1
            } else {

            /* If no error exists, let's check if any information was returned from EveryoneAPI. If not, we'll print an error and exit. If so, we'll print the dossier. */

            // Is the information available? If not, err and die
               if ($api->results->data->cnam == "Unavailable") {
                  echo "I'm sorry, but information for $phone is not available from EveryoneAPI.\n" ;
                  exit(0);
               } else {

            // No API errors and we have results from the API
            // Print Dossier
                     hr(); // Print a line
                     echo $api->results->data->cnam . "\n" ; // Print the CNAM
                     hr(); // Print a line

                     // Print Name

                     if (isset($api->results->data->expanded_name)){
                         echo "Name: " . $api->results->data->expanded_name->first . " " . $api->results->data->expanded_name->last ."\n\n";
                     }

                     if (isset($api->results->data->location)){
                     // Print Address
                         echo "Address:\n   " . $api->results->data->address. "\n   " . $api->results->data->location->city . ", " . $api->results->data->location->state . " " . $api->results->data->location->zip . "\n\n";
                     }

                     if (isset($api->results->data->gender)){
                     // Print Gender
                         echo "Gender: ";
                         if ($api->results->data->gender == "M"){echo "Male";} elseif ($api->results->data->gender == "F"){echo "Female";}
                         echo "\n\n";
                     }

                     if (isset($api->results->data->image)){
                     // Print Image
                        if (isset($api->results->data->image->large)){echo "Image (large): http:".$api->results->data->image->large."\n";}
                        if (isset($api->results->data->image->cover)){echo "Image (cover): http:".$api->results->data->image->cover."\n";}
                        echo "\n";
                     }

                     if (isset($api->results->data->profile)){
                         // Print Relationship
                         if (isset($api->results->data->profile->relationship)){
                             echo "Relationship: " . $api->results->data->profile->relationship . "\n\n";
                         }

                         if (isset($api->results->data->profile->job)){
                         // Print Job
                             echo "Job: " . $api->results->data->profile->job . "\n\n";
                         }

                         if (isset($api->results->data->profile->edu)){
                         // Print Education
                             echo "Edu: " . $api->results->data->profile->edu . "\n\n";
                         }
                     }

                     if (isset($api->results->data->linetype)){
                     // Print Linetype
                        echo "Linetype: " . $api->results->data->linetype . "\n\n";
                     }

                     if (isset($api->results->data->carrier_o->name)){
                     // Print Original Carrier
                        echo "Original Carrier: " . $api->results->data->carrier_o->name . "\n\n";
                     }

                     if (isset($api->results->data->carrier->name)){
                     // Print Current Carrier
                        echo "Current Carrier: " . $api->results->data->carrier->name . "\n\n";
                     }

                     if (isset($api->results->data->line_provider->name)){
                     // Print Current Carrier
                        echo "Line Provider: " . $api->results->data->line_provider->name . "\n\n";
                     }
                     hr();
               }
            }
      }
   } else {
      usage();
   }

// Print horizontal line across terminal width
function hr() {
   $width = shell_exec('/usr/bin/tput cols');
   $x = 0;
   while ($x < $width) {
      echo "-";
      ++$x;
   }
   echo "\n";
}

// Print usage
function usage() {
   echo "Usage: cnam [PHONE NUMBER]\n\nTry 'cnam  --help' for more options.\n";
   exit(0);
}

// Print version
function version() {
   echo APPNAME . " " . VERSION . "\n";
   exit(0);
}

// Print Help
function help() {
   echo APPNAME . " " . VERSION . " by " . DEVELOPER . "\n";
   echo "© " . COPYRIGHTYEAR . " All Rights Reserved.\n\n";
   echo "Command-line client for EveryoneAPI.\nRun `cnam` without any arguments for usage information.\n";
   exit(0);
}

// Print Debug Info
function debug() {
    global $config;
    global $argv;
    hr();
    echo "DEBUG INFORMATION:\n";
    hr();
    echo APPNAME . " " . VERSION . "\n";
    echo "Runtime Arguments:\n";
    var_export($argv); // Print runtime arguments
    echo "\n";
    echo "Configuration:\n"; // Print API Credentials
    echo "Config file: " . CONFIGFILE . "\n";
    var_export($config);
    echo "\n";
    exit(0);
}
