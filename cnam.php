#!/usr/bin/php
<?php

// Bootstrap our app
require("bootstrap.inc.php");
ini_set('display_errors', 1);
error_reporting(E_ALL & E_NOTICE);

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
            print_r("Name: " . $api->data->data->expanded_name->first . " " . $api->data->data->expanded_name->last ."\n");
      }
   } else {
      usage();
   };


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
