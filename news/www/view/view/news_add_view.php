<h1>Добавить новость</h1>
<form method="POST" action="/<?= $lang ?>/news/add" enctype="multipart/form-data">
<table>
	<tbody>
		<tr>
			<td><span>Заголовок:</span></td>
			<td><input type="text" name="title" /></td>
		</tr>
		<tr>
			<td><span>Содержимое:</span></td>
			<td><textarea name="content" rows="3"></textarea></td>
		</tr>
		<tr>
			<td><span>Категория:</span></td>
			<td>
				<select name="category">
					<option value="1">Культура</option>
					<option value="2">Спорт</option>
					<option value="3">Криминал</option>
					<option value="4">События</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><span>Важность:</span></td>
			<td>
				<input type="radio" name="importance" id="imp1"/><label for="imp1">Срочная</label>
				<input type="radio" name="importance" id="imp2" checked /><label for="imp2">Обычная</label>
				<input type="radio" name="importance" id="imp3"/><label for="imp3">Низкая</label>
			</td>
		</tr>
		
	</tbody>
</table>
<input type="submit" value="Вставить"/>
</form>
