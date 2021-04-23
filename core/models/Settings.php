<?php
	class Settings{
		
		private $path_codes =
			array(
				'' => 0,
				'controllers' => 1,
				'404' => 2
			);
		
		
		public function GetPathCode($req){
			if(is_array($req) === false){
				if(isset($this->path_codes[$req])){
					return $this->path_codes[$req];
				}
				else return $this->path_codes['404'];
			}
			else{
				if(isset($this->path_codes[$req[0]])){
					return $this->path_codes[$req[0]];
				}
				else return $this->path_codes['404'];
			}
		}
	}
?>