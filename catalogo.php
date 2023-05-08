<?php include("partes/head.php") ?>

<?php


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
  $consulta = "select p.nombre, p.tipo, p.descripcion, p.id_producto
              from productos p
              where tipo = 'aceite';";
  $resultado = mysqli_query ($conexion, $consulta);

 

  echo "<div class='main-catalogo'>";
    echo "<div class='tipo' >";?>
    <div class='titulo-tipo' onclick='document.getElementById("todos-aceite").classList.toggle("hidden")'>
      <?php echo "<h2 onclick>ACEITES</h2>";
    echo "</div>";
    echo "<div class='tipo-todos hidden' id='todos-aceite'>";
  while ($fila = mysqli_fetch_row($resultado)) {
    echo "<form method='POST' action='producto.php' class='concreto aceite form-previsual '>";
      echo "<img src='imagenes/" . $fila[1] . ".jpg'>";
      echo "<p><strong>" . $fila[0] . "</strong></p>";
      echo "<p>Tipo: " . ucfirst($fila[1]) . "</p>";
      echo "<hr>";
      echo "<p class='descripcion'>" . $fila[2] . "</p>";
      echo "<input type='hidden' name='id_producto' value='".$fila[3]."'>";
    echo "</form>";
  }
echo "</div>";
  echo "</div>";


  $seleccion = mysqli_select_db($conexion,"proyecto");
  $consulta = "select p.nombre, p.tipo, p.descripcion, p.id_producto
              from productos p
              where tipo = 'cacao';";
  $resultado = mysqli_query ($conexion, $consulta);

 

  echo "<div class='tipo' >";?>
    <div class='titulo-tipo' onclick='document.getElementById("todos-cacao").classList.toggle("hidden")'>
      <?php echo "<h2 onclick>CACAOS</h2>";
    echo "</div>";
    echo "<div class='tipo-todos hidden' id='todos-cacao'>";
  while ($fila = mysqli_fetch_row($resultado)) {
    echo "<form method='POST' action='producto.php' class='concreto cacao form-previsual '>";
      echo "<img src='imagenes/" . $fila[1] . ".jpg'>";
      echo "<p><strong>" . $fila[0] . "</strong></p>";
      echo "<p>Tipo: " . ucfirst($fila[1]) . "</p>";
      echo "<hr>";
      echo "<p class='descripcion'>" . $fila[2] . "</p>";
      echo "<input type='hidden' name='id_producto' value='".$fila[3]."'>";
    echo "</form>";
  }
  echo "</div>";
  echo "</div>";


  $seleccion = mysqli_select_db($conexion,"proyecto");
  $consulta = "select p.nombre, p.tipo, p.descripcion, p.id_producto
              from productos p
              where tipo = 'crema';";
  $resultado = mysqli_query ($conexion, $consulta);

 

  echo "<div class='tipo' >";?>
    <div class='titulo-tipo' onclick='document.getElementById("todos-crema").classList.toggle("hidden")'>
      <?php echo "<h2 onclick>CREMAS</h2>";
    echo "</div>";
    echo "<div class='tipo-todos hidden' id='todos-crema'>";
  while ($fila = mysqli_fetch_row($resultado)) {
    echo "<form method='POST' action='producto.php' class='concreto crema form-previsual '>";
      echo "<img src='imagenes/" . $fila[1] . ".jpg'>";
      echo "<p><strong>" . $fila[0] . "</strong></p>";
      echo "<p>Tipo: " . ucfirst($fila[1]) . "</p>";
      echo "<hr>";
      echo "<p class='descripcion'>" . $fila[2] . "</p>";
      echo "<input type='hidden' name='id_producto' value='".$fila[3]."'>";
    echo "</form>";
  }
  echo "</div>";
  echo "</div>";


  $seleccion = mysqli_select_db($conexion,"proyecto");
  $consulta = "select p.nombre, p.tipo, p.descripcion, p.id_producto
              from productos p
              where tipo = 'pomada';";
  $resultado = mysqli_query ($conexion, $consulta);


  echo "<div class='tipo' >";?>
    <div class='titulo-tipo' onclick='document.getElementById("todos-pomada").classList.toggle("hidden")'>
      <?php echo "<h2 onclick>POMADAS</h2>";
    echo "</div>";
    echo "<div class='tipo-todos hidden' id='todos-pomada'>";
  while ($fila = mysqli_fetch_row($resultado)) {
    echo "<form method='POST' action='producto.php' class='concreto pomada form-previsual '>";
      echo "<img src='imagenes/" . $fila[1] . ".jpg'>";
      echo "<p><strong>" . $fila[0] . "</strong></p>";
      echo "<p>Tipo: " . ucfirst($fila[1]) . "</p>";
      echo "<hr>";
      echo "<p class='descripcion'>" . $fila[2] . "</p>";
      echo "<input type='hidden' name='id_producto' value='".$fila[3]."'>";
    echo "</form>";
  }
  echo "</div>";
  echo "</div>";


  $seleccion = mysqli_select_db($conexion,"proyecto");
  $consulta = "select p.nombre, p.tipo, p.descripcion, p.id_producto
              from productos p
              where tipo = 'tintura';";
  $resultado = mysqli_query ($conexion, $consulta);
 

  echo "<div class='tipo' >";?>
    <div class='titulo-tipo' onclick='document.getElementById("todos-tintura").classList.toggle("hidden")'>
      <?php echo "<h2 onclick>TINTURAS</h2>";
    echo "</div>";
    echo "<div class='tipo-todos hidden' id='todos-tintura'>";
  while ($fila = mysqli_fetch_row($resultado)) {
    echo "<form method='POST' action='producto.php' class='concreto tintura form-previsual '>";
      echo "<img src='imagenes/" . $fila[1] . ".jpg'>";
      echo "<p><strong>" . $fila[0] . "</strong></p>";
      echo "<p>Tipo: " . ucfirst($fila[1]) . "</p>";
      echo "<hr>";
      echo "<p class='descripcion'>" . $fila[2] . "</p>";
      echo "<input type='hidden' name='id_producto' value='".$fila[3]."'>";
    echo "</form>";
  }
  echo "</div>";
  echo "</div>";
  echo "</div>";


} catch (Exception $e) {
  echo "Uuuups. Algo ha salido mal";
}
?>

<?php include("partes/footer.php") ?>

<script>
document.querySelectorAll('.form-previsual').forEach(function(item) {
  item.addEventListener('click', function() {
    this.submit();
  });
   });
</script>

