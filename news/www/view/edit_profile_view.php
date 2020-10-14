<?php
include "../classes/user.php";
$user=new User();
session_start();
$user->loadUserDataById( $_SESSION[ 'userid' ] );
?>
<!doctype html />
<html>
<head>
<title>Profile edit</title>
<link rel="stylesheet" href="/bootstrap.min.css" />
<style>
form img {
	height: 300px;
	width:  auto;
	float:  left;
}
form input{
	margin-top:5px;
	margin-bottom:5px;
}
</style>
</head>
<body> 
	<form method="POST" enctype="multipart/form-data" action="../profile_save.php">
		<h1>Редактирование профиля</h1>
		<label for='img_file'><img src="/uploads/<?=$user->avatar; ?>" /></label>
		<h2 id="user_login"></h2>
		Login:  <input name="login" id="login_inp" /><i id="logCheckResult"></i><input type="button" class="btn btn-info" onclick="checkLogin()" value="Check for free" />
		<br/>
		First name:  <input name="user_name1" /><br/>
		Last  name:  <input name="user_name2" /><br/>
		Surname:     <input name="user_name3" /><br/>
		eMail:     <input name="email" /><br/>
		Pass : <input name="pass1" /><br />
		rePass : <input name="pass2" /><br />
		File:
		<input type="file"   name="image" id="img_file" />
						<input type="hidden" name="MAX_FILE_SIZE" value="<?=2**22?>" /><br />
		<input type="hidden" name="user_id"  />
		<input type="submit" value="Save changes" />
		<a href="/view/user_profile_view.php" class="btn btn-secondary" style="color:white;">Назад</a>
		<a href="/" class="btn btn-secondary" style="color:white;">На главную</a>
	</form>
<script src="/jquery-3.3.1.min.js"></script>
<script src="/bootstrap.min.js"></script>
<script>
$(document).ready( function() {
	$("#user_login").text("<?= $user->login ?>");
	$("input[name='user_name1']").val("<?= $user->first_name ?>");
	$("input[name='user_name2']").val("<?= $user->last_name ?>");
	$("input[name='user_name3']").val("<?= $user->surname ?>");
	$("input[name='user_id']"   ).val("<?= $user->id ?>");
	$("input[name='login']"   ).val("<?= $user->login ?>");
	$("input[name='email']"   ).val("<?= $user->email ?>");
});
checkLogin = ()=>{
	var logTxt = login_inp.value;
	var x = new XMLHttpRequest();
	x.onreadystatechange = ()=>{
		if(x.readyState == 4) {
			var res = JSON.parse(x.responseText);
			switch(res['status']){
				case 1:
					logCheckResult.innerText = "Свободен";
					break;
				case -1:
					logCheckResult.innerText = "Логин не может быть пустым";
					break;
				case -2:
					logCheckResult.innerText = "Логин содержит недопустимые символы";
					break;
				case -4:
					logCheckResult.innerText = "Логин занят";
					break;
				default:
					logCheckResult.innerText = "Шото пошло не так..."
			}
		}
	}
	x.open("GET","../check_login.php?login="+logTxt, true);
	x.send(null);	
}
</script>
</body>
</html>