<?php

if( empty( $_GET[ 'id' ] ) ) {
	echo '{ "status":"-1", "descr":"Без ID не удаляем!"}' ;
	exit ;
}

@include_once "../classes/News.php" ;

if( ! class_exists( "News" ) ) {
	echo '{ "status":"-2", "descr":"Ошибка подключения класса News"}' ;
	exit ;
}

$news = new News( ) ;

try{
	$res = $news->delete_by_id( $_GET[ 'id' ] ) ;
} catch( PDOException $ex) {
	echo '{ "status":"-3", "descr":"Ошибка запроса '
		.$ex->getMessage( )
		.'"}' ;
	exit ;
}

if( $res === false ) {
	echo '{ "status":"-4", "descr":"Ошибка функции удаления"}' ;
	exit ;
}	

echo '{ "status":"1", "descr":"Удалено"}' ;
