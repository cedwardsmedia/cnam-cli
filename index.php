<?php
error_reporting(E_ALL);

require 'vendor/autoload.php';

// Account SID
$SID="AC2877277cd21a44af8e9344c53bb13119";
// AUTH Token
$TOKEN="AUe03f0c1796c04eed8d838061895b4534";

function init() {

}

function apicall($SID, $TOKEN, $phone) {

   use GuzzleHttp\Client;

   $client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://api.everyoneapi.com/v1/phone/$phone?account_sid=$SID&auth_token=$TOKEN&pretty=true',
    // You can set any number of default request options.
    'timeout'  => 2.0,
    ]);




   //echo "Header: " . $header . "<br/>";
   //echo "Body: " . $body;

   $response = $body;
   return $response;
}

function parse($data) {
   $jsonIterator = new RecursiveIteratorIterator(
       new RecursiveArrayIterator(json_decode($data, TRUE)),
       RecursiveIteratorIterator::SELF_FIRST);

   foreach ($jsonIterator as $key => $val) {
       if(is_array($val)) {
           echo "$key:\n";
       } else {
           echo "$key => $val\n";
       }
   }
}

$phone = $_GET["phone"];

$data = apicall($SID, $TOKEN, $phone);
parse($data);
?>
