<?php
    $username='japon';
    $password='1234';
    $database='android';
    $localhost='localhost';

    $connection = new mysqli($localhost, $username, $password, $database);
       //TESTING IF THE CONNECTION WAS RIGHT
    if ($connection->connect_errno) {
         printf("Connection failed: %s\n", $connection->connect_error);
         exit();

    }else{
    }

    $JSONArray = array();
    $consulta = "SELECT * FROM USUARIO WHERE USERNAME = '".$_GET["username"]."'";

    if($result = $connection->query($consulta)){
      if($result->num_rows == 0){
        echo "No devuelve ningun resultado";
      }else{
        while($fila = $result->fetch_object()){
            array_push($JSONArray,$fila);
        }
        echo json_encode($JSONArray);
      }
    }else{
      echo $connection->error();
    }
 ?>
