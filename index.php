<?php
error_reporting(0);

require 'vendor/autoload.php';

use GuzzleHttp\Client;

// Account SID
$SID="AC2877277cd21a44af8e9344c53bb13119";
// AUTH Token
$TOKEN="AUe03f0c1796c04eed8d838061895b4534";

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
   $phone = intval(preg_replace("/[^0-9,.]/", "", $_POST["phone"]));


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
    <meta name="author" content="Corey Edwards">
      <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
      <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
      <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
      <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
      <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
      <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
      <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
      <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
      <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
      <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
      <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
      <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
      <link rel="manifest" href="/manifest.json">
      <meta name="msapplication-TileColor" content="#ffffff">
      <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
      <meta name="theme-color" content="#ffffff">


    <title>
      <?
      if (isset($data)) {
         echo "Dossier for ";
            if ($results['number']) {
               echo $results['number'];
            } else {
               echo $results['data']['expanded_name']['first'] . " " . $results['data']['expanded_name']['last'];
            }
         echo " provided by iCNAM";
     } else {
        echo "Reverse Phone Lookup powered by EveryoneAPI";
     }
     ?>
    </title>

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <!-- Custom styles for this template -->
    <link href="main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">
      function Set_Cookie( name, value, expires, path, domain, secure ) {
         // set time, it's in milliseconds
         var today = new Date();
         today.setTime( today.getTime() );

         /*
         if the expires variable is set, make the correct
         expires time, the current script below will set
         it for x number of days, to make it for hours,
         delete * 24, for minutes, delete * 60 * 24
         */
         if ( expires )
            {
            expires = expires * 1000 * 60 * 60 * 24;
            }
         var expires_date = new Date( today.getTime() + (expires) );

         document.cookie = name + "=" +escape( value ) +
         ( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) +
         ( ( path ) ? ";path=" + path : "" ) +
         ( ( domain ) ? ";domain=" + domain : "" ) +
         ( ( secure ) ? ";secure" : "" );
      }
    </script>

    </script>
  </head>

  <body>

   <div class="container">
         <nav class="navbar navbar-default navbar-fixed-top">
       <div class="container">
         <div class="navbar-header">
           <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
             <span class="sr-only">Toggle navigation</span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
           </button>
           <a class="navbar-brand" href="/">iCNAM</a>
         </div>
         <div id="navbar" class="navbar-collapse collapse">
           <ul class="nav navbar-nav">
             <li><a href="#" data-toggle="modal" data-target="#about"><i class="fa fa-info-circle fa-lg"></i> </a></li>
             <li><a href="#" data-toggle="modal" data-target="#settings"><i class="fa fa-cog fa-lg"></i> </a></li>
           </ul>
           <ul class="nav navbar-nav navbar-right">
             <li><a href="https://www.twitter.com/cedwardsmedia" target="_blank"><i class="fa fa-twitter-square fa-lg"></i></a></li>
             <li><a href="https://www.twitter.com/cedwardsmedia" target="_blank"><i class="fa fa-twitter fa-lg"></i></a></li>
             <li><a href="https://www.facebook.com/cedwardsmedia" target="_blank"><i class="fa fa-facebook-square fa-lg"></i></a></li>
           </ul>
         </div><!--/.nav-collapse -->
       </div>
     </nav>
   </div>

<? if (!isset($data)) { ?>
      <div class="cnam-header" id="content" tabindex="-1">
            <div class="container">
               <h1>
                  <span style="background-color: transparent;
border: 1px solid #CDBFE3; width: 144px; height: 144px; font-size: 108px; line-height: 140px; padding: 0 64px; border-radius: 10px;"><i class="fa fa-phone fa-stack-1x fa-inverse"></i></span>
               </h1>
              <p class="lead">Harness the power of EveryoneAPI to perform reverse<br /> phone lookups and harvest information.</p>

              <form class="form-inline" action="index.php" method="post">
                 <div class="form-group">
                 <label class="sr-only" for="Phone Number">Phone Number</label>
                 <div class="input-group input-group-lg">
                 <div class="input-group-addon">+1</div>
                 <input type="tel"   name="phone" class="form-control" id="phone" placeholder="Phone Number" title="A ten digit USA or CAN phone number." value="" required>
                 <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                 </span>
                 </div>
                 </div>
              </form>

            </div>
      </div>
<? }; ?>
      <div class="container">
      <div class="row marketing">
        <div class="col-lg-12">

<? if (isset($data)) { ?>
         <div class="alert alert-info alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <strong>Hey you!</strong><br />
            This query cost <? echo $cost; ?><br/ >
         </div>

         <? if (isset($results['note'])) {?>
         <div class="alert alert-warning alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <strong>Hey you!</strong><br />
            Note: <? echo $results['note']; ?>
         </div>
         <? } ?>

           <div class="panel panel-default">
            <div class="panel-heading"><button type="button" class="btn btn-default pull-right" onclick="window.print()"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></button><h4>Dossier for <b>
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

            <div class="text-center">
            <form class="form-inline" action="index.php" method="post">
               <div class="form-group">
               <label class="sr-only" for="Phone Number">Phone Number</label>
               <div class="input-group input-group-lg">
               <div class="input-group-addon">+1</div>
               <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone Number">
               <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
               </span>
               </div>
               </div>
            </form>
            </div>
<? }; ?>
        </div>
      </div>
   </div> <!-- /container -->
      <footer class="footer">
         <div class="container">
        <p><span class="pull-left">&copy; Corey Edwards 2015</span>

           <span class="text-muted pull-right">powered by <a href="https://www.everyoneapi.com/" target="_blank">EveryoneAPI</a></span></p>
         </div>
      </footer>

      <!-- Modal -->
      <div class="modal fade" id="settings" tabindex="-1" role="dialog" aria-labelledby="settingsLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="settingsLabel">EveryoneAPI Credentials</h4>
            </div>
            <div class="modal-body">
               <form class="form-horizontal" >
                  <div class="form-group">
                     <label for="inputSID" class="col-sm-2 control-label">SID</label>
                     <div class="col-sm-10">
                     <input type="text" class="form-control" id="inputSID" placeholder="EveryoneAPI SID">
                     </div>
                     </div>
                     <div class="form-group">
                     <label for="inputToken" class="col-sm-2 control-label">Password</label>
                     <div class="col-sm-10">
                     <input type="password" class="form-control" id="inputToken" placeholder="EveryoneAPI API Token">
                     </div>
                     </div>
                     <div class="form-group">
                     <div class="col-sm-offset-2 col-sm-10">
                     <div class="checkbox">
                     <label>
                     <input type="checkbox"> Remember me
                     </label>
                     </div>
                     <br />
                     <p class="text-muted">Your credentials will be saved to your browser using a cookie. They <strong>will</strong> be transmitted to the server with every request you make via iCNAM. However, your credentials are <strong>never stored</strong> on the server.</p>
                     </div>
                     </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
             </form>
            </div>
          </div>
        </div>
      </div>


      <!-- Modal -->
      <div class="modal fade" id="about" tabindex="-1" role="dialog" aria-labelledby="aboutLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="settingsLabel">About iCNAM</h4>
            </div>
            <div class="modal-body">
               <img src="apple-icon-120x120.png" alt="iCNAM Logo" class="pull-right" style="padding-right: 24px;">
               <h1>iCNAM <small>0.0.7</small></h1>
               <h3>Built by</h3>
               <h4>Corey Edwards <span class="text-muted">[Code &amp; Design]</span></h4>
               <h4>Brian Seymour <span class="text-muted">[Debugging]</span></h4>
               <br />
               <p class="text-muted text-center">iCNAM is an independent project and is not affiliated with or endorsed by EveryoneAPI.</p>


            <div class="modal-footer">
            </div>
          </div>
        </div>
      </div>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="https://cdn.jsdelivr.net/jquery/2.1.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.js"></script>
    <script src="https://cdn.jsdelivr.net/holder/2.7.1/holder.min.js"></script>
    <script>
      console.log("This query cost <? echo $cost; ?>");
      console.log("Note: <? echo $results['note']; ?>")
    </script>
    <script src="https://cdn.cedwardsmedia.com/public/credits.js"></script>
  </body>
</html>
