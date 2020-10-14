<!doctype html />
<html>
<head>

<link rel="stylesheet" href="/bootstrap.min.css" />
<style>
body{
	background:URL(../puc/back2.jpg);
	color:yellow;
}
	span {
		display: inline-block ;
		width  : 120px ;
	}
	.form-signup{
		width: 100%;
		max-width: 650px;
		padding: 15px;
		margin: auto;
	}
	input {
		margin-top:5px;
		margin-bottom:5px;
	}
</style>
</head>

<body>
<?php /* print_r($_GET); */ ?>
<form class="form-signup" method="POST" enctype="multipart/form-data">
	<h1 class="content-center" style="color:lime;">Регистрация нового пользователя</h1>
	<form method="POST" enctype="multipart/form-data" >
	<span>Логин: </span><input type="text" name="login" id="login_inp" value="<?=$_SESSION[ 'login' ] ?? ''?>" />
	<i id="logCheckResult"></i>
	<input type="button" class="btn btn-info" onclick="checkLogin()" value="Check for free" />
	<br/>
	<span>Имя:</span><input
	 type="text"
	 name="name"
	 value="<?=$_SESSION[ 'name' ] ?? ''?>" 
	/>
	<br/>
	<span>Отчество:</span><input
	 type="text"
	 name="secname"
	 value="<?=$_SESSION[ 'secname' ] ?? ''?>" 
	/>
	<br/>
	<span>Фамилия:</span><input
	 type="text"
	 name="surname"
	 value="<?=$_SESSION[ 'surname' ] ?? ''?>" 
	/>
	<br/>
	<span>Пароль:</span><input type="password" name='pass' />
	<br/>
	<span>Повтор:</span><input type="password" name='pass2' />
	<br/>
	<span>Аватарка:</span><input type="file" name="ava" title="Файл не более 5 МБ" />
	<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
	<br/>
	<span>Е-меля:</span><input type="email" name="email" value="<?=$_SESSION[ 'email' ] ?? ''?>" />
	<br/>
	<div><input type="submit" value="Регистрация" style="margin-left:20%;" class="btn btn-success"/></div>
	<a href="/" class="btn btn-secondary" style="color:white;">На главную</a>
	</form>
<span id="messenger"><?=$msg ?? ''?></span>
</form>

<script>
checkLogin = ()=>{
	var logTxt = login_inp.value;
	var x = new XMLHttpRequest();
	console.log(x);
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
	x.open("GET","check_login.php?login="+logTxt, true);
	x.send(null);	
}
</script>

<script src="/jquery-3.3.1.min.js"></script>
<script src="/bootstrap.min.js"></script>
</body>
</html>