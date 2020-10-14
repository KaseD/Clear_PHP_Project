<?php

@include_once "classes/News.php" ;

if( ! class_exists( "News" ) ) {
	echo "Ошибка подключения класса News" ;
	exit ;
}

$news = new News( ) ;

$all_news = $news->get_all_news( ) ;

// echo "<pre>"; print_r( $all_news ) ;

include "view/admin_news_view.php" ;
