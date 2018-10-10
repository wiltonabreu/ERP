<?php

  function abreBanco() {
    $conn = pg_connect("host=10.3.7.3 port=5432 dbname=maverp user=maverp password=ddd001") or die('connection failed');

    return $conn;

  }

     
  function pegarRegistro()
  {
      $connection = abreBanco();

      pg_send_prepare($connection, "SELECT * FROM clientes limit 1");
      

      $resultprepare = pg_get_result($connection);
     
      pg_send_execute($connection,"select_clientes");
      
      $resultexecute = pg_get_result($connection);
    
      if (pg_last_error()){
        die(pg_last_error());
      }
      
      while ($result = pg_fetch_assoc($resultexecute))
      {
      
        print_r($result);
      }

      pg_close($connection);
  }



  $rs = pegarRegistro();

  

?>

