<?php


// 13 de Abril del 2014
// View.php
// @brief Una vista corresponde a cada componente visual dentro de un modulo.

class View {
	/**
	* @function load
	* @brief la funcion load carga una vista correspondiente a un modulo
	**/	
	public static function load($view){
		// Module::$module;
		if(!isset($_GET['view'])){
			if(Core::$root==""){
				include "core/app/view/".$view."-view.php";
			}else if(Core::$root=="admin/"){
				include "core/app/".Core::$theme."/view/".$view."-view.php";				
			}
		}else{


			if(View::isValid()){
				$url ="";
			if(Core::$root==""){
			$url = "core/app/view/".$_GET['view']."-view.php";
			}else if(Core::$root=="admin/"){
			$url = "core/app/".Core::$theme."/view/".$_GET['view']."-view.php";				
			}
				include $url;				
			}else{
			//	$string="text-uppercase";
			//	$string2="tx-bold tx-140 tx-gray-500";
			//	$string3="text-danger";
			//	View::Error("<b>404 NOT FOUND</b> View <b>".$_GET['view']."</b> folder !! - <a href='' target='_blank'>Help</a>");
				//View::Error("<b><h3 class=".$string.">Page not found!</h3> <b>".$_GET['view']."</b> folder !! - <a href='' target='_blank'>Help</a>");
				//View::Error("<b><h1 class=".$string2.">4<span class=".$string3.">0</span>4</h1> <b>".$_GET['view']."</b> folder !! - <a href='' target='_blank'>Help</a>");
				print "<script>window.location='index.php?view=404';</script>";//redireccion al error

			}



		}
	}

	/**
	* @function isValid
	* @brief valida la existencia de una vista
	**/	
	public static function isValid(){
		$valid=false;
		if(isset($_GET["view"])){
			$url ="";
			if(Core::$root==""){
			$url = "core/app/view/".$_GET['view']."-view.php";
			}else if(Core::$root=="admin/"){
			$url = "core/app/".Core::$theme."/view/".$_GET['view']."-view.php";				
			}
			if(file_exists($file = $url)){
				$valid = true;
			}
		}
		return $valid;
	}

	public static function Error($message){
		print $message;
	}

}



?>