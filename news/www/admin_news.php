<?php
	unset( $db_type ) ;

@include "db_ini.php" ;

if( empty( $db_type ) ) {
	echo "Config load error" ;
	exit ;
}

$conStr = "$db_type:host=$db_host;dbname=$db_name;charset=$db_enc;";

try{
	$DB = new PDO($conStr, $db_user, $db_pass);
	$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch( PDOException $ex ) {
	echo $ex->getMessage( ) ;
	exit ;
}


?>