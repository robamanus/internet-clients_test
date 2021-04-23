<?php
namespace Views;

	class EditObject{
		
		public function __construct($ob_edit,$data,$parent_of_edited_pid,$first_childs){
			echo "<div style='display:inline-block;margin:20px;vertical-align:top;'>
					<form action='http://gikon.ru/controllers/ob_add' method='POST'>
						<div>
							<input type='text' name='ob_name_new' placeholder='Новое название объекта' maxlength='64'>
							<input type='text' name='ob_description_new' placeholder='Новое описание объекта' maxlength='128'>
							<input type='text' name='ob_pid' value='" . $ob_edit . "' style='display:none;'>
							<input type='text' name='parent_of_edited_pid' value='" . $parent_of_edited_pid . "' style='display:none;'>
							<input type='text' name='ob_1st_childs' value='" . $first_childs . "' style='display:none;'>";
				echo	"</div>
						<div>
							<select name='ob_parent'>
								<option selected='true' disabled='disabled'>Выберите родителя объекта</option><option value='false'>КОРНЕВОЙ</option>";
						for($g=0;$g<count($data);$g++){
							if($data[$g]['pid'] != $ob_edit){
								echo "<option value='" . $data[$g]['pid'] . "'>" . $data[$g]['object_name'] . "</option>";
							}
						}
			echo			"</select>
							<button id='ob_edit'>редактировать</button>
						</div>
					</form>
				</div>";
		}
	}
	
?>