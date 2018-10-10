<?php
class Consultas{

  public static function search($query,$id){
        $sql = new Sql();
        $sq = $sql->select($query, array(
         ':ID'=>$id
        ));
        return $sq;
  }

  public static function verificaEmailNoBanco($query,$valor){
        $sql = new Sql();
        $sq = $sql->select($query, array(
         ':EMAIL'=>$valor["email"]
        ));
        return $sq;
  }

  
  public static function inserir($query,$valor){
          
          $sql = new Sql();

          $stmt = $sql->select($query, array(
           ':NOME'=>$valor["nome"],
           ":EMAIL"=>$valor["email"],
           ":ID_CLIENTE" =>$valor["id_cliente"],
           ":ID_CONTATO" =>$valor["id_contato"]
          ));


          echo "Dados Inseridos com Sucesso!!!\n";

  }

/* REMOVER REGISTRO Duplicado
DELETE FROM contatos_clientes_rdstation a WHERE EXISTS (SELECT 1 FROM contatos_clientes_rdstation  b WHERE a.email  = b.email AND a.id < b.id);
*/

}

?>
