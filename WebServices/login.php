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

    $query = "SELECT  * FROM USUARIO WHERE USERNAME = '".$_GET["username"]."' AND USERPASS = '".$_GET["userpass"]."'";
    if($result = $connection->query($query)){
      if($result->num_rows == 0){
        echo "Login incorrecto";
      }else{
        echo "Bienvenido".$_GET["username"];
      }
    }

?>
