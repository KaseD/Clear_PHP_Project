<!doctype html />
<html>
<head>
<link rel="stylesheet" href="/bootstrap.min.css" />
<style>
body{
	background:URL(../puc/back1.jpg);
	color:white;
}
</style>
</head>
<body>
<table cellpadding="2px">
<tr>
 <th>id             </th>
 <th>Картинка       </th>
 <th>Опубликовать   </th>
 <th>Заголовок      </th>
 <th>Содержание     </th>
 <th>Категория      </th>
 <th>Дата создания  </th>
</tr>
<?php foreach( $all_news as $n ) : ?>
<tr style="background:rgba(0,0,0,.6);">
  <td><?= $n[ 'id' ] ?>
	<input type="button" onclick="delNews(<?=$n['id']?>)" value="Drop" />
	<input type="button" onclick="sendMail(<?=$n['id_author']?>,<?=$n['id']?>)" value="Send mail" />
  </td>
  <td>
	<a href="/admin/newsedit/<?= $n[ 'id' ] ?>">
	  <img style="height:120px;width:auto"
		   src="../uploads/<?= $n[ 'image_file' ] ?>" 
	   />
	</a>
  </td>
  <th>
	<input type="checkbox" 
		class = "active_field"
		value="<?=$n['id']?>"
		<?=($n['is_active'] != 0)? "checked" : ""?>
	/>
  </th>
  <td><?= $n[ 'title_ru'    ] ?></td>
  <td><?= $n[ 'content_ru'  ] ?></td>
  <td><?= $n[ 'ctg' ] . '(' . $n[ 'id_category' ] . ')' ?></td>
  <td><?= $n[ 'dt_create'   ] ?></td>
</tr>
<?php endforeach ; ?>
</table>

<a href="/" class="btn btn-secondary" style="color:white;">На главную</a>
<script src="/jquery-3.3.1.min.js"></script>
<script src="/bootstrap.min.js"></script>
<script>
chkCkick=(e)=>{
	var x = new XMLHttpRequest();
	if(x){
		x.open("GET","/API/news_set_active.php?id="+e.target.value+"&act="+((e.target.checked)?'1':'0'),true);
		x.onreadystatechange=function(){
			if(x.readyState==4){
				console.log(x.responseText);
				var res = JSON.parse(x.responseText);
				if(res.status<0) alert(res.descr);
				//else{alert("OK");window.location=window.location;}
			}
		}
		x.send(null);
	}
}


var chks = document.getElementsByClassName("active_field");
for(c of chks) c.onclick=chkCkick;





delNews = (id)=>{
	var x = new XMLHttpRequest();
	if(x){
		x.open("GET","/API/remove_news.php?id="+id,true);
		x.onreadystatechange=function(){
			if(x.readyState==4){
				console.log(x.responseText);
				var res = JSON.parse(x.responseText);
				if(res.status<0) alert(res.descr);
				else{
					alert("OK");
					window.location=window.location;
				}
			}
		}
		x.send(null);
	}
}
sendMail=(uid,nid)=>{
	var x = new XMLHttpRequest();
	if(x){
		x.open("GET","/API/email_news.php?uid="+uid+"&nid="+nid,true);
		x.onreadystatechange=function(){
			if(x.readyState==4){
				console.log(x.responseText);
				var res = JSON.parse(x.responseText);
				if(res.status<0) alert(res.descr);
				//else{alert("OK");window.location=window.location;}
			}
		}
		x.send(null);
	}
}
</script>
</body>
</html>