<?php

require_once("config.php");

$id_supramail = array();
$id_mhp = array();
$contatos = array();

$contatoSupramail = "supramail";
$contatoMHP = "mhp";


echo "==========Contatos Supramail=============\n";


$result = Consultas::select("SELECT * FROM clientes WHERE ativo='t' AND reseller_id='' LIMIT 1");


foreach($result as $key => $value)
{
        
        array_push($id_supramail, $value["id"]);
}

    

for($i=0; $i < count($id_supramail); $i++)
{
        $contatos_supramail[$i] = Consultas::search("
		   SELECT c.id AS id_contato ,c.nome, c.email, cl.id AS id_cliente
		   FROM contatos c INNER JOIN permissaocontatos p ON c.id = p.contato_id 
		   INNER JOIN clientes cl ON cl.id = p.cliente_id 
		   WHERE cl.id = :ID",$id_supramail[$i]
	    );

}

adicionaContatoBanco_RDStation($contatos_supramail, $contatoSupramail);



echo "\n\n======Contatos MHP =================\n";


$result1 = Consultas::select("SELECT * FROM clientes WHERE ativo ='t' AND reseller_id!='' LIMIT 1");

foreach($result1 as $key => $value)
{
        
        array_push($id_mhp, $value["id"]);
}

for($i=0; $i < count($id_mhp); $i++)
{
        $contatos_mhp[$i] = Consultas::search("
		   SELECT c.id AS id_contato, c.nome , c.email, cl.id AS id_cliente
		   FROM contatos c INNER JOIN permissaocontatos p ON c.id = p.contato_id 
		   INNER JOIN clientes cl ON cl.id = p.cliente_id 
		   WHERE cl.id = :ID",$id_mhp[$i]
		);

}

adicionaContatoBanco_RDStation($contatos_mhp, $contatoMHP);
	   


?>