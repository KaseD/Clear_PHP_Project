<!doctype html />
<html>
<head>
<title>User edit</title>
<style>
form img {
	height: 300px;
	width:  auto;
	float:  left;
}
</style>
</head>
<body>

<form method="POST" enctype="multipart/form-data" action="/admin_save_user.php">
<label for='img_file'><img src="/uploads/<?=$user->avatar; ?>" /></label>
<h2 id="user_login"></h2>
First name: <input name="user_name1" /><br/>
Last  name: <input name="user_name2" /><br/>
Surame:     <input name="user_name3" /><br/>
Role: 
<select name='role'>
	<option value="1"<?=($user->role==1)?'selected':""?>>User</option>
	<option value="2"<?=($user->role==2)?'selected':""?>>Modderator</option>
	<option value="3"<?=($user->role==3)?'selected':""?>>Administrator</option>
</select><br/>
File:
<input type="file"   name="image" id="img_file" />
				<input type="hidden" name="MAX_FILE_SIZE" value="<?=2**22?>" /><br />
<input type="hidden" name="user_id"  />
<input type="submit" value="Save changes" />
</form>

<script src="/jquery-3.3.1.min.js"></script>
<script>
$(document).ready( function() {
	$("#user_login").text("<?= $user->login ?>");
	$("input[name='user_name1']").val("<?= $user->first_name ?>");
	$("input[name='user_name2']").val("<?= $user->last_name ?>");
	$("input[name='user_name3']").val("<?= $user->surname ?>");
	$("input[name='user_id']"   ).val("<?= $user->id ?>");
})
</script>
</body>
</html>