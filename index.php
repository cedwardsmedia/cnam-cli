<?php
error_reporting(0);

require 'vendor/autoload.php';

use GuzzleHttp\Client;

// Account SID
//$SID="AC2877277cd21a44af8e9344c53bb13119";
// AUTH Token
//$TOKEN="AUe03f0c1796c04eed8d838061895b4534";

function init() {

}

function apicall($SID, $TOKEN, $phone) {
   $client = new Client([
       // Base URI is used with relative requests
       'base_uri' => 'https://api.everyoneapi.com/v1/phone/$phone?account_sid=$SID&auth_token=$TOKEN&pretty=true',
       'timeout'  => 4.0,
    ]);

    $response = $client->get("https://api.everyoneapi.com/v1/phone/$phone?account_sid=$SID&auth_token=$TOKEN&pretty=true");
    $code = $response->getStatusCode();
    $reason = $response->getReasonPhrase();

    if ($code != 200) {
      echo $code;
      echo $reason;
      die();
   } else {
      return $response->getBody();
   }

}

function parse($data) {

   global $results;
   $results = json_decode($data, true);

   global $cost;
   $cost = "$" . abs($results['pricing']['total']);

}

function put($what) {
   if (!$what) {
      return "Not Available";
   } else {
      return $what;
   }
}


if ($_POST["phone"] == "") {
   //echo "No number specified.";
   //die();
} else {
   $phone = $_POST["phone"];


$data = apicall($SID, $TOKEN, $phone);
parse($data);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Narrow Jumbotron Template for Bootstrap</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link href="main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

   <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation" class="active"><a href="#">Home</a></li>
            <li role="presentation"><a href="#">About</a></li>
            <li role="presentation"><a href="#">Contact</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">OpenCNAM.php</h3>
      </div>
   </div>

<? if (!isset($data)) { ?>
      <div class="cnam-header" id="content" tabindex="-1">
            <div class="container">
              <h1>Components</h1>
              <p>Over a dozen reusable components built to provide iconography, dropdowns, input groups, navigation, alerts, and much more.</p>

              <form class="form-inline" action="index.php" method="post">
               <div class="form-group">
               <label class="sr-only" for="exampleInputAmount">Phone Number</label>
               <div class="input-group">
               <div class="input-group-addon">+1</div>
               <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone Number">
               </div>
              </div><button type="submit" class="btn btn-primary btn-small">Lookup</button>
              </form>

            </div>
      </div>
<? }; ?>
      <div class="container">
      <div class="row marketing">
        <div class="col-lg-12">

<? if (isset($data)) { ?>
           <div class="panel panel-info">
            <div class="panel-heading"><h4>Dossier for <b>
               <?
                  if ($results['number']) {
                     echo $results['number'];
                  } else {
                     echo $results['data']['expanded_name']['first'] . " " . $results['data']['expanded_name']['last'];
                  }
               ?></b></h4></div>
               <div class="panel-body">
                  <dl class="text-left dl-horizontal pull-left">
                     <dt>Name</dt>
                     <dd><? echo $results['data']['expanded_name']['last'] . ", " . $results['data']['expanded_name']['first']; ?></dd>
                     <dt>Caller ID</dt>
                     <dd><? echo $results['data']['cnam']; ?></dd>
                     <dt>Gender</dt>
                     <dd><? echo $results['data']['gender']; ?></dd>
                     <dt>Line Provider</dt>
                     <dd><? echo $results['data']['line_provider']['name']; ?></dd>
                     <dt>Carrier</dt>
                     <dd><? echo $results['data']['carrier']['name']; ?></dd>
                     <dt>Original Carrier</dt>
                     <dd><? echo $results['data']['carrier_o']['name']; ?></dd>
                     <dt>Linetype</dt>
                     <dd><? echo $results['data']['linetype']; ?></dd>
                     <dt>Location</dt>
                     <dd><? echo $results['data']['location']['city']; ?>, <? echo $results['data']['location']['state']; ?> <? echo $results['data']['location']['zip']; ?></dd>
                     <dt>Education</dt>
                     <dd><? put($results['data']['edu']); ?></dd>
                     <dt>Employer</dt>
                     <dd><? echo $results['data']['job']; ?></dd>
                     <dt>Relationship</dt>
                     <dd><? echo $results['data']['relationship']; ?></dd>
                  </dl>

                  <img src="<? echo $results['data']['image']['large']; ?>" style="width: 140px; height: 140px; background-image url('holder.js/140x140?theme=gray&auto=yes&text=No%20Image')" alt="" class="img-thumbnail pull-right">
               </div>
            </div>

            <h2>Perform another lookup? </h2>
            <div class="text-center">
            <form class="form-inline" action="index.php" method="post">
               <div class="form-group">
               <label class="sr-only" for="exampleInputAmount">Phone Number</label>
               <div class="input-group">
               <div class="input-group-addon">+1</div>
               <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone Number">
               </div>
               </div><button type="submit" class="btn btn-primary btn-small">Lookup</button>
            </form>
            </div>
<? }; ?>
        </div>
      </div>

      <footer class="footer">
        <p>&copy; Company 2014</p>
      </footer>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="https://cdn.jsdelivr.net/holder/2.7.1/holder.min.js"></script>
    <script>
      console.log("This query cost <? echo $cost; ?>");
      console.log("Note: <? echo $results['note']; ?>")
    </script>
  </body>
</html>
