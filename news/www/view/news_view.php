<!doctype html />
<html>
<head>
<link rel="stylesheet" href="../bootstrap.min.css" />
<style>
body{
	background:URL(../puc/back1.jpg);
}
.searchCont{
	display:inline;
}
.op{
	background-color: rgba(0,0,0,.6);
    color: white;
}
.op table{
	
}
</style>
</head>
<body> 

<header>
  <nav class="navbar navbar-expand-lg navbar-light bg-gray">
   <a class="navbar-brand" style="margin-right:55px; color:white;" href="/">NikNews</a>
   <?php if(empty($_SESSION['logged'])):?>
   <a class="" href="/auth.php" style="float:right; margin-right:5px;">Авторизация </a>
   <a class="nav-link" href="/reg.php" style="float:right;  margin-right:5px;">Регистрация</a>
   <?php else:?>
   <a href="/view/user_profile_view.php" style="margin-right:1%;"><?=$users->login;?></a>
   <?php endif;?>
   <?php if(!empty($users)&& $users->role==3):?>
   
 
   
   
   
   <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Админ Панель
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
    <button class="dropdown-item" type="button">
	<a class="dropdown-item" href="/admin/news">Новости</a>
	</button>
    <button class="dropdown-item" type="button">
	 <a class="dropdown-item" href="/admin/users">Пользователи</a>
	</button>
  
  </div>
</div>
   
  <?php endif; ?>
  <form class="searchCont" name="search" method="POST" action="../API/search.php">
		<input class="form-control" type="search" name="searchTxt" placeholder="Search" style="margin-left:5px; width:200px; display:inline; margin-right:5px;"/><button class="btn btn-outline-secondary">Искать</button>
  </form>
  <?php if(!empty($_SESSION['logged'])):?>
   <a href="?logout" style="margin-left:60%;">Log out</a>
  <?php endif;?>
</nav>

</header>
<div class="container" style="text-align:center;">
<a href="/ru/news/add" class="btn btn-primary" >Добавить новость</a>
 </div>
 
<?php foreach( $all_active_news as $n ) : ?>
	<?php if($n['is_active']=='1'): ?>

<div class="card op">
  <h5 class="card-header">
  <img style="height:120px;width:auto;  "
			   src="../../uploads/<?= $n[ 'image_file' ] ?>" 
		   />
		   <table style="display:inline-block; text-align:top; color:white;">
		   <tr><td><strong> <?= $n[ 'title_ru'  ] ?></strong></td></tr>
		   <tr><td> <?= $n[ 'content_ru'  ] ?></td></tr>
		   <tr><td> </td></tr>
		   
		   </table><br>
		
		
<small><?= $n[ 'dt_create'  ] ?></small> 
<a href="/view/news_full_view.php?id=<?=$n['id']?>" class="btn btn-primary">Детальнее</a><br>
		   </h5>
		   
</div>

        
        
<?php  endif; endforeach ; ?>
       
    
 
   

<script src="../jquery-3.3.1.min.js"></script>
<script src="../bootstrap.min.js"></script>
</body>
</html>



