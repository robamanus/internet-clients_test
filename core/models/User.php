<?php
	require_once '/home/c/ck35313/gikon/public_html/core/models/DB.php';

	abstract class User{
		
		public $role;
		public $level_limit = 100;
		
		
		protected function Tree(){ // построение дерева в котором ключи первого уровня = уровню вложенности элементов в массиве
			$a = array();
			$db = new DB();
			$data = $db->SelectByQueryString("SELECT * FROM `objects`");
			$c_data = count($data);
			if($c_data == false) return;
			for($x=0;$x<$c_data;$x++){
				if($data[$x]['parent_id'] == false){
					$roditel[] = $data[$x];
					unset($data[$x]);
				}
			}
			$a = array();
			foreach($data as $va){
				$a[] = $va;
			}
			$data = $a;
			$new_parent = array();
			$levels_data[1] = $roditel;
			for($z=1;$z<=$this->level_limit;$z++){
				$c_roditel = count($roditel);
				for($x=0;$x<$c_roditel;$x++){
					$c_data1 = count($data);
					for($x1=0;$x1<$c_data1;$x1++){
						if(isset($data[$x1])){
							if($roditel[$x]['pid'] == $data[$x1]['parent_id']){
								$new_parent[] = $data[$x1];
							}
						}
					}
				}
				$roditel = $new_parent;
				$new_parent = array();
				if($roditel != false){
					$levels_data[$z+1] = $roditel;
				}
				$a = array();
				foreach($data as $va){
					$a[] = $va;
				}
				$data = $a;
			}
			$keys = array_keys($levels_data);
			$last_key = array_pop($keys);
			$new_count = $last_key;
			//echo $last_key; exit;
			for($f=1;$f<$new_count;$f++){
				for($x=0;$x<count($levels_data[$last_key-1]);$x++){
					for($x1=0;$x1<count($levels_data[$last_key]);$x1++){
						if($levels_data[$last_key-1][$x]['pid'] == $levels_data[$last_key][$x1]['parent_id']){
							$levels_data[$last_key-1][$x]['childs'][] = $levels_data[$last_key][$x1];
						}
					}
				}
				unset($levels_data[$last_key]);
				$last_key--;
			}
			$this->tree = $levels_data[1];
			return $this->tree;
		}
		
		abstract protected function UserTree();
		
		
		/*function GuestTree(){
			foreach ($array as $key => $value) {
				echo 'key => ' . $key . '<br>value => ' . $value . '<br>';
				if (is_array($value)) {
					if ($key == 'childs'){
						$this->UserTree($value);
					}
					if ($key == 'object_name'){
						$result .= "<div><div style='display:inline-block;'><b>$value</b></div><div style='display:inline-block;color:green;width:10px;height:10px;border:1px solid #888;text-align:center;line-height:8px;'>+</div></div>";
					}
					
					echo 'value => ' . $value;
				}
				else{
					if ($key == 'object_name'){
						//$result .= "{$tab}<div style='display:inline-block;'><b>$value</b></div><br>";
						$result .= "<div><div style='display:inline-block;color:green;width:10px;height:10px;border:1px solid #888;text-align:center;line-height:8px;'>-</div><div style='display:inline-block;'><b>$value</b></div></div>";
					}
				}
			}
			return $result;
		}*/
	}
	
?>