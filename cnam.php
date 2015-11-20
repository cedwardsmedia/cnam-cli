#!/usr/bin/php
<?php

// Bootstrap our app
require("bootstrap.inc.php");
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE);

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
            $phone = $ARGS[1];
            $api = new APICaller();
            $api->api_call($phone);


            /* Let's check for API errors. They'll be returned in
            $api->error. So if this variable is set, let's print the error and exit */

            // Print the error and die
            if ($api->error) { // If there's an error
               echo "Error: $api->error\n"; // Print it out
               exit(1); // Exit with status 1
            } else {

            /* If no error exists, let's check if any information was returned from EveryoneAPI. If not, we'll print an error and exit. If so, we'll print the dossier. */

            // Is the information available? If not, err and die
               if ($api->data->data->cnam == "Unavailable") {
                  echo "I'm sorry, but information for $phone is not available from EveryoneAPI.\n" ;
                  exit(0);
               } else {

            // No API errors and we have results from the API
            // Print Dossier
                     hr(); // Print a line
                     echo $api->data->data->cnam . "\n" ; // Print the CNAM
                     hr(); // Print a line
            // Print Name
                     // Pick the title based on gender
                     if ($api->data->data->gender == "M"){$title = "Mr.";} elseif ($api->data->data->gender == "F"){$title = "Ms.";}
                     echo "Name:\n   " . $title ." " . $api->data->data->expanded_name->first . " " . $api->data->data->expanded_name->last ."\n\n";

                     // Print Address
                     echo "Address:\n   " . $api->data->data->address. "\n   " . $api->data->data->location->city . ", " . $api->data->data->location->state . " " . $api->data->data->location->zip . "\n\n";

                     // Print Gender
                     echo "Gender: ";
                     if ($api->data->data->gender == "M"){echo "Male";} elseif ($api->data->data->gender == "F"){echo "Female";}
                     echo "\n\n";

                     // Print Relationship
                     echo "Relationship:\n   " . $api->data->data->profile->relationship . "\n\n";

                     // Print Image
                     echo "Image:\n   http:" . $api->data->data->image->large . "\n\n";

                     // Print Job
                     echo "Job:\n   " . $api->data->data->profile->job . "\n\n";

                     // Print Education
                     echo "Edu:\n   " . $api->data->data->profile->edu . "\n\n";

                     // Print Linetype
                     echo "Linetype:\n   " . $api->data->data->linetype . "\n\n";

                     // Print Original Carrier
                     echo "Original Carrier:\n   " . $api->data->data->carrier_o->name . "\n\n";

                     // Print Current Carrier
                     echo "Current Carrier:\n   " . $api->data->data->carrier->name . "\n\n";

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
   hr();
   echo "DEBUG INFORMATION:\n";
   hr();
   echo APPNAME . " " . VERSION . "\n";
   echo "Runtime Arguments:\n";
   print_r($_SERVER['argv']); // Print runtime arguments
   echo "\n";
   include("config.php"); // Check config values
   echo "Configuration:\n\nSID: $SID\nTOKEN: $TOKEN\n"; // Print API Credentials
   echo "EveryoneAPI Version: " . APIVersion . "\n";
   $git = shell_exec('git rev-parse HEAD');
   if ($git) {echo "Current Commit: " . substr($git,0,8) . "\n";}
   exit(0);
}
