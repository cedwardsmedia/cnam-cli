<?php
/* These are our valid username and passwords */

if (isset($_GET['SID']) && isset($_GET['token'])) {

        if (isset($_GET['rememberme'])) {
            /* Set cookie to last 1 year */
            setcookie('SID', $_GET['SID'], time()+60*60*24*365, '/', 'localhost');
            setcookie('token', $_GET['token'], time()+60*60*24*365, '/', 'localhost');

        } else {
            /* Cookie expires when browser closes */
            setcookie('SID', $_GET['SID'], false, '/', 'localhost');
            setcookie('token', $_GET['token'], false, '/', 'localhost');
        }
        print_r ("Credentials saved!"); ?>
<?
} else {
    echo 'Oops, something went wrong.';
}
echo "<br>";
echo "SID is: " . $_GET["SID"];
echo "<br>";
echo "Token is: " . $_GET["token"];
?>
