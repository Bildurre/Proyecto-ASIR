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
              from productos p;";
  $resultado = mysqli_query ($conexion, $consulta);
  mysqli_close($conexion);

  $array_resultados = [];
  $contador = 0;
  while ($fila = mysqli_fetch_row($resultado)) {
    $array_resultados[$contador] = [
      "nombre" => $fila[0],
      "tipo" => $fila[1],
      "descripcion" => $fila[2],
      "id" => $fila[3]
    ];
    $contador++;
  }

  $cantidad_productos = sizeof($array_resultados) - 1;
  $n = 0;
  $random_array = [];

  while ($n < 12) {
    $numero_random = rand(0,$cantidad_productos);
    if (!in_array($numero_random, $random_array)) {
      array_push($random_array, $numero_random);
      $n++;
    }
  }

  echo "<div class='main'>";
  foreach ($random_array as $posicion) {
    echo "<form method='POST' action='producto.php' class='form-previsual'>";
      echo "<img src='imagenes/".$array_resultados[$posicion]['tipo'].".jpg'>";
      echo "<p><strong>" . $array_resultados[$posicion]['nombre'] . "</strong></p>";
      echo "<p>Tipo: " . ucfirst($array_resultados[$posicion]['tipo']) . "</p>";
      echo "<hr>";
      echo "<p class='descripcion'>" . $array_resultados[$posicion]['descripcion'] . "</p>";
      echo "<input type='hidden' name='id_producto' value='".$array_resultados[$posicion]['id']."'>";
    echo "</form>";
  }
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

