<?php
	require_once '/home/c/ck35313/gikon/public_html/core/models/DB.php';
	require_once '/home/c/ck35313/gikon/public_html/core/models/User.php';

	class AdminBar{
		
		function __construct($data){
			echo "<div style='display:inline-block;margin:20px;vertical-align:top;'>
						<h2>Добавить объект</h2>
						<form action='controllers/ob_add' method='POST'>
							<div>
								<input type='text' name='ob_name' placeholder='Название объекта' maxlength='64'>
								<input type='text' name='ob_description' placeholder='Описание объекта' maxlength='128'>
							</div>
							<div>
								<select name='ob_parent'>
									<option selected='true' disabled='disabled'>Выберите родителя объекта</option><option value='false'>КОРНЕВОЙ</option>";
							for($g=0;$g<count($data);$g++){
								echo "<option value='" . $data[$g]['pid'] . "'>" . $data[$g]['object_name'] . "</option>";
							}
				echo			"</select>
								<button id='ob_add'>добавить</button>
							</div>
						</form>
					</div>";
				echo "<div style='display:inline-block;margin:20px;vertical-align:top;'>
						<h2>Удалить объект</h2>
						<form action='controllers/ob_del' method='POST'>
							<select name='ob_del'>
									<option selected='true' disabled='disabled'>Удалить объект</option>";
							for($g=0;$g<count($data);$g++){
								echo "<option value='" . $data[$g]['pid'] . "'>" . $data[$g]['object_name'] . "</option>";
							}
				echo		"</select>
							<button id='ob_del'>удалить</button>
						</form>
					</div>";
				echo "<div style='display:inline-block;margin:20px;vertical-align:top;'>
						<h2>Редактировать объект</h2>
						<form action='controllers/ob_edit' method='POST'>
							<select name='ob_edit'>
									<option selected='true' disabled='disabled'>Редактировать объект</option>";
							for($g=0;$g<count($data);$g++){
								echo "<option value='" . $data[$g]['pid'] . "'>" . $data[$g]['object_name'] . "</option>";
							}
				echo		"</select>
							<button id='ob_edit'>редактировать</button>
						</form>
					</div><button id='logout'>Логаут</button>";
		}
	}