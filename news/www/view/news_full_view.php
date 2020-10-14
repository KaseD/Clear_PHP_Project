<?php
include_once "../classes/News.php";
$news = new News();
$news->seeNews($_GET['id']);
$data=$news->load_by_id($_GET['id']);
?>
<!doctype html />
<html>
<head>

<link rel="stylesheet" href="/bootstrap.min.css" />
</head>
<body> 
<h1><?=$data['title_ru']?></h1>
<img src="../<?=$data['image_file']?>" style = "height:240px;width:auto;" /><br />
<p><?=$data['content_ru']?></p><br />
Просмотров : <?=$data['views_cnt']?><br />
 <a href="/" class="btn btn-secondary" style="color:white;">На главную</a>

<script src="/jquery-3.3.1.min.js"></script>
<script src="/bootstrap.min.js"></script>
</body>
</html>