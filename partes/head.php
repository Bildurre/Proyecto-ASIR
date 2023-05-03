<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proyecto</title>
  <link rel="stylesheet" href="/var/www/html/styles/style.css">
</head>
<body>
  <?php session_start() ?>
  <header class="bg-so-dark-green">
    <h1>PROYECTO</h1>
    <?php if (!isset($_SESSION["user"]) && $_SERVER["REQUEST_URI"] != "/login.php") { ?>
    <form class="login">
      <input type="text" name="email" id="email" placeholder="email">
      <input type="password" name="password" id="password" placeholder="password">
      <div>
        <input type="submit" name="submit" id="submit" value="login">
        <button name="signup">Sign-up</button>
      </div>
    </form>
    <?php } elseif (!isset($_SESSION["user"])) { ?>
    <div class="bienvenido">
      <p>Bienvenido</p>
      <p> <?php echo $_SESSION["user"] ?>!</p>
    </div>
    <?php } ?>
  </header>
  <ul class="menu bg-dark-green">
    <li><a href="/var/www/html/">HOME</a></li>
    <li><a href="/var/www/html/login.php">CATÁLOGO</a></li>
    <li><a href="">MIS PEDIDOS</a></li>
    <li><a href="">GESTIONAR</a></li>
  </ul>
  <main class="bg-light-green">