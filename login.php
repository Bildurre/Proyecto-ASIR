<?php include("partes/head.php") ?>


<?php
if ($_SESSION['usuario'] != "") {
 header("Location: /");
 exit();
}
?>

<div class="div-login">
  <p>Parece que el email o la contraseña no son correctos</p>
  <p>Vuelve a intentarlo o regístrate<p>

  <form action=<?php echo "'" . $_SERVER['PHP_SELF'] . "'"?> method='POST'class="login-grande">
    <p>Email: </p>
    <input type="text" name="email" id="email" placeholder="email">
    <p>Contraseña: </p>
    <input type="password" name="password" id="password" placeholder="password">
    <div>
      <input type="submit" name="submit" id="submit" value="login">
      <button name="signup">Sign-up</button>
    </div>
  </form>
</div>



<?php include("partes/footer.php") ?>
