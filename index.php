<?php include("partes/head.php") ?>

<?php
$host = "localhost";
$user = "root";
$password = "12345678";
$data_base = "proyecto";

$conexion = @mysqli_connect($host,$user,$password,$data_base);

if ($conexion) {
  $seleccion = mysqli_select_db($conexion,"proyecto");
  $conectado = true;
}

if ($conectado && $seleccion) {
  $consulta = "select p.nombre, p.tipo, p.descripcion, p.id_producto
              from productos p;";
  $resultado = mysqli_query ($conexion, $consulta);
  $conectado = true;
}

mysqli_close($conexion);

if ($conectado) {
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
} else {
  echo "fuuuuu";
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

?>

<?php include("partes/footer.php") ?>

<script>
document.querySelectorAll('.form-previsual').forEach(function(item) {
  item.addEventListener('click', function() {
    this.submit();
  });
   });

</script>

