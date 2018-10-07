<?php

 require_once("config.php");


	$sql = new Sql();

	$result = $sql->select("SELECT * FROM tabela_noticia");

	foreach($result as $key => $value)
	{
		  echo $value["titulo"]."\n";
	}

//	var_dump($result);
?>
