<?php
if(empty($_GET['id']) or !isset($_GET['act'])){
	echo '{"status":"-1","descr":"Invalid"}';
	exit;
}

@include_once "../classes/News.php";
if(!class_exists("News")){
	echo '{ "status":"2","descr":"Ошибка подключения класса News"}';
	exit;
}
$news = new News();
$news->id=$_GET['id'];


try{
	$res=$news->set_active($_GET['act']);
}catch(PDOEception $ex){
	echo '{ "status":"-3","descr":"Ошибка запроса '.$ex->getMessage().'"}';
	exit;
}
if($res === false){
	echo '{ "status":"-4","descr":"Ошибка функции "}';
	exit;
}
echo '{"status":"1","descr":"Установлено"}';