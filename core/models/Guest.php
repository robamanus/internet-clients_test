<?php
	require_once '/home/c/ck35313/gikon/public_html/core/models/DB.php';
	require_once '/home/c/ck35313/gikon/public_html/core/models/User.php';

	class Guest extends User{
		
		protected $guest_tree;
		public $level_limit = 100;
		public $tree_string = '';
		
		
		function UserTree(){
			$this->guest_tree = $this->CreatingGuestTree();
			print($this->guest_tree);
		}
		function ChildsAdding($newchild, $separator = 0){
			//$display_status = 'block';
			if($newchild['parent_id'] == 0){
				$display_status = 'block';
			}
			else{
				$display_status = 'none';
			}
			if(isset($newchild['childs'])){
				$this->tree_string .= '
				<div class="plus" id="'.$newchild['pid'].'" style="margin-left:'.$separator.'px;display:'.$display_status.';">
					<span>'.$newchild['object_name'].'</span>';
				$separator = $separator+10;
				for($a=0;$a<count($newchild['childs']);$a++){
					$this->ChildsAdding(($newchild['childs'][$a]),$separator);
				}
				
			}
			else{
				$this->tree_string .= '
				<div class="minus" id="'.$newchild['pid'].'" style="margin-left:'.$separator.'px;display:'.$display_status.';">
					<span>'.$newchild['object_name'].'</span>';
				
			}
			$this->tree_string .= '</div><div></div>';
		}
		function CreatingGuestTree(){
			$tree = parent::Tree();
			$childs = $string = '';
			for($x=0;$x<count($tree);$x++){ // levels count
			
				$this->ChildsAdding($tree[$x]);
				
				/*for($y=0;$y<count($tree[$x]);$y++){ // objects on level count
					if(isset($tree[$x+1])){
						for($z=0;$z<count($tree[$x+1]);$z++){
							if($tree[$x][$y]["pid"] == $tree[$x+1][$z]["parent_id"]){
								$current_el_with_childs = $tree[$x][$y];
								$childs .= $this->ChildsAdding($tree[$x+1][$z]);
								//$div_open = '<div class="plus" id="'.$tree[$x][$y]["pid"].'">';
							}
						}
						if($childs == false){
							$current_el = $tree[$x][$y];
						}
						if(isset($current_el_with_childs)){
							$this->tree_string .=
							'<div class="plus" id="'.$current_el_with_childs["pid"].'">
								<span>'.$current_el_with_childs["object_name"].'</span>'
								. $childs . 
							'</div>';
							unset($current_el_with_childs);
						}
						else{
							$string .= '<div class="minus" id="'.$current_el["pid"].'">
								<span>'.$current_el['object_name'].'</span>
							</div>';
						}
						$childs = '';
					}
					
					/*
					foreach($tree[$x][$y] as $k=>$v){ // objects iterating
						switch($k){
							/*case 'id':
							case 'pid':
							case 'object_desc':
								unset($tree[$x][$y][$k]); break;
								
							default: break;
						}
					}
					if($tree[$x][$y]["pid"] == $tree[$x+1][$y]["pid"])
					$string = '
					<div id="'.$tree[$x][$y]["pid"].'">
						
					</div>';
				}*/
				
				
			}
			return $this->tree_string;
		}
	}
	
?>