<?php include("partes/head.php") ?>

<div class="div-login">
<?php if (!isset($_POST['go'])){ ?>
   
  <form action="/registro.php" method="POST" class="login-grande">
    <p>Email</p>
    <input type="email" name="email" placeholder="email">
    <p>Contraseña: </p>
    <input type="password" name="password" placeholder="password">
    <p>Nombre: </p>
    <input type="text" name="nombre" placeholder="Nombre">
    <p>Primer Apellido: </p>
    <input type="text" name="apellido1" placeholder="Primer Apellido">
    <p>Segundo Apellido: </p>
    <input type="text" name="apellido2" placeholder="Segundo Apellido">
    <p>Teléfono: </p>
    <input type="tel" name="telefono" placeholder="Teléfono">
    <div>
      <input type="submit" value="Regístrame" name="go">
    </div>
  </form>
<?php } else {

  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  $conexion = mysqli_init();
  $conexion -> options(MYSQLI_OPT_CONNECT_TIMEOUT, 1);
  

  $password = "12345678";
  $data_base = "proyecto";

  try {
    $real_conexion = mysqli_real_connect($conexion, "192.168.100.11",'invitado',$password,$data_base);
  } catch (Exception $e) {
    try {
      $real_conexion = mysqli_real_connect($conexion, "192.168.100.12",'invitado',$password,$data_base);
    } catch (Exception $e) {
      try {
        $real_conexion = mysqli_real_connect($conexion, "localhost",'invitado',$password,$data_base);
      } catch (Exception $e) {
        echo "<p>Ha fallado la conexion con la base de datos</p>";
        $real_conexion = false;
      }
    }
  }

  try {
    $seleccion = mysqli_select_db($conexion,"proyecto");
    $consulta = "INSERT INTO usuarios VALUES 
                (NULL, '"
                . $_POST['nombre'] . "', '"
                . $_POST['apellido1'] . "', '"
                . $_POST['apellido2'] . "', '"
                . $_POST['email'] . "', MD5('"
                . $_POST['password'] . "'), "
                . $_POST['telefono'] . ", false);";
    $resultado = mysqli_query ($conexion, $consulta);
    if ($resultado) {

        $consulta = "select nombre, id_usuario, admin
                    from usuarios
                    where email = '" . $_POST['email'] . "' and 
                    contrasenia = md5('" . $_POST['password'] . "');";
        $resultado = mysqli_query ($conexion, $consulta);
      
        mysqli_close($conexion);
  
        $array_resultados = [
          "nombre" => "",
          "id_usuario" =>"",
          "admin" => ""];
  
        while ($fila = mysqli_fetch_row($resultado)) {
          $array_resultados = [
            "nombre" => $fila[0],
            "id_usuario" => $fila[1],
            "admin" => $fila[2]
          ];
        }
          
        $_SESSION['usuario'] = $array_resultados['nombre'];
        $_SESSION['id_usuario'] = $array_resultados['id_usuario'];
        $_SESSION['usuario_admin'] = $array_resultados['admin'];

      header ("Location: /");

    } else {
      header ("Location: /registro.php");
    }
    
  } catch (Exception $e) {
  }
}
?>
</div>



<?php include("partes/footer.php") ?>
