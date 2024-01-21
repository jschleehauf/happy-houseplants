<!DOCTYPE html>
<html>
  <head>
    <title>Process Contact Form</title>
    <meta http-equiv="content-type" content="text/html" charset="utf-8" />
  </head>
  <body>
  <?php
    $errorMsg = "";

    if (empty($_POST['myName']))
      $errorMsg .= "<p>You must enter your name.</p>\n";

    if (empty($_POST['myEmail'])) {
      $errorMsg .= "<p>You must enter your email.</p>\n";
    } else {
        if (!filter_var($_POST['myEmail'], FILTER_VALIDATE_EMAIL))
          $errorMsg .= "<p>Invalid email format.</p>\n";
    }

    if (empty($_POST['myCell'])) {
      $errorMsg .= "<p>You must enter your cell phone number.</p>\n";
    } else {
      $phone = str_replace([' ', '.', '-', '(', ')', ], '', $_POST['myCell']);
      if (!preg_match('/^[0-9]{10}+$/', $phone))
        $errorMsg .= "<p>Invalid cell phone number format.</p>\n";
    }

    if (empty($_POST['myHome'])) {
      $errorMsg .= "<p>You must enter your home phone number.</p>\n";
    }  else {
        $phone2 = str_replace([' ', '.', '-', '(', ')', ], '', $_POST['myHome']);
      if (!preg_match('/^[0-9]{10}+$/', $phone2))
        $errorMsg .= "<p>Invalid home phone number format.</p>\n";
    }    

    if (empty($_POST['comments']))  $errorMsg .= "<p>You must enter your question.</p>\n";
    if (empty($_POST["myradio"]))
      $errorMsg .= "<p>You must select Yes or No.</p>\n";
    if (empty($_POST["myselect"]))
      $errorMsg .="<p>You must select a Client Type.</p>\n";
    if (empty($_POST["myselect2"]))
      $errorMsg .="<p>You must select a How did you hear about us.</p>\n";

    if (strlen($errorMsg) > 0) {
      echo $errorMsg;
      echo "<p>Click you browser's Back button to return to the Contact form and fix these errors.</p>\n";
    } else {
      $myName = addslashes($_POST['myName']);
      $myEmail = addslashes($_POST['myEmail']);
      $myCell = addslashes($_POST['myCell']);
      $myHome = addslashes($_POST['myHome']);
      $comments = addslashes($_POST['comments']);
      $myradio = addslashes($_POST['myradio']);
      $myselect = addslashes($_POST['myselect']);
      $myselect2 = addslashes($_POST['myselect2']);
      $ContactInfo = fopen("contactinfo.txt", "a");

    if (is_writeable("contactinfo.txt")) {
      if (fwrite($ContactInfo, $myName . ", "
                . $myEmail . ", "
                . $myCell . ", "
                . $myHome . ", "
                . $comments . ", "
                . $myradio . ", "
                . $myselect . ", "
                . $myselect2 . ", "
                . "\n"))
        echo "<p>Thank you for contacting us!</p>\n";
      else
        echo "<p>Cannot process your contact.</p>\n";
    } else 
      echo "<p>Cannot write to the file.</p>\n";
    fclose($ContactInfo);  
    }

  ?>

</body>
</html>