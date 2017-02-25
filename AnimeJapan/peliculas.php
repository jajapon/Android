<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  </head>
  <body style="background-image:url(http://imagenesfotos.com/wp-content/2009/07/abstract-20.jpg)">
    <div class="table-responsive" style="border-radius:3px;width:1040px;margin:0 auto;margin-top:30px;background-color:#FFFFFF">

    <div style="width:100%;height:40px;background-color:#FF0080;color:white;font-weight:bold;text-align:center;font-size:21px;padding-top:7px">
        PELÍCULAS
     </div>

    <table class="table-bordered" style="width:100%;text-align:center;font-size:12px">
      <tr style="background-color:#DF0174;color:white;height:25px">
        <th style="text-align:center"> IMAGEN</th>
        <th style="text-align:center">NOMBRE</th>
        <th style="text-align:center">ENLACE</th>
      </tr>
      <?php if (isset($_ENV['OPENSHIFT_APP_NAME'])) {
        $db_user=$_ENV['OPENSHIFT_MYSQL_DB_USERNAME']; //Openshift db name OPENSHIFT_MYSQL_DB_USERNAME
        $db_host=$_ENV['OPENSHIFT_MYSQL_DB_HOST']; //Openshift db host OPENSHIFT_MYSQL_DB_HOST
        $db_password=$_ENV['OPENSHIFT_MYSQL_DB_PASSWORD']; //Openshift db password OPENSHIFT_MYSQL_DB_PASSWORD
        $db_name="peliculasjapan"; //Openshift db name
      } else {
          $db_user='japon'; //my db user
          $db_host='localhost'; //my db host
          $db_password='1234'; //my db password
          $db_name='peliculasjapan'; //my db name
      }
      $connection = new mysqli($db_host, $db_user, $db_password, $db_name);
         //TESTING IF THE CONNECTION WAS RIGHT
      if ($connection->connect_errno) {
           printf("Connection failed: %s\n", $connection->connect_error);
           exit();

      }else{
      }

      $jsonArray = array();

      $query = 'SELECT * FROM pelicula ORDER BY nombre';
      if($result = $connection->query($query)){
        if ($result->num_rows==0) {

        }else{
            while($obj=$result->fetch_object()){
              echo '<tr style="height:60px">
              <td><img  style ="width:50px" src="'.$obj->imagen.'" alt="" /></td>
                <td>'.$obj->nombre.'</td>
                <td><a href="'.$obj->enlace.'">'.$obj->enlace.'</a></td>
              </tr>';            }
       }
      }else{
         echo $connection->error;
      }
       ?>
    </table>
  </div>

  </body>
</html>
