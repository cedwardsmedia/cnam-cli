<?php
class APICaller {

   public $http;
   public $error;

   public $sid; // EveryoneAPI Account SID
   public $token; // EveryoneAPI Account Auth Token

   public $data;  // Query Results Array

   public $cost; // Query Cost

   function __construct() {


     $this->client = new \GuzzleHttp\Client();

     // Check config for credentials first. If they aren't set, then set them from the cookie. If neither is set, these vars will be null.
     include 'config.php';

     // Check for $SID first
     if ($SID) {
        $this->sid = $SID;
     } else {
     $this->sid   = $_COOKIE['sid']   ? $_COOKIE['sid']   : '';
     }

     // Check for $TOKEN
     if ($TOKEN) {
        $this->token = $TOKEN;
     } else {
     $this->token = $_COOKIE['token'] ? $_COOKIE['token'] : '';
     }
   }

   public function api_call($phone) {

      session_unset(); // Reset session variables for new query

      $phone = preg_replace('/[^0-9,.\+]/', '', $phone);

      if (!preg_match('/^(\+1)?[0-9]{10}$/', $phone)) {
         $this->error = 'Invalid phone number.';
         return null;
      }

      try {
         $response = $this->client
             ->get("https://api.everyoneapi.com/v1/phone/$phone?".
                 "account_sid={$this->sid}&".
                 "auth_token={$this->token}&");
      } catch (\Exception $exception) {
         if ($exception->getMessage() == 'Client error: 400') {
             $this->error = 'Bad request, doofus. Did you enter a real phone number?';
         } elseif ($exception->getMessage() == 'Client error: 401') {
             $this->error = 'You need to login, doofus. Did you set your credentials?';
         } else {
             $this->error = 'An unknown error occurred';
         }

         return null;
      }

      $this->data = json_decode($response->getBody());

      // Populate $_SESSION with results
      $_SESSION['firstname']= $this->data->data->expanded_name->first;
      $_SESSION['lastname']= $this->data->data->expanded_name->last;
      $_SESSION['gender']= $this->data->data->gender;
      $_SESSION['linetype']= $this->data->data->linetype;
      $_SESSION['image']= $this->data->data->image->large;
      $_SESSION['phone']= $phone;
      $_SESSION['city']= $this->data->data->location->city;
      $_SESSION['state']= $this->data->data->location->state;
      $_SESSION['zip']= $this->data->data->location->zip;
      return $this->data;
   }

   public function get_cost() {
      $this->cost = '$' . abs($this->data->pricing->total);

      return $this->cost;
   }

   public function get_title() {
      $title = '';

      if ($this->data) {
         $title = 'Dossier for ';
         if ($this->data->number) {
             $title .= $this->data->number;
         } else {
             $title .= $this->data->data->expanded_name->first . ' ' . $this->data->data->expanded_name->last;
         }
         $title .= ' provided by CNAM';
      } else {
         $title .= 'Reverse Phone Lookup powered by EveryoneAPI';
      }

      return $title;
   }

}

$api = new ApiCaller();
$_POST['phone'] && $api->api_call($_POST['phone']);
