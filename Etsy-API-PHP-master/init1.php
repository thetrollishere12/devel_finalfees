<?php

// Require main class file
require_once( 'class.php' );


// Pass decoded config file to our class
$vals = json_decode( file_get_contents('values.json'), true );
$etsyauth = new EtsyAuth($vals);


// Call method
$etsyauth->etsyGetRequestToken();