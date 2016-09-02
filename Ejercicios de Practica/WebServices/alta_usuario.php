<?php
   $username='japon';
   $password='1234';
   $database='android';
   $localhost='localhost';

   $connection = new mysqli($localhost, $username, $password, $database);
      //TESTING IF THE CONNECTION WAS RIGHT
   if ($connection->connect_errno) {
        header("Location: ./installation/index.php");
        printf("Connection failed: %s\n", $connection->connect_error);
        exit();

   }else{
   }

   $username = $_GET["username"];
   $userpass = $_GET["userpass"];
   $email = $_GET["email"];
   //$query = 'INSERT INTO USUARIO VALUES("prueba","1234","s@gmail.com");';
   $query = 'INSERT INTO USUARIO VALUES("'.$username.'","'.$userpass.'","'.$email.'");';
   if($connection->query($query)){

   }else{
      echo $connection->error;
   }
?>
