<?php

include_once "send_res.php";
//print_r( $_GET) . "<pre>";
if(empty($_GET['uid'])){
	send_result(-1,'No user id');
	exit;
}

if(empty($_GET['nid'])){
	send_result(-1,'No news id');
	exit;
}
$news_id=intval($_GET['nid']);
/*
Load useR by id

Пока все равно посылаем на свою почту, потом будут юзер
*/
//Load news by id
@include_once "../classes/News.php";
if(!class_exists("News")){
	send_result(-4,'Ошибка подключения класса News');
	exit;
}
$news=new News();

if( ( $data=$news->load_by_id($news_id) ) === false ) {
	send_result(-5,'Новость не найдена');
	exit;
}


//send data via email

include "mail_ukrnet.php";
if(!function_exists("send_mail")){
	send_result(-6,'Ошибка подключения почтовых функций');
	exit;
}
send_mail($data);
echo "Отмылено";