<?php

if( empty( $_TXT ) ) {
	echo "Помилка визначення мови!" ;
	exit ;
}

// DB connection
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

// Users selection
$query = "SELECT * FROM Users" ;
try{
	$result = $DB->query( $query ) ;
} catch( PDOException $ex ) {
	echo $ex->getMessage( ) ;
	exit ;
}

$users = [ ] ;
while( $user = $result->fetch( PDO::FETCH_ASSOC ) ) {
	$users[] = $user ;
}
	
// Visualization
include "admin_user_view.php" ;
