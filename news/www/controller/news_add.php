<?php

// Проверка переданных данных
$title = "";
$content = "";
$category = "";
$importance = "2";
$id="";
$msg = [];
$add_ok = false ;
@include_once "classes/News.php" ;
if( ! class_exists( "News" ) ) 
	$msg[] = "Ошибка подключения класса News" ;
else {
$news = new News( ) ;
// $news->load_by_id( 1 ) ;echo $news->__dump();exit;
if( ! empty( $_POST ) ) {
	// Валидация данных
	if( empty( $_POST[ 'title' ] ) ) {
		$msg[] = "Необходимо указать заголовок" ;
	}
	if( empty( $_POST[ 'content' ] ) ) {
		$msg[] = "Необходимо указать текст статьи" ;
	}
	if( empty( $_POST[ 'category' ] ) ) {
		$msg[] = "Необходимо указать категорию" ;
	}
	if( empty( $_POST[ 'importance' ] ) ) {
		$msg[] = "Необходимо указать важность" ;
	}
	if( empty( $_FILES[ 'image' ][ 'name' ] ) )  // Наличие файла
		$msg[] = "Необходимо выбрать картинку" ;
	else {
		if( $_FILES[ 'image' ][ 'error' ] !== 0 )  // Ошибка передачи
			$msg[] = "Возникла ошибка передачи файла " . $_FILES[ 'image' ][ 'error' ] ;
		else {  // Перемещение из временной папки
			$fname = 
				"uploads/puc_"
				. $_FILES[ 'image' ][ 'name' ] ;
			@$move_status = move_uploaded_file(
				$_FILES[ 'image' ][ 'tmp_name' ] ,
				$fname
			) ;
			if( $move_status == false )
				$msg[] = "Возникла ошибка перемещения файла " . $fname ;
		}
	}
	if( ! empty( $msg ) ) {
		$title       = $_POST[ 'title' ]      ;
		$importance  = $_POST[ 'importance' ] ;
		$category    = $_POST[ 'category' ]   ;
		$content     = $_POST[ 'content' ]    ;
		$id			 = $_POST['id']           ;
	} else {
		
			$news->load_from_array( [
				'title_ru'      => $_POST[ 'title' ]      ,
				'content_ru'    => $_POST[ 'content' ]    ,
				'image_file'    => $fname                 ,
				'is_active'     => 0                      ,
				'views_cnt'     => 0                      ,
				'dt_create'     => date( "Y-m-d H:i:s" )  ,
				'id_category'   => $_POST[ 'category' ]   ,
				'id_author'     => 1                      ,
				'id_importance' => $_POST[ 'importance' ] ,
			] ) ;
// echo $news->__dump() ; exit ;
			try {
				$news->add_to_db( ) ;
				$add_ok = true ;
			} catch( Exception $ex ) {
				$msg[] = "Ошибка добавления новости: " . $ex->getMessage( ) ;
			}
		
	}
	 // echo "<pre>"; print_r( $_POST ) ; print_r( $_FILES ) ; exit ;
	
}
}
// Отображение
include "view/news_add_view.php" ;