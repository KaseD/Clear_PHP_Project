<?php
session_start();
$lang = $_GET[ 'lang' ] ??"ru";
if( isset( $_GET[ 'logout' ] ) ) {
	unset( $_SESSION[ 'userid' ] ) ;
	$_SESSION['logged']="";
	header( "Location: /" ) ;
	exit ;
}
if( empty( $_GET[ 'dtl' ] ) ) {
	@include_once("../classes/News.php");
	if( ! class_exists( "News" ) ) 
		echo "Ошибка подключения класса News" ;
	else {
	$news = new News( ) ;
	$all_news = $news->get_all_news( ) ;

	}
	
		@include_once "../classes/user.php";
if(!empty($_SESSION[ 'userid' ]))
{
	if(!class_exists("User"))
		echo "Ошибка подключения класса User";
	
	else{
		$users= new User();
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

	
	
	include "../view/news_view.php";
	exit ;
}