<?php
// echo "<pre>" ; print_r( $_POST ) ;
if( empty( $_POST ) ) {
	echo "No data" ;
	exit ;
}
$uid = intval( $_POST[ 'user_id'] ) ;
if( empty( $uid ) ) {
	echo "Invalid user ID" ;
	exit ;
}

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

if( empty( $_FILES[ 'image' ][ 'name' ] ) ) {
		echo "Выберите файл для аватарки" ;
		exit;
} else if( $_FILES[ 'image' ][ 'error' ] != 0 ) {
	echo "Возникли проблемы с загрузкой файла (возможно, превышен размер)" ;
	exit;
} else {
	try{$stat = $user->deletfile($user->avatar);}catch( Exception $ex ) {
		echo $ex->getMessage( ) ;
		exit ;
	}
	$fname = 
		$user->login 
		. "_ava." 
		. strtolower( pathinfo( $_FILES[ 'image' ][ 'name' ], PATHINFO_EXTENSION ) ) ;
	$move_status = move_uploaded_file(
		$_FILES[ 'image' ][ 'tmp_name' ], 
		"uploads/" . $fname
	) ;
	if( $move_status === false ) {
		echo "Возникли проблемы с сохранением файла" ;
		exit;
	} 
}

$user->first_name = $_POST[ 'user_name1' ] ;
$user->last_name  = $_POST[ 'user_name2' ] ;
$user->surname 	  = $_POST[ 'user_name3' ] ;
$user->role 	  = $_POST[ 'role' ] ;
$user->id         = $uid ;
$user->avatar     = $fname ;

try {
	$res = $user->update( ) ;
} catch( Exception $ex ) {
	echo $ex->getMessage( ) ;
	exit ;
}

if( $res === false ) {
	echo "Something gone wrong ..." ;
} else {
	header( 'Refresh: 5; URL=http://news.local/admin/users' ) ;
	echo "Update OK" ;
}
