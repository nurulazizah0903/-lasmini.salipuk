<?php

//header("Content-Type: image/png");
require "vendor/autoload.php";

$qrcode = new \Endroid\QrCode\QrCode($_GET['text']);

echo $qrcode->writeString();
die();