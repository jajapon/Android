<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
      <form class="" action="subida_multiple.php" method="POST">
        <textarea rows="10" cols="50" name="datos" id="datos"></textarea>
        <input type="submit" name="enviar" value="Enviar">
      </form>

      <?php
          if(isset($_POST["datos"])){
            $enlaces = nl2br($_POST['datos']);
            $enlaces = explode('<br />',$ids);
            var_dump($ids);
          }else{

          }
       ?>
  </body>
</html>
