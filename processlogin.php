<?php
// Storing username and password in Cookies if choose to Remember
if(!empty($_POST["remember"])) {
  setcookie("shopusername",$_POST["shopusername"]);
  setcookie("shoppassword",$_POST["shoppassword"]);
  echo "Cookies Set  Successfully";
}
else {
  setcookie("shopusername", "");
  setcookie("shoppassword", "");
  echo "Cookies Not Set";
}
?>
<p><a href="index.php"> Go back to login Page </a></p>