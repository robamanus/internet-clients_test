<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/core/models/URL.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/core/models/Settings.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/core/models/CPU.php";

	class Template{
		
		private $url;
		private $db;
		public $request;
		
		function __construct(){
			$this->url = new Url();
			$this->request = $this->url->Request();
			$this->settings = new Settings();
			switch ($this->settings->GetPathCode($this->request)){
				case 0: $this->Page(); break;
				case 1: $this->Controllers($this->request); break;
				case 2: $this->Page404(); break;
			}
		}
		public function Page(){
			if(is_array($this->request)!=false) { $this->request = implode("/",$this->request); }
			if($this->request == false) $this->request = "index";
			require_once "tpl/".$this->request.".tpl";
		}
		public function Controllers($request){
			$request = implode("/",$request);
			require_once $_SERVER['DOCUMENT_ROOT'] . "/core/" . $request . ".php";
		}
		public function Page404(){
			require_once $_SERVER['DOCUMENT_ROOT'] . "/tpl/404.tpl";
		}
	}
?>