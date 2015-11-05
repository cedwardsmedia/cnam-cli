#!/usr/bin/php
<?php

// Bootstrap our app
require("bootstrap.inc.php");
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

//echo($_SERVER['argv']); exit();

   // Process our arguments and flags
   //$ARGS = ; // Get CLI arguments and flags

   $ARGS = $_SERVER['argv'];

   //print_r($ARGS); die();
   if ( array_key_exists("1",$ARGS) ) {

      // Check for help flags.
      if (in_array("--help", $ARGS) OR in_array("-h", $ARGS)){
            help();
         } elseif (in_array("--version", $ARGS) OR in_array("-v", $ARGS)){
      // Check for version flags
            version();
         } else {
            //echo($ARGS[1]); die();
            $phone = $ARGS[1];
            $api = new APICaller();
            $api->api_call($phone);


            /* Let's check for API errors. They'll be returned in
            $api->error. So if this variable is set, let's print the error and exit */

            // Print the error and die
            if ($api->error) { // If there's an error
               echo("Error: $api->error\n"); // Print it out
               exit(1); // Exit with status 1
            } else {

            /* If no error exists, let's check if any information was returned from EveryoneAPI. If not, we'll print an error and exit. If so, we'll print the dossier. */

            // Is the information available? If not, err and die
               if ($api->data->data->cnam == "Unavailable") {
                  echo("I'm sorry, but information for $phone is not available from EveryoneAPI.\n");
                  exit(0);
               } else {

            // No API errors and we have results from the API
            // Print Dossier
                     hr(); // Print a line
                     echo($api->data->data->cnam . "\n"); // Print the CNAM
                     hr(); // Print a line
            // Print Name
                     // Pick the title based on gender
                     if ($api->data->data->gender == "M"){$title = "Mr.";} elseif ($api->data->data->gender == "F"){$title = "Ms.";};
                     echo("Name:\n   " . $title ." " . $api->data->data->expanded_name->first . " " . $api->data->data->expanded_name->last ."\n\n");

                     // Print Address
                     echo("Address:\n   " . $api->data->data->address. "\n   " . $api->data->data->location->city . ", " . $api->data->data->location->state . " " . $api->data->data->location->zip . "\n\n");

                     // Print Gender
                     echo("Gender: ");
                     if ($api->data->data->gender == "M"){echo "Male";} elseif ($api->data->data->gender == "F"){echo "Female";};
                     echo "\n\n";

                     // Print Relationship
                     echo("Relationship:\n   " . $api->data->data->profile->relationship . "\n\n");

                     // Print Image
                     echo("Image:\n   http:" . $api->data->data->image->large . "\n\n");

                     // Print Job
                     echo("Job:\n   " . $api->data->data->profile->job . "\n\n");

                     // Print Education
                     echo("Edu:\n   " . $api->data->data->profile->edu . "\n\n");

                     // Print Linetype
                     echo("Linetype:\n   " . $api->data->data->linetype . "\n\n");

                     // Print Original Carrier
                     echo("Original Carrier:\n   " . $api->data->data->carrier_o->name . "\n\n");

                     // Print Current Carrier
                     echo("Current Carrier:\n   " . $api->data->data->carrier->name . "\n\n");

                     hr();
               }
            }
      }
   } else {
      usage();
   };

function hr() {
   $width = shell_exec('/usr/bin/tput cols');
   $x = 0;
   while ($x < $width) {
      echo "-";
      $x++;
   }
   echo "\n";
}
function usage() {
   echo("Usage: cnam [PHONE NUMBER]\n\nTry 'cnam  --help' for more options.\n");
   exit(0);
}

// Print version
function version() {
   echo APPNAME . " " . VERSION;
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
   echo("\n------------------------------------\n");
   echo($ARGS);
   exit(0);
}
