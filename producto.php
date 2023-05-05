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
  $consulta = "select p.nombre, p.tipo, p.descripcion,
                      f.precio, f.stock, f.volumen
              from productos p join formatos f
              on p.id_producto = f.id_producto
              where p.id_producto = '".$_POST['id_producto']."'
              order by f.volumen asc;";
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
      "precio" => $fila[3],
      "stock" => $fila[4],
      "volumen" => $fila[5]
    ];
    $contador++;
  }
} else {
  echo "fuuuuu";
}

$longitud = sizeof($array_resultados);

$volumenes = [];
for ($i = 0;$i < $longitud; $i++) {
  $volumenes[$i] = $array_resultados[$i]['volumen'];
}

$hidden = false;

echo "<div class='main'>";
for ($i = 0;$i < $longitud; $i++) {   
     
    echo "<form method='POST' action='producto.php' class='form-previsual-grande";
    if ($hidden) {
      echo " hidden";
    } else {
      $hidden = true;
    }
    echo " ml-" . $array_resultados[$i]['volumen'] . "'>";
    echo "<img src='imagenes/".$array_resultados[$i]['tipo'].".jpg'>";

    echo "<div>";
    echo "<p><strong>" . $array_resultados[$i]['nombre'] . "</strong></p>";
    echo "<p>Tipo: " . ucfirst($array_resultados[$i]['tipo']) . "</p>";
    echo "<hr>";
    echo "<p class='descripcion'>" . $array_resultados[$i]['descripcion'] . "</p>";
    foreach ($volumenes as $volumen){
      echo "<p class='volumen' ";
      echo "id='ml-" . $volumen . "'>";
      echo "Volumen: " . $volumen . "ml </p>";
    }
    echo "<p'>Precio: " . $array_resultados[$i]['precio']/100 . " €</p>";
    echo "<p class='stock'>Disponibles: " . $array_resultados[$i]['stock'] . " unidades</p>";
    echo "</div>";

    echo "<input type='hidden' name='id_producto' value='".$array_resultados[$i]['id']."'>";
    echo "</form>";
}
echo "</div>";

?>
<?php include("partes/footer.php") ?>

<script>

document.querySelectorAll('.volumen').forEach(function(item) {
  item.addEventListener('click', function() {
    this.parentNode.parentNode.classList.add("hidden")
    const ml = this.id
    alert (ml)
    document.querySelectorAll('.form-previsual-grande').forEach(function(form){
      
      if (form.classList.contains(ml)) {
        alert ('eeeooo')
        form.classList.remove('hidden')
      }
    })
  });
   });

</script>