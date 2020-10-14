<!doctype html />
<html>
<head>
<link rel="stylesheet" href="/bootstrap.min.css" />
<style>
	body {
		background:URL(../puc/back3.jpg) ;
		color:white;
	}
	.avatar {
		height: 75px ;
		width:  75px ;
	}
	tr{
		font-size:24px;
	}
</style>
</head>
<body> 
<h1><?= $_TXT['hello'] ?></h1>
<!--
<pre><?php print_r( $users ) ; ?></pre>
-->
<table>
<tr>
	<th>ID</th>
	<th></th>
	<th><?= $_TXT['login'] ?></th>
	<th><?= $_TXT['name'] ?></th>
	
</tr>
<?php foreach( $users as $u ) : ?>
<tr>
	<td><?= $u['id'] ?></td>
	<td><a href="edituser/?uid=<?= $u['id'] ?>">
		<img class='avatar' src="/uploads/<?= $u['avatar'] ?? 'no_ava.jpg' ?>" />
		</a>
	</td>
	<td><?= $u['login'] ?></td>
	<td><?= $u['firstname'] ?></td>

</tr>
<?php endforeach ; ?>
</table>
<a href="/" class="btn btn-secondary" style="color:white;">На главную</a>
<script src="/jquery-3.3.1.min.js"></script>
<script src="/bootstrap.min.js"></script>
</body>
</html>