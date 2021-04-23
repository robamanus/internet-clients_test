<?php			
session_start();
//print_r($_SESSION);
ini_set("display_errors","1");
ini_set("display_startup_errors","1");
ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);
ini_set("display_errors", 1);
//require_once "core/views/Template.php";
//new Template();
require_once $_SERVER['DOCUMENT_ROOT']."/core/controllers/Router.php";
new Router();
?>
