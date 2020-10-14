<?php
function send_ans( $ans ) {
	$ret[ 'status' ] = $ans[ 0 ] ;
	$ret[ 'descr'  ] = $ans[ 1 ] ;
	echo json_encode( $ret ) ;
	exit ;
}

if( empty( $_GET[ 'login' ] ) ) {
	send_ans( [ -1, "no login" ] ) ;
}

// Regular expression
$reg_pattern = "~\W~i" ;  // pattern: <any_sym(~)>Expr<any_sym(~)>flags
if( preg_match (          // Поиск совпадений
		$reg_pattern ,    // Шаблон (выражение)
		$_GET[ 'login' ]  // Строка
	)
) {
	send_ans( [ -2, "non-word sym in login" ] ) ; 
}

@include "user.php" ;
if( ! class_exists( "User" ) ) {
	send_ans( [ -3, "User.php load error" ] ) ;  
} 
try {
	$user = new User( ) ;
	if( $user->isLoginFree( $_GET[ 'login' ] ) ) {
		send_ans( [ 1, "login free" ] ) ;
	} else {
		send_ans( [ -4, "login in use" ] ) ;
	}
} catch( Exception $ex ) {
	send_ans( [ -5, $ex->getMessage( ) ] ) ;
}
