<?php

@include "user.php" ;

if( ! class_exists( "User" ) ) {
	$msg = "User.php load error" ;
	exit ;
} 

try {
	$user = new User( ) ;
	$salt = md5( rand( ) ) ;
	$pass = hash( 'SHA256', '123' . $salt ) ;
	/*
	// Проверка передачи данных по массиву
	$user->register_user( [
		'first_name' => 'Акакий',
		'last_name'  => 'Петрович',
		'surname'    => 'Кисляков',
		'login'      => 'user_1',
		'pass_hash'  => $pass,
		'pass_salt'  => $salt,
		'avatar'     => 'admin_ava.png'
	] ) ;
	*/
	// Проверка передачи данных через поля объекта
	$user->first_name = 'Жан-Поль' ;
	$user->last_name  = 'Николаевич' ;
	$user->surname    = 'Пискунов' ;
	$user->login      = 'user_2' ;
	$user->pass_hash  = $pass ;
	$user->pass_salt  = $salt ;
	$user->avatar     = 'admin_ava.png' ;
	$user->register_user( ) ;
	
} catch( Exception $ex ) {
	echo  $ex->getMessage( ) ;  // ,"<BR>",$query;
	exit ;
}

echo "Done" ;
