<?php
if($_GET['act']=='p'){
	if(empty($_GET['id'])){
		echo '{ "status":"-1","descr":"Без ID не публикуем!"}';
		exit;
	}

	@include_once "../classes/News.php";
	if(!class_exists("News")){
		echo '{ "status":"2","descr":"Ошибка подключения класса News"}';
		exit;
	}
	$news = new News();

	try{
		$res=$news->publish_by_id($_GET['id']);
	}catch(PDOEception $ex){
		echo '{ "status":"-3","descr":"Ошибка запроса '.$ex->getMessage().'"}';
		exit;
	}
	if($res === false){
		echo '{ "status":"-4","descr":"Ошибка функции публикации"}';
		exit;
	}
	echo '{"status":"1","descr":"Опубликовано!"}';
}
else if($_GET['act']=='d'){
	if(empty($_GET['id'])){
		echo '{ "status":"-1","descr":"Без ID не снимаем с публикации!"}';
		exit;
	}

	@include_once "../classes/News.php";
	if(!class_exists("News")){
		echo '{ "status":"2","descr":"Ошибка подключения класса News"}';
		exit;
	}
	$news = new News();

	try{
		$res=$news->depublish_by_id($_GET['id']);
	}catch(PDOEception $ex){
		echo '{ "status":"-3","descr":"Ошибка запроса '.$ex->getMessage().'"}';
		exit;
	}
	if($res === false){
		echo '{ "status":"-4","descr":"Ошибка функции снятия с публикации"}';
		exit;
	}
	echo '{"status":"1","descr":"Снято с публикации!"}';
}