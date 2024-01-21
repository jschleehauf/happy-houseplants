<!DOCTYPE html>
<html>
  <!-- Midterm Project - Jarratt Schleehauf - 10/08/23 -->
  <head>
    <title>Happy Houseplants Online Store</title>
    <link href="script.css" rel="stylesheet">
  </head>
  <body>
    <?php include 'header.php';?>
    <?php include 'navbar.php';?>

    <h1>Contact Form</h1>

  <!-- Contact Form tailored to Happy Houseplants -->
  <form id="contactForm" name="contactForm" method="post" action="processform.php">
    <!-- text input -->
    <p><label for="myName">Name</label> <br />
    <input type="text" id="myName" name="myName" size="40" maxlength="50" /></p>
    <p><label for="myEmail">Email</label> <br />
    <input type="text" id="myEmail" name="myEmail" size="40" maxlength="50" /></p> 
    <p><label for="myCell">Cell Phone</label> <br />
    <input type="text" id="myCell" name="myCell" size="40" maxlength="50" /></p> 
    <p><label for="myHome">Home Phone</label> <br />
    <input type="text" id="myHome" name="myHome" size="40" maxlength="50" /></p>

    <!-- text area -->
    <p>
    <label for="comments">Enter your question below</label> <br />
    <textarea id="comments" name="comments" cols="40" rows="8"></textarea>
    </p>

    <!-- radio buttons - only check one circle -->
    <fieldset name="subscribe" id="subscribe" value="caption">
      <p>
      <legend name="mylegend" id="mylegend">Subscribe to our Newsletter?</legend>
        <input type="radio" id="yes" name="myradio" value="Yes"/> <label for="yes">Yes</label>
        <input type="radio" id="no" name="myradio" value="No"/> <label for ="no">No</label>
      </p>
    </fieldset>

    <!-- select dropdown list -->
    <p><label  for="myselect">Client Dropdown Selection:</label> <br>
    <select id="myselect" name="myselect">
      <option value="" selected="selected"> </option>
      <option value="Business">Business</option>
      <option value="Individual">Individual</option>
      <option value="Other">Other</option> 
    </select>
    </p>

    <!-- select dropdown list(search engine, online ad, word-of-mouth, other). -->
    <p><label  for="myselect2">How did you hear about us?</label> <br>
    <select id="myselect2" name="myselect2">
      <option value="" selected="selected"> </option>
      <option value="Search Engine">Search Engine</option>
      <option value="Online Advertisement">Online Advertisement</option>
      <option value="Word of Mouth">Word of Mouth</option>
      <option value="Other">Other</option> 
    </select>
    </p>

    <!-- Submit buttons -->
    <p>
      <input type="submit" id="OK" name="OK" value="Submit" default="yes" onclick="return checkForm('myform');" />
    </p>

  </form>
  <?php include 'footer.php';?>
  </body>
</html>