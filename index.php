<?php

 require_once("config.php");

 $id_supramail = array();
 $id_mhp = array();
 $contatos = array();


 		echo "==========Contatos Supramail=============\n";
        $sql = new Sql();

        $result = $sql->select("SELECT * FROM clientes WHERE ativo='t' AND reseller_id=''");

        
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

       adicionaContatoBanco_RDStation($contatos_supramail, "supramail");

       
       
        echo "\n\n======Contatos MHP =================\n";


        $sql = new Sql();

        $result1 = $sql->select("SELECT * FROM clientes WHERE ativo ='t' AND reseller_id!=''");

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
     
       adicionaContatoBanco_RDStation($contatos_mhp, "mhp");

	   function adicionaContatoBanco_RDStation($arrayContatos = array(), $tipoCliente){

	   		   $token = "SEUTOKEN";


		       foreach ($arrayContatos as $key => $value)
		       {
		       		
		       		foreach ($value as $key => $valor)
		       		{
		       			if(!Consultas::verificaEmailNoBanco("SELECT * FROM contatos_clientes_rdstation WHERE email = :EMAIL", $valor)){    			

		       				Consultas::inserir("INSERT INTO contatos_clientes_rdstation (nome, email, id_cliente, id_contato) VALUES(:NOME, :EMAIL, :ID_CLIENTE, :ID_CONTATO)", $valor);
		       				
		       				if($tipoCliente == "supramail"){
		       					echo "\n Supramail \n ";

		       					$form_data_array = array('email'=> $valor["email"], 'nome' => $valor["nome"]);

		       					addLeadConversionToRdstationCrm($token, "cliente-supramail", $form_data_array);
		       				}

		       				if($tipoCliente == "mhp"){
		       					echo "\n MHP \n ";

		       					$form_data_array = array('email'=> $valor["email"], 'nome' => $valor["nome"]);
		       					print_r($form_data_array);
		       					addLeadConversionToRdstationCrm($token, "MHPs", $form_data_array);
		       				}
		       		    }
		       		    else{

		       		    	echo "\nEmail " . $valor["email"] . " já cadastrado na base de dado\n";
		       		    }
		       		}
		       		

		       }
	       }
	   

	
/*
       foreach ($contatos_supramail as $key => $value)
       {

       		foreach ($value as $key => $valor)
       		{
   			   
   			    $filename = "contatoSUPRAMAIL.csv";

				   if(file_exists($filename)){

				          if( strpos(file_get_contents($filename),$valor["email"]) !== false) {

				               echo "\n" . $valor["email"] . "já havia sido cadastrado\n";
				               
				          }else{

				                echo "\n" . $valor["email"] . "não encontrado no arquivo.\n ...Cadastrando\n";

				                $file1 = fopen("contatoSUPRAMAIL.csv", "a+");
				                fwrite($file1, $valor["nome"] . ",". $valor["email"] ."\r\n");
				                fclose($file1);

				          }


				   }else{

				        echo "Arquivo inexistente";
				   }


       		}
       		

       }
		*/

        /*
      foreach ($contatos_mhp as $key => $value)
      {

       		foreach ($value as $key => $valor)
       		{
	       		   $filename = "contatoMHP.csv";

				   if(file_exists($filename)){

				          if( strpos(file_get_contents($filename),$valor["email"]) !== false) {

				               echo "\n" . $valor["email"] . "já havia sido cadastrado\n";
				               
				          }else{

				                echo "\n" . $valor["email"] . "não encontrado no arquivo.\n ...Cadastrando\n";

				                $file1 = fopen("contatoMHP.csv", "a+");
				                fwrite($file1, $valor["nome"] . ",". $valor["email"] ."\r\n");
				                fclose($file1);

				          }


				   }else{

				        echo "Arquivo inexistente";
				   }

		       			
		     }
       		

      }
      */


?>