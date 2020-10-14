<!doctype html />
<html>
<head>

<link rel="stylesheet" href="/bootstrap.min.css" />

</head>
<body> 
<style>
body{
	background:URL(../puc/back2.jpg);
}
.form-signin{
    width: 100%;
    max-width: 330px;
    padding: 15px;
    margin: auto;
}
</style>

<form method="POST" class="form-signin" action="auth.php" >
	<h1 style="color:lime;margin-left:20%;" class="h3 mb-3 font-weight-normal center-block">Авторизация</h1>
	<strong><?=$msg?></strong>
	<div class="center-block"><input class="form-control" type="text" name="login" placeholder="Login" style=""/></div><br />
	<div class="center-block"><input class="form-control" type="password" name="pass" placeholder="Password" style=""/></div><br />
	<button class="btn btn-success" style="margin-left:20%;">Вход</button>
	<a href="/" class="btn btn-secondary" style="color:white;">На главную</a>
</form>

<script src="/jquery-3.3.1.min.js"></script>
<script src="/bootstrap.min.js"></script>
</body>
</html>