<?php

// echo "<pre>" ; print_r( $_GET ) ; exit ;

$cmd = $_GET[ 'cmd' ] ?? 'users' ;

$lang = $_GET[ 'lang' ] ?? 'ua' ;

$txt_file_name = "txt_$lang.php" ;

if( is_readable( $txt_file_name ) ) {
	include $txt_file_name ;
} else {
	echo "Зазначена мова не підтримується!" ;
	exit ;
}

switch( $cmd ) {
	case 'users'    : include "admin_users.php" ;       break ;
	case 'edituser' : include "admin_user_edit.php" ;   break ;
	case 'news'     : $lang = 'ru' ; include "admin/news_review.php" ;	break ;
	case 'newsedit' : $lang = 'ru' ; include "admin/news_edit.php" ;	break ;
	
	default :
		echo "Зазначена команда не підтримується!" ;
		exit ;
}
