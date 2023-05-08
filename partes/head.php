<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proyecto</title>
  <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
  <?php session_start() ?>
  <?php 
  if (isset($_POST["signup"])) {
    header("Location: /registro.php");
  }

  if (isset($_POST) && $_SERVER["REQUEST_URI"] != "/registro.php") {
    if ((isset($_POST['destroy']))) {
      $_SESSION = [];
    }
    if (isset($_SESSION['usuario']) && $_SESSION['usuario_admin'] == '1'){
      $user = 'administrador';
    } elseif (isset($_SESSION['usuario']) && $_SESSION['usuario_admin'] == '0') {
      $user = 'registrado';
    } else {
      $user = 'invitado';
    }
    $password = "12345678";
    $data_base = "proyecto";
    
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conexion = mysqli_init();
    $conexion -> options(MYSQLI_OPT_CONNECT_TIMEOUT, 1);
    
    try {
      $real_conexion = mysqli_real_connect($conexion, "192.168.100.11",$user,$password,$data_base);
    } catch (Exception $e) {
      try {
        $real_conexion = mysqli_real_connect($conexion, "192.168.100.12",$user,$password,$data_base);
      } catch (Exception $e) {
        try {
          $real_conexion = mysqli_real_connect($conexion, "localhost",$user,$password,$data_base);
        } catch (Exception $e) {
          echo "<p>Ha fallado la conexion con la base de datos</p>";
          $real_conexion = false;
        }
      }
    }

    try {
      $seleccion = mysqli_select_db($conexion,"proyecto");
    
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
      
      $lineas = mysqli_num_rows($resultado);
      if ($lineas == 0 && $_POST["submit"] == "login") {
        header("Location: login.php"); 
        exit();
      }


      if ($lineas == 1){
        $_SESSION['usuario'] = $array_resultados['nombre'];
        $_SESSION['id_usuario'] = $array_resultados['id_usuario'];
        $_SESSION['usuario_admin'] = $array_resultados['admin'];
      }
    
    } catch (Exception ) {
      echo "<p>Ha fallado la conexion con la base de datos</p>";
      $real_conexion = false;
    }
  }
  
  ?>

  <header class="bg-so-dark-green">
    <h1>PROYECTO</h1>
    <?php if (!isset($_SESSION["usuario"]) 
    && $_SERVER["REQUEST_URI"] != "/login.php"
    && $_SERVER["REQUEST_URI"] != "/registro.php") { ?>
    <form action=<?php echo "'" . $_SERVER['PHP_SELF'] . "'"?> method='POST'class="login">
      <input type="text" name="email" id="email" placeholder="email">
      <input type="password" name="password" id="password" placeholder="password">
      <div>
        <input type="submit" name="submit" id="submit" value="login">
        <input type="submit" name="signup" id="signup" value="signup">
      </div>
    </form>
    <?php } elseif (isset($_SESSION["usuario"])) { ?>
    <div class="bienvenido">
      <p>Bienvenid@</p>
      <p> <?php echo $_SESSION["usuario"] ?>!</p>
      <form action=<?php echo "'" . $_SERVER['PHP_SELF'] . "'"?> method='POST'class="login">
        <input type="submit" name="destroy" id="submit" value="log-out">
      </form>
    </div>
    <?php } ?>
  </header>
  <ul class="menu bg-dark-green">
    <li><a href="/">HOME</a></li>
    <li><a href="/catalogo.php">CATÁLOGO</a></li>
    <li><a href="/pedidos.php">MIS PEDIDOS</a></li>
    <li><a href="/gestion.php">GESTIONAR</a></li>
  </ul>
  <main class="bg-light-green">
