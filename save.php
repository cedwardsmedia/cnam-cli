<?php

ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE);

$remember_me = $_GET['rememberme'];

$sid = $_POST['sid'];
$token = $_POST['token'];

if ($sid && $token) {
    if ($remember_me) {
        /* Set cookie to last 1 year */
        setcookie('sid', $sid, 60 * 60 * 24 * 365);
        setcookie('token', $token, 60 * 60 * 24 * 365);
    } else {
        /* Cookie expires when browser closes */
        setcookie('sid', $sid, false);
        setcookie('token', $token, false);
    }

    echo json_encode([
        'status' => 'ok',
        'payload' => [
            'message' => 'Credentials saved!'
        ]
    ]);
    exit;
} else {
    echo json_encode([
        'status' => 'error',
        'payload' => [
            'message' => 'Oops, something went wrong.'
        ]
    ]);
    exit;
}