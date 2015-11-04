<?php
    // Start the session so we can save
    // query results across pages requests.
    session_start();

    ini_set('display_errors', 0);
    error_reporting(E_ALL & ~E_NOTICE);

    require 'vendor/autoload.php';

    class ApiCaller {

        public $http;
        public $error;

        public $sid;
        public $token;

        public $data;

        public $cost;

        function __construct() {
            $this->client = new \GuzzleHttp\Client();

            $this->sid   = $_COOKIE['sid']   ? $_COOKIE['sid']   : '';
            $this->token = $_COOKIE['token'] ? $_COOKIE['token'] : '';
        }

        public function api_call($phone) {

            session_unset(); // Reset session variables for new query

            $phone = preg_replace('/[^0-9,.\+]/', '', $phone);

            if (!preg_match('/^(\+1)?[0-9]{10}$/', $phone)) {
                $this->error = 'Phone not in the proper format';
                return null;
            }

            try {
                $response = $this->client
                    ->get("https://api.everyoneapi.com/v1/phone/$phone?".
                        "account_sid={$this->sid}&".
                        "auth_token={$this->token}&".
                        "pretty=true");
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
    <link rel="apple-touch-icon" sizes="57x57" href="assets/icons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/icons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/icons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/icons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/icons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/icons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/icons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/icons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="assets/icons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/icons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/icons/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/icons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">


    <title><?php echo $api->get_title(); ?></title>

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

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
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">CNAM</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="#" data-toggle="modal" data-target="#about"><i class="fa fa-info-circle fa-lg"></i> </a></li>
                    <li><a href="#" data-toggle="modal" data-target="#settings"><i class="fa fa-cog fa-lg"></i> </a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="https://www.twitter.com/cedwardsmedia" target="_blank"><i class="fa fa-twitter fa-lg"></i></a></li>
                    <li><a href="https://www.facebook.com/cedwardsmedia" target="_blank"><i class="fa fa-facebook fa-lg"></i></a></li>
                    <li><a href="https://www.github.com/cedwardsmedia" target="_blank"><i class="fa fa-github fa-lg"></i></a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
</div>

<?php if (!$api->data) { ?>
    <div class="cnam-header hero" id="content" tabindex="-1">
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
                        <input type="tel" name="phone" class="form-control" id="phone" placeholder="5551234567" title="A ten digit USA or CAN phone number." value="" required>
                 <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                 </span>
                    </div>
                </div>
            </form>

        </div>
    </div>
<?php }; ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12" style="text-align: center;">
            <?php if ($api->error) { ?>
                <div class="alert alert-danger">
                    <?php echo $api->error; ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php if ($api->data) { ?>
<div class="container">
    <div class="row marketing">
        <div class="col-lg-12">
            <div class="alert alert-info alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <strong>Hey you!</strong><br />
                This query cost <?php echo $api->get_cost(); ?><br/ >
            </div>

            <?php if ($api->data->note) { ?>
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Hey you!</strong><br />
                    Note: <?php echo $api->data->note; ?>
                </div>
            <?php } ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="btn btn-default pull-right tools" onclick="window.print()">
                        <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                    </button>
                    <a href="vcard.php"><button class="btn btn-default pull-right tools"><span class="glyphicon glyphicon-book" aria-hidden="true"></span></button></a>
                    <h4>
                        Dossier for
                        <b>
                            <?php
                                if ($api->data->number) {
                                    echo $api->data->number;
                                } else {
                                    echo $api->data->data->expanded_name->first . " " . $api->data->data->expanded_name->last;
                                }
                            ?>
                        </b>
                    </h4>
                </div>
                <div class="panel-body">
                    <dl class="text-left dl-horizontal pull-left">
                        <dt>Name</dt>
                        <dd><?php echo $api->data->data->expanded_name->last . ", " . $api->data->data->expanded_name->first; ?></dd>
                        <dt>Caller ID</dt>
                        <dd><?php echo $api->data->data->cnam; ?></dd>
                        <dt>Gender</dt>
                        <dd><?php echo $api->data->data->gender; ?></dd>
                        <dt>Line Provider</dt>
                        <dd><?php echo $api->data->data->line_provider->name; ?></dd>
                        <dt>Carrier</dt>
                        <dd><?php echo $api->data->data->carrier->name; ?></dd>
                        <dt>Original Carrier</dt>
                        <dd><?php echo $api->data->data->carrier_o->name; ?></dd>
                        <dt>Linetype</dt>
                        <dd><?php echo $api->data->data->linetype; ?></dd>
                        <dt>Location</dt>
                        <dd><?php echo $api->data->data->location->city; ?>, <?php echo $api->data->data->location->state; ?> <?php echo $api->data->data->location->zip; ?></dd>
                        <dt>Education</dt>
                        <dd><?php echo $api->data->data->profile->edu; ?></dd>
                        <dt>Employer</dt>
                        <dd><?php echo $api->data->data->profile->job; ?></dd>
                        <dt>Relationship</dt>
                        <dd><?php echo $api->data->data->profile->relationship; ?></dd>
                    </dl>

                    <img src="<?php echo $api->data->data->image->large; ?>" style="width: 140px; height: 140px; background-image url('holder.js/140x140?theme=gray&auto=yes&text=No%20Image')" alt="" class="img-thumbnail pull-right">
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
        </div>
    </div>
</div>
<?php }; ?>
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
                <div id="CredentialsStatus" class="alert alert-danger well-sm" style="display: none;"></div>

                <div class="form-group" style="margin-top: 20px;">
                    <div class="row">
                        <label for="SID" class="col-sm-2 control-label">SID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="sid" placeholder="EveryoneAPI SID" value="<?php echo $api->sid; ?>" name="SID">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label for="token" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="token" placeholder="EveryoneAPI API" name="token" value="<?php print_r(str_repeat("*",strlen($api->token))); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="rememberme"> Remember me
                                </label>
                            </div>
                            <br />
                            <p class="text-muted">Your credentials will be saved to your browser using a cookie. They <strong>will</strong> be transmitted to the server with every request you make via CNAM. However, your credentials are <strong>never stored</strong> on the server.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="save_creds();">Save changes</button>
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
                <h4 class="modal-title" id="settingsLabel">CNAM v1.0&#946;</h4>
            </div>
            <div class="modal-body">
                <div class="codelove text-center">
                   <i class="fa fa-code"></i> <i class="fa fa-plus text-math"></i> <i class="fa fa-heart"></i> <i class="fa fa-times text-math"></i> <a href="https://www.cedwardsmedia.com"><img src="https://avatars0.githubusercontent.com/u/1514767?v=3&s=48" alt="Corey Edwards"></a> <i class="fa fa-plus text-math"></i> <a href="https://bri.io/"><img src="https://avatars2.githubusercontent.com/u/4989650?v=3&s=48" alt="Brian Seymour"></a>
                </div>
                <hr>
                <p class="text-muted text-center">CNAM is an independent project and is not affiliated with or endorsed by EveryoneAPI.</p>


                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery/2.1.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.js"></script>
    <script src="https://cdn.jsdelivr.net/holder/2.7.1/holder.min.js"></script>
    <script src="https://cdn.cedwardsmedia.com/public/credits.js"></script>
</body>
</html>
