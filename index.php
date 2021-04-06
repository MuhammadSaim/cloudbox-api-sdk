<?php
require_once "./vendor/autoload.php";
require_once "./CloudBox.php";
use MuhammadSaim\CloudBox\CloudBox;

$cloudbox = new CloudBox( "esJP0tHUgaJeCIXfLs9mcQoGtuHxfcXicDlHL5d8" );

echo "<pre>";
var_dump( $cloudbox->videoUpload( "/home/muhammadsaim/Downloads/SampleVideo_1280x720_1mb.mp4", 2 ) );