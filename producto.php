<?php include("partes/head.php") ?>
<?php
$user = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : "invitado";
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

  $consulta = "select p.nombre, p.tipo, p.descripcion,
                      f.precio, f.stock, f.volumen
              from productos p join formatos f
              on p.id_producto = f.id_producto
              where p.id_producto = '".$_POST['id_producto']."'
              order by f.volumen asc;";
  $resultado = mysqli_query ($conexion, $consulta);

  mysqli_close($conexion);

  $array_resultados = [];
  $contador = 0;
  while ($fila = mysqli_fetch_row($resultado)) {
    $array_resultados[$contador] = [
      "nombre" => $fila[0],
      "tipo" => $fila[1],
      "descripcion" => $fila[2],
      "precio" => $fila[3],
      "stock" => $fila[4],
      "volumen" => $fila[5]
    ];
    $contador++;
  }
    $longitud = sizeof($array_resultados);


  echo "<div class='main'>";
    echo "<div class='form-previsual-grande'>";
      echo "<img src='imagenes/" . $array_resultados[0]['tipo'] . ".jpg'>";
      echo "<div class='contenido'>";
        echo "<div>";
          echo "<p>nombre: " . $array_resultados[0]['nombre'] . "</p>";
          echo "<p>tipo: " . $array_resultados[0]['tipo'] . "</p>";
          echo "<p>descripcion: " . $array_resultados[0]['descripcion'] . "</p>";
        echo "</div>";
        echo "<div class='botones'>";
          for ($n = 0; $n < $longitud; $n++) {
            echo "<form action='pedidos.php' method='POST' class='form-boton'>";
              echo "<p>" . $array_resultados[$n]['volumen'] . "ml</p>";
              echo "<p>" . $array_resultados[$n]['precio'] . "€</p>";
            echo "</form>";
          }
        echo "</div>";
      echo "</div>";
    echo "</div>";
  echo "</div>";


} catch (Exception ) {
  echo "<p>Ha fallado la conexion con la base de datos</p>";
  $real_conexion = false;
}

?>
<?php include("partes/footer.php") ?>
