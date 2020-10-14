<?php if( empty( $workmode ) ) : ?>
<h1>Добавить новость</h1>
<?php else : if( $workmode == "edit" ) : ?>
<h1>Редактировать новость</h1>
<h2>Автор: <?=$user->first_name.''.$user->surname.'('.$user->login.')'?>
<?php endif ; endif ; ?>

<form 
	method="POST" 
	action= <?=(!empty($workmode) && $workmode=="edit")
				? "/admin/newsedit/".$news->id
				: "/$lang/news/add"
			?>
	enctype="multipart/form-data"
>
<table>
	<tbody>
		<tr>
			<td><span>Заголовок:</span></td>
			<td><input type="text" name="title" value="<?=$title?>" /></td>
		</tr>
		<tr>
			<td><span>Содержимое:</span></td>
			<td><textarea name="content" ><?=$content?></textarea></td>
		</tr>
		<tr>
			<td><span>Категория:</span></td>
			<td>
				<select name="category">
				<?php 
				  $field_title = "title_" . $lang ;
				  foreach($news->get_categories( ) as $ctg ) : ?>
					<option
						value="<?= $ctg[ 'id' ] ?>" 
						<?=($category == $ctg[ 'id' ] ) ? 'selected' : ''?> >
						<?= $ctg[ $field_title ] ?>
					</option>
				<?php endforeach ; ?>
				</select>
			</td>
		</tr>
		<tr>
			<td><span>Важность:</span></td>
			<td>
				<?php 
				  $field_title = "title_" . $lang ;
				  foreach($news->get_importances( ) as $n=>$imp ) : ?>
					<input
					  type="radio" 
					  name="importance" 
					  value="<?= $imp[ 'id' ] ?>" 
					  id="imp<?= $n ?>" 
					  <?= ($importance == $imp[ 'id' ] ) ? 'checked' : '' ?> 
					/>
					<label for="imp<?= $n ?>">
					  <?= $imp[ $field_title ] ?>
					</label>
				<?php endforeach ; ?>
			</td>
		</tr>
		<tr>
			<td><span>Картинка:</span></td>
			<td> <?=( ! empty( $workmode ) && $workmode == "edit" )
					? "<label for='img_file'><img src='../../uploads/" . $news->image_file . "' style='height:200px' /></label>"
					: "" 
				?>
			<input type="file"   name="image" id="img_file" />
				<input type="hidden" name="MAX_FILE_SIZE" value="<?=2**22?>" />
			</td>
		</tr>
	</tbody>
</table>
<input type="submit"
		value="<?=(!empty($workmode) && $workmode=="edit")
					? "Обновить"
					: "Вставить"
				?>"
/><?phpif( $workmode == "edit" ) : ?>
<input type="checkbox" 
		class = "active_field"
		value="<?=$n['id']?>"
		<?=($n['is_active'] != 0)? "checked" : ""?>
	/>Публикуется
	<?phpendif;?>
</form>
<?php
if( ! empty( $msg ) ) {
	foreach( $msg as $m ) :
	?>
	
	<h2 style='color:fuchsia'> <?=$m?> </h2>
	
	<?php endforeach ;
}
if( $add_ok == true ) : ?>
<script> alert('Добавлено успешно');location.replace("/ru/news");</script>
<?php endif;?>