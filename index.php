<?php
define('LANDING_SECRET_KEY', 'NzA2ZjMwY2Q2ZTdjOGM4MDI5ZTNmYTc5ZmM0MWRhMDRlNWM1YmNkNg=='); // Your landing secret key from panel.bemob.com -> Settings -> Tracker
define('SIGNATURE_TTL', '1 minute'); // How long signature should be valid. Valid formats are explained here: http://php.net/manual/en/datetime.formats.php
define('SIGNATURE_GET_PARAM', 'key'); // GET parameter with BeMob landing signature

$signature = isset($_GET[SIGNATURE_GET_PARAM]) ? rawurldecode($_GET[SIGNATURE_GET_PARAM]) : exit('Access denied');
if (!$signature = base64_decode($signature)) {
    exit('Access denied');
}
if (!$signature = json_decode($signature, true)) {
    exit('Access denied');
}
if (!isset($signature['timestamp']) || !isset($signature['hash'])) {
    exit('Access denied');
}
$signedHash = hash_hmac('sha1', $signature['timestamp'], LANDING_SECRET_KEY);
if ($signedHash !== $signature['hash'] || strtotime(SIGNATURE_TTL, $signature['timestamp']) < time()) {
    exit('Access denied');
}   
?><!DOCTYPE html>
<html>

<head>
    <title>BeMob Landing Signature Example</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">BeMob Landing Signature Example</a>
        </div>
    </div>
</nav>

<div class="container theme-showcase" role="main">
    <div class="jumbotron">
        <h1>BeMob Landing Signature Example</h1>
        <p>
            <a href="https://8vlr0.bemobtrk.com/click" id="ctaUrl" class="btn btn-success">Click me!</a>
        </p>
    </div>
</div>

</body>
</html>
