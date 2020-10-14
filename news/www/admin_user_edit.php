<?php

// echo $_GET[ 'uid' ] ;
if(empty( $_GET[ 'uid'] ) ) {
	echo "No user id passed" ;
	exit ;
}
$uid = intval( $_GET[ 'uid'] ) ;

@include_once "classes/user.php" ;
if( ! class_exists( "User" ) ) {
	echo "User.php load error" ;
	exit ;
} 

try {
	$user = new User( ) ;
	$user->loadUserDataById( $uid ) ;
} catch( Exception $ex ) {
	echo $ex->getMessage( ) ;
	exit ;
}

include "admin_user_edit_view.php" ;
/*
echo $user->first_name 		,"<br>",
	 $user->last_name		,"<br>",
	 $user->surname 			,"<br>",
	 $user->login 			,"<br>",
	 $user->registered_time 	,"<br>",
	 $user->last_login 		,"<br>",
	 $user->role 			,"<br>",
	 $user->avatar 			
;
*/
