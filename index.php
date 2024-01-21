<!DOCTYPE html>
<html>
  <!-- Midterm Project - Jarratt Schleehauf - 10/08/23 -->
  <head>
      <title>Happy Houseplants Login</title>
      <link href="script.css" rel="stylesheet">
    </head>
  <body>
    <?php include 'header.php';?>
    <?php include 'navbar.php';?>
    <?php
    /**
    * Script Name: Form Login Remember with Cookies
    **/
    ?>
  <form action="processlogin.php" method="post">
    <h1>Login</h1>
    <p>
      Username: <input name="shopusername" type="text" value="<?php if(isset($_COOKIE["shopusername"])) { echo $_COOKIE["shopusername"]; } ?>" class="input-field">
    </p>
      <p>
        Password: <input name="shoppassword" type="password" value="<?php if(isset($_COOKIE["shoppassword"])) {
      echo $_COOKIE["shoppassword"]; } ?>" class="input-field">
      </p>
        <p><input type="checkbox" name="remember" value="remember"/>Remember me</p>
    <p><input type="submit" value="Login"></p></span></p>
  </form>

  </body>  
</html>