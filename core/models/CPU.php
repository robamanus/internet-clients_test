<?php
	require_once '/home/c/ck35313/gikon/public_html/core/models/DB.php';

	class CPU{
		
		public $result = false;
		public $stop = "st0p";
		private $salt_psw = "tfjuyfgk";
		private $enter_code = "5hhrtytj34yrg45yhh5";
		
		// Делаем автоматом до действия
		public function CheckPrivateXHR(){
			$url = new URL();
			$request = $url->Request();
			$settings = new Settings();
			$is_private = $settings->PrivateLinks($request);
			if(!isset($_COOKIE[$is_private]) && ($is_private==true)) {
				return $this->stop;
			}
			return;
		}
		// Делаем автоматом до действия
		public function CheckPrivate(){
			$url = new URL();
			$request = $url->Request();
			$settings = new Settings();
			$is_private = $settings->PrivateLinks($request);
			if(!isset($_COOKIE[$is_private]) && ($is_private==true)) {
				header("Location:http://gikon.ru/"); return;
			}
			return $this->result;
		}
		// Выбираем логин из базы
		public function Login($l,$p){
			$act = false;
			$db = new DB();
			$l = strtolower($l);
			$l = $l;
			$p = md5($p.($this->salt_psw));
			//echo $p; exit;
			$data = $db->SelectByQueryString("SELECT * FROM `account_data` WHERE login='".$l."' AND psw='".$p."'");
			if($data!=false) {
				setcookie("login", $l, time() + 30000, '/');
				setcookie("hash", $p, time() + 30000, '/');
				$act = 1;
			}
			else{
				//setcookie("login", 1, time() + 5, '/');
				echo "Неправильно!";
			}
			echo $act;
		}
		public function ChkAccCookies($login,$hash){
			$act = false;
			$db = new DB();
			$login = strtolower($login);
			$data = $db->SelectByQueryString("SELECT * FROM `account_data` WHERE login='".$login."' AND psw='".$hash."'");
			//print_r($data[0]); exit;
			if($data[0]!=false) {
				if(($data[0]['login']==$_COOKIE['login'])&&($data[0]['psw']==$_COOKIE['hash'])){
					return $this->enter_code;
				}
			}
			else{
				setcookie("login", 0, time() + 0, '/');
				setcookie("hash", 0, time() + 0, '/');
				header("Location:http://gikon.ru/");
			}
			echo $act;
		}
		public function GetFilenameFromPath($filepath){
			$filename = str_replace('/home/c/ck35313/directory-neftekamsk.ru/public_html/requests/', '', $filepath);
			$filename = str_replace('requests/', '', $filename);
			$filename = str_replace('.txt', '', $filename);
			return $filename;
		}
		public function RenameSmallImgFile($link) {
			$link = explode('/',$link);
			$rename = array_pop($link);
			$l = strpos($rename, ".jpg");
			$rename = substr($rename, 0, $l);
			return $rename;
		}
		public function GetDirectory($link) {
			$link = explode('/',$link);
			$last_key = count($link)-1;
			//echo $last_key;
			unset($link[$last_key]);
			$link = implode('/',$link);
			$link .= "/";
			return $link;
		}
		
	}
?>