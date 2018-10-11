<?php

function adicionaContatoBanco_RDStation($arrayContatos = array(), $tipoCliente)
{

	$token = "";


       foreach ($arrayContatos as $key => $value)
       {
       		
		foreach ($value as $key => $valor)
		{
			if(!Consultas::verificaEmailNoBanco("SELECT * FROM contatos_clientes_rdstation WHERE email = :EMAIL", $valor))
			{    			

				Consultas::inserir("INSERT INTO contatos_clientes_rdstation (nome, email, id_cliente, id_contato) VALUES(:NOME, :EMAIL, :ID_CLIENTE, :ID_CONTATO)", $valor);
				
				if($tipoCliente == "supramail")
				{
					echo "\n Supramail \n ";

					$form_data_array = array('email'=> $valor["email"], 'nome' => $valor["nome"]);
                                   print_r($form_data_array);       
					addLeadConversionToRdstationCrm($token, "cliente-supramail", $form_data_array);
				}

				if($tipoCliente == "mhp")
				{
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

?>