<!DOCTYPE html>
<html>
  <!-- Midterm Project - Jarratt Schleehauf - 10/08/23 -->
<head>
    <title>Happy Houseplants Product Order Form</title>
    <link href="script.css" rel="stylesheet">
  </head>
<body>
<?php include 'header.php';?>
<?php include 'navbar.php';?>
<?php

// Acquire a SQLite database called MainDB

  class MyDB extends SQLite3
  {
     function __construct()
     {
      $this->open('MainDB.db');
     }
  }
  
  $db = new MyDB();

// Create a new Product table to load the latest products

  $res=$db->exec("DROP TABLE IF EXISTS Product;");
  $res=$db->exec("CREATE TABLE IF NOT EXISTS Product 
                 (prodid INTEGER,
                  prodname TEXT,
                  proddesc TEXT,
                  prodimg TEXT,
                  prodprice REAL);");

// Create a new file called products.csv and put a comma betwen 
// each field in the table. This file has the latest products and 
// will be used to import into the product table in MainDB Database

  $OutName = "products.csv";

// if products.csv found then load each row in the $data array with // each field being assigned to an $item, then insert each item in a // row into the Product table

  if(0 <> filesize($OutName)) {
    $handle = fopen($OutName, "r");
    while($data = fgetcsv($handle)) {
      $item1 =$data[0];
      $item2 =$data[1];
      $item3 =$data[2];
      $item4 =$data[3];
      $item5 =$data[4];
      $sql3 = "INSERT INTO Product values('$item1','$item2','$item3','$item4','$item5');";
       $res=$db->exec($sql3);
  }
    fclose($handle); // close file
  }
// Loop through the Product table to show items on the Order Form

    $i = 0;
    $ItemList = array();
    $query1="SELECT * FROM Product;";
    $result=$db->query($query1);

    while($row= $result->fetchArray()){

      $ItemList[$i]['name']=$row['prodname'];
      $ItemList[$i]['description']=$row['proddesc'];
      $ItemList[$i]['price']=$row['prodprice'];
      $ItemList[$i]['img']=$row['prodimg'];
      $ItemList[$i]['quantity']= 0;
      ++$i; // increment array index by 1
    }
    $db->close(); // close connection to database
    ?>
    <?php

    $ShowForm = FALSE; // initialize Show Form variable
    $ShowLink = FALSE; // initialize Show Link variable

// Check to see if orders were placed for individual products and the quantity selected

    if (isset($_POST['quantity'])) {
      if (is_array($_POST['quantity'])) {
        foreach ($_POST['quantity'] as $Index => $Qty) {

          $ItemList[$Index]["quantity"] = $Qty;
        }
      }
    }

// If the purchase button clicked then build an order transaction file

if (isset($_POST['purchase'])) { // Place order
   $TimeMicro = microtime();
   $TimeArray = explode(" ", $TimeMicro);
   $OutName = $TimeArray[1] . "." . $TimeArray[0] . ".cst";
   $OutArray = array();
   $OrderedItemCount = 0;

// calculate the subtotals for each item
// total quantity and total price for each item
   foreach ($ItemList as $Index => $Info) {
     if ($Info["quantity"] > 0) {
       ++$OrderedItemCount;
       $TempString=$Index . "," . $Info["name"] . "," . $Info["quantity"] . "," . $Info["price"] . "," . ($Info["quantity"] * $Info["price"]) . "\n";
       $OutArray[] = $TempString;
     }
   }

// If at least one item ordered then load the entire order
// into the CustOrder table

  if ($OrderedItemCount > 0) {
     $ShowLink  = TRUE;
     $result=file_put_contents($OutName, $OutArray);
     if ($result===FALSE)
       echo "<p>There was a problem saving your order.</p>\n";
     else {
       echo "<p>Your order was successfully submitted.</p>\n";
     

  // Import the transaction file rows into the CustOrders Tables

    $db =new MyDB();

// Build the CustOrders table if it doesn't already exist

    $res=$db->exec("CREATE TABLE IF NOT EXISTS CustOrders
                  (p_id INTEGER,
                  p_name TEXT,
                  qty INTEGER,
                  u_price REAL,
                  t_price REAL);");

// Import each row from the order data transaction file into 
// CustOrders table

        if(0 <> filesize($OutName)) {
            $handle = fopen($OutName, "r");
            while($data = fgetcsv($handle)) {
              $item1 =$data[0];
              $item2 =$data[1];
              $item3 =$data[2];
              $item4 =$data[3];
              $item5 =$data[4];
              $sql = "INSERT INTO CustOrders
                (p_id, p_name, qty, u_price, t_price)    values('$item1','$item2','$item3','$item4','$item5' )";
               $db->exec($sql);
        }
        fclose($handle); // close file
      }
  }
}

// You have not ordered anything however pushed the submit button

    else {
      echo "<p>You have not ordered anything yet.</p>\n";
      $ShowForm = TRUE;
    }
  }
  
// Add one if the "+" button is clicked

else {
  $ShowForm = TRUE;
  if (isset($_POST['AddItem'])) {
    if (is_array($_POST['AddItem'])) {
      $ItemsToAdd=array_keys($_POST['AddItem']);
      foreach ($ItemsToAdd as $Index) {
        ++$ItemList[$Index]["quantity"];
      }
  }
}

// Deduct one if the  "-" button is clicked

  if (isset($_POST['SubtractItem'])) {
    if (is_array($_POST['SubtractItem'])) {
      $ItemsToSubtract=array_keys($_POST['SubtractItem']);
      foreach ($ItemsToSubtract as $Index) {
        --$ItemList[$Index]["quantity"];
      }
    }
  }
}

// Show form with the items selected so far
echo "<div class='purch'>";
echo "<h1>Product Order Form</h1>";

if ($ShowForm) {
  echo "<form action='products.php' method='POST' style='background-color:#fd8553; border: none;'>\n";
}
echo "<table cellspacing='0' style='width:100%; background-color:#fd8553;'>\n";
echo "<tr><th";

if ($ShowForm) {
  echo " colspan='2'";
}
echo ">Qty</th>" .
     "<th>Item</th>" .
     "<th>Unit Price</th>" .
     "<th>Subtotal</th></tr>\n";

$ItemCount=count($ItemList);
$TotalItems=0;
$TotalAmount=0;
$bgcolor = "LightGrey";

// Build the form with product information and
// subtotal quantities and price as items are selected

for ($i=0; $i < $ItemCount; ++$i) {
  $SubtotalAmount=$ItemList[$i]["quantity"] * ($ItemList[$i]["price"]);
  $UnitPrice = number_format($ItemList[$i]["price"], 2, '.', ',');
  $ItemPrice = number_format($SubtotalAmount, 2, '.', ',');
  $TotalItems += $ItemList[$i]["quantity"];
  $TotalAmount += $SubtotalAmount;

  echo "<tr style='background-color:$bgcolor'><td align='center'>" .
    $ItemList[$i]["quantity"] . "<input type='hidden' name='quantity[$i]' value='" .
    $ItemList[$i]["quantity"] . "'></td>"; 
  
  if ($ShowForm) {
    echo "<td>";

// sets up buttons for adding and deleting a product

    if ($ItemList[$i]["quantity"] > 0) {
      echo "<input style='width:20px;' type='submit' name='SubtractItem[$i]' value='-'><br>"; // show - button for reducing quantity
    }
    echo "<input style='width:20px;' type='submit' name='AddItem[$i]' value='+'></td>"; // show + button for adding quantity
  }

// show product image, name and description

  echo "<td><b>" . "<a href='" . $ItemList[$i]["img"] . "'><img src='" .
    $ItemList[$i]["img"] . "' width='100px' height='100px'></a> " .
    $ItemList[$i]["name"] . "</b>: " .
    $ItemList[$i]["description"] . 
    "</td><td align='center'> " . $ItemList[$i]["price"] .
    " </td><td align='center'> " . $ItemPrice . "</td></tr>\n";

// Alternate row colors between silver and light grey

    if ($bgcolor == "Silver")
      $bgcolor = "LightGrey";
    else
      $bgcolor = "Silver";
}

// Show total quantity for products selected so far

  if ($TotalItems>0) {
    $TotalPrice = number_format($TotalAmount, 2, '.', ',');
    echo "<br><tr><td colspan='2' align='left' ><strong>Total Qty " .
      $TotalItems . "</strong></td>";
      echo "<td ";

// Show total price for products and quantities selected so far

      if ($ShowForm) {
        echo "colspan='2' ";
      }
      echo "align='right'><strong>Total Price =&gt;</strong>" .
        "</td><td align='center'><strong>$" . $TotalPrice . "</strong></td></tr>\n";
      }
    echo "</table>\n";
    echo "<br>";

// Finish building form with submit button

if ($ShowForm) {
  if ($TotalItems>0) {
    echo "<input type='submit' name='purchase' value='Place Order' /><br>";
  }
  echo "</form>";
}

// Once current order is submitted display link for placing another order

if ($ShowLink) {
  echo "<p><h4><a href='products.php'>Place another order</a></h4></p>";
}
echo "</div>";
?>
<?php include 'footer.php';?>
</body>
</html>




  

