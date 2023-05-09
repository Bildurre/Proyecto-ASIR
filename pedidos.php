<?php include("partes/head.php") ?>

<?php
if ($_POST['boton_agregar'] && $_SESSION['usuario'] && $_SESSION['usuario_admin'] == '0') {
  if (!$_SESSION['npedido']) {
    $_SESSION['npedido'] = [];
  }
  $n = sizeof($_SESSION['npedido']);
  for ($i=0; $i <= $n; $i++) { 
    if ($_SESSION['npedido'][$i]['id_formato'] == $_POST['id_formato']) {
      $_SESSION['npedido'][$i]['cantidad'] = $_SESSION['npedido'][$i]['cantidad'] + $_POST['cantidad'];
    } else {
      $_SESSION['npedido'][$n]['nombre'] = $_POST['nombre'];
      $_SESSION['npedido'][$n]['tipo'] = $_POST['tipo'];
      $_SESSION['npedido'][$n]['precio'] = $_POST['precio'];
      $_SESSION['npedido'][$n]['cantidad'] = $_POST['cantidad'];
      $_SESSION['npedido'][$n]['id_formato'] = $_POST['id_formato'];
    }
  } 
  
} elseif ($_POST['boton_agregar'] && !$_SESSION['usuario'] ){
  header("Location: /registro.php");
}
?>;

<?php 
if ($_POST['hacer']) {

  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conexion = mysqli_init();
    $conexion -> options(MYSQLI_OPT_CONNECT_TIMEOUT, 1);


    $password = "12345678";
    $data_base = "proyecto";

    try {
      $real_conexion = mysqli_real_connect($conexion, "192.168.100.11",'administrador',$password,$data_base);
    } catch (Exception $e) {
      try {
        $real_conexion = mysqli_real_connect($conexion, "192.168.100.12",'administrador',$password,$data_base);
      } catch (Exception $e) {
        try {
          $real_conexion = mysqli_real_connect($conexion, "localhost",'administrador',$password,$data_base);
        } catch (Exception $e) {
          echo "<p>Ha fallado la conexion con la base de datos</p>";
          $real_conexion = false;
        }
      }
    }
    try {
      $seleccion = mysqli_select_db($conexion,"proyecto");

      $consulta = "insert into pedidos values
                  (null," . (int)$_SESSION['id_usuario'] . ", now(), 'en espera');";
      $resultado = mysqli_query ($conexion, $consulta);
      $consulta = "select max(id_pedido)
                  from pedidos
                  where id_usuario = " . $_SESSION['id_usuario'] . ";";
      $resultado = mysqli_query ($conexion, $consulta);

      while ($fila = mysqli_fetch_row($resultado)) {   
        $id_pedido = $fila[0];
      }
      
      $n = sizeof($_SESSION['npedido']);
      
      for ($i = 0; $i < $n; $i++) {
        $consulta = "insert into listas_pedidos values (
        " . (int)$id_pedido . ",
        " . (int)$_SESSION['npedido'][$i]['id_formato'] . ",
        " . (int)$_SESSION['npedido'][$i]['cantidad'] . ");";
        $resultado = mysqli_query ($conexion, $consulta);
        
        }
        $_SESSION['npedido'] = [];
        $_pedido = true;
    } catch (Exception $e){
    }

  }

?>

<?php if ($_SESSION['usuario_admin'] == '1') {

  if ($_POST['cambiar']) {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conexion = mysqli_init();
    $conexion -> options(MYSQLI_OPT_CONNECT_TIMEOUT, 1);


    $password = "12345678";
    $data_base = "proyecto";

    try {
      $real_conexion = mysqli_real_connect($conexion, "192.168.100.11",'administrador',$password,$data_base);
    } catch (Exception $e) {
      try {
        $real_conexion = mysqli_real_connect($conexion, "192.168.100.12",'administrador',$password,$data_base);
      } catch (Exception $e) {
        try {
          $real_conexion = mysqli_real_connect($conexion, "localhost",'administrador',$password,$data_base);
        } catch (Exception $e) {
          echo "<p>Ha fallado la conexion con la base de datos</p>";
          $real_conexion = false;
        }
      }
    }
    try {
      $seleccion = mysqli_select_db($conexion,"proyecto");
      $consulta = "update pedidos
                  set estado = '" . $_POST['estado'] . "'
                  where id_pedido = " . $_POST['id'] . ";";
      $resultado1 = mysqli_query ($conexion, $consulta);
    } catch (Exception $e){

    }
  }
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conexion = mysqli_init();
$conexion -> options(MYSQLI_OPT_CONNECT_TIMEOUT, 1);


$password = "12345678";
$data_base = "proyecto";

try {
  $real_conexion = mysqli_real_connect($conexion, "192.168.100.11",'administrador',$password,$data_base);
} catch (Exception $e) {
  try {
    $real_conexion = mysqli_real_connect($conexion, "192.168.100.12",'administrador',$password,$data_base);
  } catch (Exception $e) {
    try {
      $real_conexion = mysqli_real_connect($conexion, "localhost",'administrador',$password,$data_base);
    } catch (Exception $e) {
      echo "<p>Ha fallado la conexion con la base de datos</p>";
      $real_conexion = false;
    }
  }
}

try {
  $seleccion = mysqli_select_db($conexion,"proyecto");
  $consulta = "select fecha, id_pedido, estado
              from pedidos;";
  $resultado1 = mysqli_query ($conexion, $consulta);
  if ($resultado1) {
    echo "<div class='main-col'>";
      echo "<h2>PEDIDOS</h2>";
      echo "<div class='linea-pedido'>";
        echo "<div class='celda-pedido'>fecha</div>";
        echo "<div class='celda-pedido'>id</div>";
        echo "<div class='celda-pedido'>estado</div>";
      echo "</div>";
    while ($fila = mysqli_fetch_row($resultado1)) {
      echo "<div class='linea-pedido bg-medium-green'>";

        echo "<div class='celda-pedido'>" . $fila[0] . "</div>";
        echo "<div class='celda-pedido'>" . $fila[1] . "</div>";
        echo "<div class='celda-pedido'>" . $fila[2] . "</div>";
        echo "<div class='celda-pedido'>";
          echo "<form action='pedidos.php' method='POST'>";
            echo "<select name='estado'>";
              echo "<option value='en espera'>En Espera</option>";
              echo "<option value='preparado'>Preparado</option>";
              echo "<option value='entregado'>Entregado</option>";
            echo "</select>";
            echo "<input type='hidden' name='id' value='" . $fila[1] . "'>";
            echo "<input type='submit' name='cambiar' value='cambiar'>";
          echo "</form>";
        echo "</div>";
      echo "</div>";
      
      $consulta2 = "select p.nombre, p.tipo, f.precio, lp.cantidad
      from listas_pedidos lp join formatos f on
      lp.id_formato = f.id_formato join productos p on
      f.id_producto = p.id_producto
      where lp.id_pedido = " . $fila[1] . ";";
     
      $resultado2 = mysqli_query ($conexion, $consulta2);
      if ($resultado2) {
        echo "<div class='linea-producto mgl'>";
          echo "<div class='celda-producto'>nombre</div>";
          echo "<div class='celda-producto'>tipo</div>";
          echo "<div class='celda-producto'>precio</div>";
          echo "<div class='celda-producto'>cantidad</div>";
        echo "</div>";
        while ($fila2 = mysqli_fetch_row($resultado2)) {
        echo "<div class='linea-producto mgl'>";
          echo "<div class='celda-producto'>" . $fila2[0] . "</div>";
          echo "<div class='celda-producto'>" . $fila2[1] . "</div>";
          echo "<div class='celda-producto'>" . $fila2[2] . "</div>";
          echo "<div class='celda-producto'>" . $fila2[3] . "</div>";
        echo "</div>";
        }
      }
      
    }
    echo "<div>";
  } else {
    echo "no hay pedidos";
  }
  
} catch (Exception $e) {
}


} else {
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  $conexion = mysqli_init();
  $conexion -> options(MYSQLI_OPT_CONNECT_TIMEOUT, 1);
  

  $password = "12345678";
  $data_base = "proyecto";
 
  try {
    $real_conexion = mysqli_real_connect($conexion, "192.168.100.11",'registrado',$password,$data_base);
  } catch (Exception $e) {
    try {
      $real_conexion = mysqli_real_connect($conexion, "192.168.100.12",'registrado',$password,$data_base);
    } catch (Exception $e) {
      try {
        $real_conexion = mysqli_real_connect($conexion, "localhost",'registrado',$password,$data_base);
      } catch (Exception $e) {
        echo "<p>Ha fallado la conexion con la base de datos</p>";
        $real_conexion = false;
      }
    }
  }
  
  echo "<div class='main-col'>";
  if (isset($_SESSION['npedido']) && !($_pedido)) {
    $n = sizeof($_SESSION['npedido']);
    echo "<h2>HACER PEDIDO</h2>";
    echo "<div class='linea-producto mgl'>";
      echo "<div class='celda-producto'>nombre</div>";
      echo "<div class='celda-producto'>tipo</div>";
      echo "<div class='celda-producto'>precio</div>";
      echo "<div class='celda-producto'>cantidad</div>";
    echo "</div>";
  
    for ($i=0; $i < $n; $i++) { 
      echo "<div class='linea-producto mgl'>";
      echo "<div class='celda-producto'>" . $_SESSION['npedido'][$i]['nombre'] . "</div>";
      echo "<div class='celda-producto'>" . $_SESSION['npedido'][$i]['tipo'] . "</div>";
      echo "<div class='celda-producto'>" . $_SESSION['npedido'][$i]['precio'] . "</div>";
      echo "<div class='celda-producto'>" . $_SESSION['npedido'][$i]['cantidad'] . "</div>";
      echo "</div>";
    }
    echo "<div class='linea-producto mgl'>";
      echo "<form action='/pedidos.php' method='POST' class='linea-producto' style='margin:auto'>";
        echo "<input type='submit' name='hacer' value='hacer pedido' >";
      echo "</form>";
    echo "</div>";
  }
  try {
    $seleccion = mysqli_select_db($conexion,"proyecto");
    $consulta = "select fecha, id_pedido, estado
                from pedidos
                where id_usuario = '" . $_SESSION['id_usuario'] . "';";
    $resultado1 = mysqli_query ($conexion, $consulta);
    if ($resultado1) {
      
        echo "<h2>PEDIDOS</h2>";
        echo "<div class='linea-pedido'>";
          echo "<div class='celda-pedido'>fecha</div>";
          echo "<div class='celda-pedido'>id</div>";
          echo "<div class='celda-pedido'>estado</div>";
        echo "</div>";
      while ($fila = mysqli_fetch_row($resultado1)) {
        echo "<div class='linea-pedido bg-medium-green'>";

          echo "<div class='celda-pedido'>" . $fila[0] . "</div>";
          echo "<div class='celda-pedido'>" . $fila[1] . "</div>";
          echo "<div class='celda-pedido'>" . $fila[2] . "</div>";
        echo "</div>";
        
        $consulta2 = "select p.nombre, p.tipo, f.precio, lp.cantidad
        from listas_pedidos lp join formatos f on
        lp.id_formato = f.id_formato join productos p on
        f.id_producto = p.id_producto
        where lp.id_pedido = " . $fila[1] . ";";
       
        $resultado2 = mysqli_query ($conexion, $consulta2);
        if ($resultado2) {
          echo "<div class='linea-producto mgl'>";
            echo "<div class='celda-producto'>nombre</div>";
            echo "<div class='celda-producto'>tipo</div>";
            echo "<div class='celda-producto'>precio</div>";
            echo "<div class='celda-producto'>cantidad</div>";
          echo "</div>";
          while ($fila2 = mysqli_fetch_row($resultado2)) {
          echo "<div class='linea-producto mgl'>";
            echo "<div class='celda-producto'>" . $fila2[0] . "</div>";
            echo "<div class='celda-producto'>" . $fila2[1] . "</div>";
            echo "<div class='celda-producto'>" . $fila2[2] . "</div>";
            echo "<div class='celda-producto'>" . $fila2[3] . "</div>";
          echo "</div>";
          }
        }
        
      }
     
    } else {
      echo "no hay pedidos";
    }
    echo "<div>";
  } catch (Exception $e) {
  }
}

?>

<?php include("partes/footer.php") ?>