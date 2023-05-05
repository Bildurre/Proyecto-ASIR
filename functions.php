<?php 
function conectar($host) {
  $user = "root";
  $password = "12345678";
  $data_base = "proyecto";

  $conexion = mysqli_connect($host,$user,$password,$data_base);
  if (!$conexion){
    echo "<p style='color:red'>Error al conectar con la base de datos.<br>";
    echo "C&oacute;digo de error: ".mysqli_connect_errno()."<br>";
    echo "Descripci&oacute;n del error: ".mysqli_connect_error()."</p>";
    exit;
  }
  return true;
}



function login($username,$password) {


}

?>