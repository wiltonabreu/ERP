<?php
spl_autoload_register(function($class_name){
	$filename = "class".DIRECTORY_SEPARATOR.$class_name.".php";
	
	if (file_exists(($filename))){
		require_once($filename);

	}
});
require_once("crm_rdstation.php");
require_once("adicionaContatoBanco_RDStation.php");
?>