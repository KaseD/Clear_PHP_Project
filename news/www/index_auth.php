<?php  
session_start( ) ;

if( isset( $_GET[ 'logout' ] ) ) {
	unset( $_SESSION[ 'userid' ] ) ;
	header( "Location: /" ) ;
	exit ;
}

if( empty( $_SESSION[ 'userid' ] ) ) {
	header( "Location: auth.php" ) ;
	exit ;
}

@include "user.php" ;
if( ! class_exists( "User" ) ) {
	echo "User.php load error" ;
	exit ;
} 
try {
	$user = new User( ) ;
	$user->loadUserDataById( $_SESSION[ 'userid' ] ) ;
} catch( Exception $ex ) {
	echo $ex->getMessage( ) ;
	exit ;
}
?>

<h1>Hello, <?=$user->first_name?> <?=$user->last_name?></h1>
<h2>Последний раз Вы авторизовались в системе <?=$user->last_login?></h2>
<img src="/uploads/<?=$user->avatar?>" />
<br/>
<a href="?logout">Log out</a>
<a href="#!">Редактировать анкету</a>
