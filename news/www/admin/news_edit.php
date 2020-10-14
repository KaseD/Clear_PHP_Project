<?php

// echo "<pre>" ; print_r( $_GET ) ;

if( empty( $_GET[ 'dtl' ] ) ) {
	echo "Недостаточно данных" ;
	exit ;
}

$news_id = intval( $_GET[ 'dtl' ] ) ;
if( empty( $news_id ) ) {
	echo "Неправильные данные" ;
	exit ;
}

@include_once "classes/News.php" ;
if( ! class_exists( "News" ) ) {
	echo "Ошибка подключения класса News" ;
	exit ;
}

$news = new News( ) ;
if( $news->load_by_id( $news_id ) === false ) {
	echo "Новость не найдена" ;
	exit ;
}


$add_ok = false ;

if(!empty($_POST)){ //  Нажата кнопка обновления
	$updated_data=[];
	$msg=[];
	if(!empty($_POST['title'])){$updated_data['title_ru']=trim($_POST['title']);}
	if(!empty($_POST['content'])){$updated_data['content_ru']=trim($_POST['content']);}
	if(!empty($_POST['category'])){$updated_data['id_category']=intval($_POST['category']);}
	if(!empty($_POST['importance'])){$updated_data['id_importance']=intval($_POST['importance']);}
	if(!empty($_FILES[ 'image' ][ 'name' ] ) ){  // Наличие файла
		if( $_FILES[ 'image' ][ 'error' ] !== 0 )  // Ошибка передачи
			$msg[] = "Возникла ошибка передачи файла " . $_FILES[ 'image' ][ 'error' ] ;
		else {  // Перемещение из временной папки
				try{$stat = $news->deletfile($news->image_file);}catch( Exception $ex ) {
				$msg[] = $ex->getMessage( ) ;
				exit ;
			}
			$fname = 
				"puc_"
				. $_FILES[ 'image' ][ 'name' ] ;
			@$move_status = move_uploaded_file(
				$_FILES[ 'image' ][ 'tmp_name' ], 
				"uploads/" . $fname
			) ;$updated_data['image_file']=$fname;
			if( $move_status == false )
				$msg[] = "Возникла ошибка перемещения файла " . $fname ;
		}
	}
	if(empty($msg)){
		try{
			$res=$news->update_in_db($updated_data);
		} catch( Exception $ex ) {
				$msg[] = "Ошибка сохранения новости: " . $ex->getMessage( ) ;
		}
		if($res===false)
			$msg[] = "Ошибка обновления новости";
		else
			$add_ok=true;
	}
}


$workmode = "edit" ;

$title = $news->title_ru;
$content = $news->content_ru;
$category = $news->id_category;
$importance = $news->id_importance;
$img=$news->image_file;
@include_once "classes/user.php";
if(!class_exists("User")){
	echo "Ошибка подключения класса User";
	exit;
}
$user=new User();
$user->loadUserDataById($news->id_author);
include "view/news_add_view.php" ;
