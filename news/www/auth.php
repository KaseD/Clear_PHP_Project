<?php

$msg = "" ;
	
if( ! empty( $_POST ) ) {
	$login = $_POST[ 'login' ] ;
	$pass  = $_POST[ 'pass'  ] ;
	
	if( empty( $login ) ) $msg = "Login is necessary" ;
	if( empty( $pass  ) ) $msg = "Password is necessary" ;
	
	if( empty( $msg ) ) {
		@include "classes/user.php" ;
		if( ! class_exists( "User" ) ) {
			$msg = "User.php load error" ;
		} else {
			try {
				$user = new User( ) ;
				session_start( ) ;
				if( $user->isAuthorized( $login, $pass ) ) {
					$_SESSION[ 'userid' ] = $user->id ;
					$_SESSION['logged'] = true;
					$user->update_last_login( ) ;
					
					header( "Location: /" ) ;
					exit ;
				} else {
					unset( $_SESSION[ 'userid' ] ) ;
					unset( $_SESSION[ 'logged' ] ) ;
					$msg = "Incorrect auth data" ;
				}
			} catch( Exception $ex ) {
				$msg = $ex->getMessage( ) ;
			}
		}
	}
} else {
	//$msg = "No POST data" ;
}

include "auth_view.php" ;
