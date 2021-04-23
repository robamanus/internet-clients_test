<?php

require_once "core/models/URL.php";
require_once "core/models/Admin.php";
require_once "core/models/User.php";
require_once "core/views/Template.php";

	class Router{
		
		private $url;
		private $path;
		private $processed_data = false;
		
		function __construct(){
			$this->url = new Url();
			switch($this->url->request){
				case false: $this->path = "index"; break;
				case 'controllers/ob_edit':
					if($_SERVER['REQUEST_METHOD'] == 'POST') {
						$_POST['ob_edit'] = $this->strip_data($_POST['ob_edit']);
					}
					else{
						header('Location: http://gikon.ru/');
					}
					$admin = new Admin();
					$admin->EditObject($_POST['ob_edit']);
					break;
				case 'controllers/ob_add':
					if(isset($_POST['ob_1st_childs'])){
						$_POST['ob_1st_childs'] = unserialize($_POST['ob_1st_childs']);
					}
					if(isset($_POST['ob_name']) && (is_string($_POST['ob_name'])==true) && (isset($_POST['ob_description'])) && (is_string($_POST['ob_description'])==true) && (isset($_POST['ob_parent']))){
						require_once '/home/c/ck35313/gikon/public_html/core/models/DB.php';
						$_POST['ob_name'] = $this->strip_data($_POST['ob_name']);
						$_POST['ob_description'] = $this->strip_data($_POST['ob_description']);
						$_POST['ob_parent'] = $this->strip_data($_POST['ob_parent']);
						$admin = new Admin();
						$admin->AddObject($_POST['ob_name'],$_POST['ob_description'],$_POST['ob_parent']);
					}
					else {
						if(isset($_POST['ob_name_new']) && (is_string($_POST['ob_name_new'])==true) && (isset($_POST['ob_description_new'])) && (is_string($_POST['ob_description_new'])==true) && (isset($_POST['ob_parent'])) && (isset($_POST['ob_pid']))){
							require_once '/home/c/ck35313/gikon/public_html/core/models/DB.php';
							$_POST['ob_name_new'] = $this->strip_data($_POST['ob_name_new']);
							$_POST['ob_description_new'] = $this->strip_data($_POST['ob_description_new']);
							$_POST['ob_parent'] = $this->strip_data($_POST['ob_parent']);
							if(isset($_POST['ob_1st_childs'][0])){
								$ob_1st_childs = $_POST['ob_1st_childs'];
							}
							else $ob_1st_childs = false;
							$admin = new Admin();
							$admin->UpdateEditedObject($_POST['ob_name_new'],$_POST['ob_description_new'],$_POST['ob_parent'],$ob_1st_childs,$_POST['parent_of_edited_pid'],$_POST['ob_pid']);
						}
						else{
							header('Location: http://gikon.ru/');
						}
					}
					break;
				case 'controllers/ob_del':
					if(isset($_POST['ob_del'])){
						require_once '/home/c/ck35313/gikon/public_html/core/models/DB.php';
						$db = new DB();
						$_POST['ob_del'] = $this->strip_data($_POST['ob_del']);
						$admin = new Admin();
						$admin->DeleteObject($_POST['ob_del']);
					}
					else{
						header('Location: http://gikon.ru/');
					}
					break;
				case 'controllers/acc':
					if(isset($_POST['usr']) && (is_string($_POST['usr'])==true) && (isset($_POST['psw'])) && (is_string($_POST['psw'])==true)){
						require_once '/home/c/ck35313/gikon/public_html/core/models/CPU.php';
						$cpu = new CPU();
						$_POST['usr'] = $this->strip_data($_POST['usr']);
						$_POST['psw'] = $this->strip_data($_POST['psw']);
						$_POST['usr'] = trim($_POST['usr']);
						$_POST['psw'] = trim($_POST['psw']);
						$l = $_POST['usr'];
						$p = $_POST['psw'];
						$cpu->Login($l,$p);
						return;
					}
					else{
						die("Неправильно!");
					}
					break;
				case 'controllers/logout':
					if($_SERVER['REQUEST_METHOD'] == 'POST') {
						setcookie("login","",time()-31536000,'/');
						setcookie("hash","",time()-31536000,'/');
					}
					break;
				default: $this->path = '404';
					require_once '/home/c/ck35313/gikon/public_html/core/views/P404.php';
					return new P404();
					break;
			}
			$template = new Template();
		}
		private function strip_data($ku){
			$quotes = array ("\x27", "\x22", "\x60", "\t", "\n", "\r", "*", "%", "<", ">", "?", "!", "+", "#", '"', "/", "(", ")", "[", "]", "{", "}", "~", "`", "№", "@", "$", "=", "|" );
			$ku = str_replace( $quotes, '', $ku );
			$ku = preg_replace('/\s+/', ' ',$ku);
			$ku = htmlspecialchars($ku);
			return $ku;
		}
	}
?>