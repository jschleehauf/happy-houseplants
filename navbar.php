<?php
// Get the current page filename
$currentFile = basename($_SERVER['PHP_SELF']);

// Set the $currentPage variable based on the current page
if ($currentFile === 'index.php') {
    $currentPage = 'login';
} elseif ($currentFile === 'aboutus.php') {
    $currentPage = 'about';
} elseif ($currentFile === 'contactus.php') {
    $currentPage = 'contact';
} elseif ($currentFile === 'products.php') {
    $currentPage = 'products';
} elseif ($currentFile === 'home.php') {
    $currentPage = 'home';
} else {
    $currentPage = ''; // Set a default value if needed
}
?>

<nav class="topnav">
  <a href="index.php" <?php if ($currentPage === 'login') echo 'class="active"'; ?>>Login</a>
  <a href="home.php" <?php if ($currentPage === 'home') echo 'class="active"'; ?>>Home</a>
  <a href="products.php" <?php if ($currentPage === 'products') echo 'class="active"'; ?>>Products</a>
  <a href="contactus.php" <?php if ($currentPage === 'contact') echo 'class="active"'; ?>>Contact</a>
  <a href="aboutus.php" <?php if ($currentPage === 'about') echo 'class="active"'; ?>>About</a>
</nav>
