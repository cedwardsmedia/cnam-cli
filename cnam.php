#!/usr/bin/php
<?php

// Bootstrap our app
require("bootstrap.inc.php");
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

//print_r($_SERVER['argv']); exit();

   // Process our arguments and flags
   //$ARGS = ; // Get CLI arguments and flags

   $ARGS = $_SERVER['argv'];

   if ( $ARGS > 0 ) {

      // Check for help flags.
      if (in_array("--help", $ARGS) OR in_array("-h", $ARGS)){
            help();
         } else {
            //print_r($ARGS[1]); die();
            $phone = $ARGS[1];
            $api = new APICaller();
            $api->api_call($phone);

            // Print Dossier
            hr();
            print_r($api->data->data->cnam . "\n");
            hr();
            // Print Name
            if ($api->data->data->gender == "M"){$salutation = "Mr.";} elseif ($api->data->data->gender == "F"){$salutation = "Ms.";};
            print_r("Name:\n   " . $salutation ." " . $api->data->data->expanded_name->first . " " . $api->data->data->expanded_name->last ."\n\n");

            // Print Address
            print_r("Address:\n   " . $api->data->data->address. "\n   " . $api->data->data->location->city . ", " . $api->data->data->location->state . " " . $api->data->data->location->zip . "\n\n");

            // Print Gender
            echo("Gender: ");
            if ($api->data->data->gender == "M"){echo "Male";} elseif ($api->data->data->gender == "F"){echo "Female";};
            echo "\n\n";

            // Print Relationship
            print_r("Relationship:\n   " . $api->data->data->profile->relationship . "\n\n");

            // Print Image
            print_r("Image:\n   http:" . $api->data->data->image->large . "\n\n");

            // Print Job
            print_r("Job:\n   " . $api->data->data->profile->job . "\n\n");

            // Print Education
            print_r("Edu:\n   " . $api->data->data->profile->edu . "\n\n");

            // Print Linetype
            print_r("Linetype:\n   " . $api->data->data->linetype . "\n\n");

            // Print Original Carrier
            print_r("Original Carrier:\n   " . $api->data->data->carrier_o->name . "\n\n");

            // Print Current Carrier
            print_r("Current Carrier:\n   " . $api->data->data->carrier->name . "\n\n");

            hr();

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
   print_r("Usage: cnam [OPTIONS]... [PHONE NUMBER]...\n\nTry 'cnam  --help' for more options.\n");
   exit(0);
}

// Print Help
function help() {
   echo "Help goes here\n";
   exit(0);
}

// Print Debug Info
function debug() {
   print_r("\n------------------------------------\n");
   print_r($ARGS);
   exit(0);
}
