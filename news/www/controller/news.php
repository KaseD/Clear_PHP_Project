<?php
// echo "News controller" ; echo "<pre>"; print_r( $_GET ) ;
	
	
// Если передана команда, ищем командный контроллер
session_start();
$lang = $_GET[ 'lang' ] ??"ru";
if( isset( $_GET[ 'logout' ] ) ) {
	unset( $_SESSION[ 'userid' ] ) ;
	$_SESSION['logged']="";
	header( "Location: /" ) ;
	exit ;
}

	include_once "classes/News.php" ;
if( empty( $_GET[ 'dtl' ] ) ) {
	if( ! class_exists( "News" ) ) 
		echo "Ошибка подключения класса News" ;
	else {
	$news = new News( ) ;
	$all_news = $news->get_all_news( ) ;

	}
	
		include_once "classes/user.php";
if(!empty($_SESSION[ 'userid' ]))
{
	if(!class_exists("User"))
		echo "Ошибка подключения класса User";
	
	else{
		$users = new User();
		$res=$users->loadUserDataById( $_SESSION[ 'userid' ] ) ;
		if($res!==true)
		{
			$users=null;
		}
	}
}
	if(isset($_POST['searchTxt']))
		if(!empty($news->search($_POST['searchTxt']))){
			$all_active_news = $news->search($_POST['searchTxt']);
		}else{
			$all_active_news = $news -> get_all_active();
		}
	else{
			$all_active_news = $news -> get_all_active();
		}

	
	
	include "view/news_view.php";
	exit ;
}



$cmd_controller = 
		"controller/news_" 
		. $_GET[ 'dtl' ]
		. ".php" ;

	if( is_readable( $cmd_controller ) )
		include $cmd_controller ;
else {
	echo "<h1 style='color:tomato;transform:rotate(20deg);margin-top:30vh;text-align:center'>404</h1>" ;
	exit ;
}