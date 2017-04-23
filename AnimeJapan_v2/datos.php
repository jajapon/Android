<?php 

	$db_user='japon'; //my db user
    $db_host='localhost'; //my db host
    $db_password='1234'; //my db password
    $db_name='new_animejapan'; //my db name
    
    $connection_new = new mysqli($db_host, $db_user, $db_password, $db_name);
       //TESTING IF THE CONNECTION WAS RIGHT
    if ($connection_new->connect_errno) {
         printf("Connection failed: %s\n", $connection_new->connect_error);
         exit();

    }else{
    }

	$db_user='japon'; //my db user
    $db_host='localhost'; //my db host
    $db_password='1234'; //my db password
    $db_name='animejapan'; //my db name

    /*$connection_old= new mysqli($db_host, $db_user, $db_password, $db_name);
       //TESTING IF THE CONNECTION WAS RIGHT
    if ($connection_old->connect_errno) {
         printf("Connection failed: %s\n", $connection_old->connect_error);
         exit();

    }else{
    }


    $query_old = "SELECT * FROM capitulo WHERE animeid = 11 ORDER BY ncapitulo";
	$connection_old->query("SET NAMES 'utf8'");
    echo "hola";
	if($result = $connection_old->query($query_old)){
        echo "hola2";
     	while($row = $result->fetch_object()){
            echo "hola3";
     		if($connection_new->query("INSERT INTO capitulo VALUES(68,81,".$row->ncapitulo.",".$row->parte.",'".$row->url."')")){
     		}else{
     			echo $connection_new->error;
     		}
     	}
     }else{
     	echo $connection_old->error;     	
     }*/

      $query_new = "SELECT * FROM capitulo WHERE animeid = 32 ORDER BY ncapitulo";
        $connection_new->query("SET NAMES 'utf8'");

        if($result = $connection_new->query($query_new)){
            while($row = $result->fetch_object()){
                echo $row->url."<br/>";
                $bodytag = str_replace("https://www.youtube.com/watch?v=", "", $row->url);
                echo $bodytag."<br/>";
                echo "UPDATE capitulo SET url = '".$bodytag."' WHERE animeid = ".$row->animeid." AND temporada_id = ".$row->temporada_id." AND ncapitulo = ".$row->ncapitulo." AND parte = ".$row->parte."<br/>";
                /*if($connection_new->query("UPDATE capitulo SET url = '".$bodytag."' WHERE animeid = ".$row->animeid." AND temporada_id = ".$row->temporada_id." AND ncapitulo = ".$row->ncapitulo." AND parte = ".$row->parte)){
                }else{
                    echo $connection_new->error;
                }*/
            }
         }else{
            echo $connection_old->error;        
     }

?>