<?php

use MuhammadSaim\CloudBox;

require_once "./vendor/autoload.php";
require_once "./src/CloudBox.php";

$cloudbox = new CloudBox( "API_TOKEN" );

echo "<pre>";
var_dump( $cloudbox->albums( 1, 4 ) );