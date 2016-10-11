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
   $jsonArray = array();
   $username = $_GET["username"];
   $animeid = $_GET["animeid"];
   $query = 'SELECT COUNT(*) as total FROM listaanimesfavoritos WHERE username="'.$username.'" AND animeid='.$animeid.'';
   if($result = $connection->query($query)){
     if ($result->num_rows==0) {

     }else{
         while($obj=$result->fetch_object()){
            array_push($jsonArray,$obj);
         }

        //devuelvo los datos en forma de JSON
        $final_res =json_encode($jsonArray) ;
        echo $final_res;
    }
   }else{
      echo $connection->error;
   }
?>
