<?php

  session_start();

  if (isset($_SESSION['user_id'])) {
    header('Location: /bienvenidos.html');
  }
  require 'database.php';

  if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT id, email, password FROM usuarios WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
      $_SESSION['password'] = $results['password'];
      header("Location: /php-login");
    } else {
      $message = 'Disculpe, contraseña no encontrada';
    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <?php require 'partials/header.php' ?>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>Inicia</h1>
    <span>or <a href="signup.php">Registrate</a></span>

    <form action="login.php" method="POST">
      <input name="email" type="text" placeholder="Coloque su correo">
      <input name="password" type="password" placeholder="Coloque su Password">
      <input type="submit" value="Ingresar">
    </form>
  </body>
</html>
