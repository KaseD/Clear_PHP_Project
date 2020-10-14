<?php

include "mail_ukrnet.php" ;

$res = send_mail( [
	'txtpart' => 'Func test'
] ) ;

echo $res ;
