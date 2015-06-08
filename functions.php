<?php

function init() {

}

global function apicall($phone) {
   $call = curl_init("https://api.everyoneapi.com/v1/phone/$phone?account_sid=$SID&auth_token=$TOKEN&pretty=true");

   $response = curl_exec($call);
   curl_close($call);

   echo $response;
}

function parse($results) {

}

?>
