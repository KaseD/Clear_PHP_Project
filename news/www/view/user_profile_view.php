<?php
include "../classes/user.php";
$user=new User();
session_start();
$user->loadUserDataById( $_SESSION[ 'userid' ] );
?>
<!doctype html />
<html>
<head>

<link rel="stylesheet" href="/bootstrap.min.css" />
<style>
body{
	background:#def;
}
</style>
</head>
<body> 
<h1>
Профиль пользователя <?=$user->login;?>
</h1>
<img src="/uploads/<?=$user->avatar?>" style="height:250px;width:auto;margin-bottom:10px;"/><br />
<label style="font-size:24px;">
Полное ФИО : <?=$user->first_name;?>  <?=$user->last_name;?>  <?=$user->surname;?>
</label><br />
<label style="font-size:20px;">Дата регистрации : <?=$user->registered_time;?></label><br />
<label style="font-size:20px;">Почта : <?=$user->email;?></label><br />
<a href="edit_profile_view.php" class="btn btn-secondary" style="color:white;">Редактировать</a>
 <a href="/" class="btn btn-secondary" style="color:white;">На главную</a>

<script src="/jquery-3.3.1.min.js"></script>
<script src="/bootstrap.min.js"></script>
</body>
</html>