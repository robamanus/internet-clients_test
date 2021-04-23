<?php
	
	require_once '/home/c/ck35313/gikon/public_html/core/models/DB.php';
	require_once '/home/c/ck35313/gikon/public_html/core/models/User.php';

	class Admin extends User{
		
		protected $admin_tree;
		public $level_limit = 100;
		
		function UserTree(){
			$this->AdminBar();
			$this->admin_tree = parent::Tree();
			require_once '/home/c/ck35313/gikon/public_html/core/views/AdminTree.php';
			new AdminTree($this->admin_tree);
		}
		public function EditObject($ob_edit){
			require_once '/home/c/ck35313/gikon/public_html/core/models/DB.php';
			$db = new DB();
			$data = $db->SelectByQueryString("SELECT * FROM `objects`");
			$first_childs = array();
			for($g=0;$g<count($data);$g++){
				if($data[$g]['parent_id'] == $ob_edit){
					$first_childs[] = $data[$g]['pid'];
				}
				if($data[$g]['pid'] == $ob_edit){
					$parent_of_edited_pid = $data[$g]['parent_id'];
				}
			}
			$first_childs = serialize($first_childs);
			require_once '/home/c/ck35313/gikon/public_html/core/views/EditObject.php';
			new \Views\EditObject($ob_edit,$data,$parent_of_edited_pid,$first_childs);
		}
		public function AddObject($ob_name,$ob_description,$ob_parent){
			$rand = mt_rand(1,99999999) . mt_rand(0,99999999);
			$data = array($rand,$_POST['ob_name'],$_POST['ob_description'],$_POST['ob_parent']);
			$cell = array("pid","object_name","object_desc","parent_id");
			$db = new DB();
			$db->InsertData("objects",$data,$cell);
			header('Location: http://gikon.ru/');
		}
		public function DeleteObject($ob_del){
			$db = new DB();
			$ob = $db->SelectByQueryString("SELECT * FROM `objects`");
			for($x=0;$x<count($ob);$x++){
				if($ob[$x]['pid'] == $ob_del) { }
				else { $all_pids[] = $ob[$x]['pid']; }
			}
			if(isset($all_pids)){
				array_push($all_pids, 0);
			}
			if ($db->DeleteFrom("DELETE FROM `objects` WHERE `pid`='" . $ob_del . "'")) {
				for($x=0;$x<count($ob);$x++){
					if(isset($ob[$x]) && isset($all_pids)){
						if(!in_array($ob[$x]['parent_id'],$all_pids)){
							for($xz=0;$xz<count($all_pids);$xz++){
								if($ob[$x]['pid'] == $all_pids[$xz]) {
									$db->DeleteFrom("DELETE FROM `objects` WHERE `pid`='" . $all_pids[$xz] . "'");
									unset($all_pids[$xz]);
									foreach($all_pids as $val){
										$aa[] = $val;
									}
									$all_pids = $aa;
									$aa = array();
								}
							}
							
						}
					}
				}
				header('Location: http://gikon.ru/');
			}
			else{
				header('Location: http://gikon.ru/');
			}
		}
		public function UpdateEditedObject($ob_name_new,$ob_description_new,$ob_parent,$ob_1st_childs,$parent_of_edited_pid,$ob_pid){
			$db = new DB();
			if($ob_1st_childs != false){
				for($h=0;$h<count($ob_1st_childs);$h++){
					$db->UpdateData("UPDATE `objects` SET `parent_id`='" . $parent_of_edited_pid . "' WHERE `pid`='".$ob_1st_childs[$h]."'");
				}
			}
			$data = array($ob_name_new,$ob_description_new,$ob_parent,$ob_pid);
			$cell = array("object_name","object_desc","parent_id");
			if ($db->UpdateData("UPDATE `objects` SET `object_name`='" . $ob_name_new . "', `object_desc`='" . $ob_description_new . "', `parent_id`='" . $ob_parent . "' WHERE `pid`='".$ob_pid."'")) {
				header('Location: http://gikon.ru/');
				
			}
			else{
				echo "Ой! Ошибочка...<br><br><a href='http://gikon.ru/'>Назад</a>";
			}
		}
		private function AdminBar(){
			$a = array();
			$db = new DB();
			$data = $db->SelectByQueryString("SELECT * FROM `objects`");
			require_once '/home/c/ck35313/gikon/public_html/core/views/AdminBar.php';
			new AdminBar($data);
		}
	}
	
?>