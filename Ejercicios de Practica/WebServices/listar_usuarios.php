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

  // $username = $_GET["username"];
  // $userpass = $_GET["userpass"];
  // $email = $_GET["email"];
   $jsonArray = array();

   //$query = 'INSERT INTO USUARIO VALUES("prueba","1234","s@gmail.com");';
   $query = 'SELECT * FROM USUARIO';
   if($result = $connection->query($query)){
     if ($result->num_rows==0) {

      }else{
         while($obj=$result->fetch_object()){
            array_push($jsonArray,$obj);
         }
         //var_dump($jsonArray);
        $final_res =json_encode($jsonArray) ;
        echo $final_res;
    }
   }else{
      echo $connection->error;
   }
?>
