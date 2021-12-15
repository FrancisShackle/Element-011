<?php
//starts session, session is used to carry variables across a user's session
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!--sets character set to unicode 8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!--defines the area where content is displayed -->
    <title>Home</title>
</head>
<body>

  <center> <h1 style="color:black" >Employees and Location</h1>
  
  <br>

  <p><a href="login.php">Log In</a> </p>
  <p><a href="signup.php">Sign Up</a> </p>
  
<?php  

//links to pages
if (isset($_SESSION["loginstatus"])){ //checks if loginstatus has a value
  echo "<p><a href='personal_info.php'>Show Employee Information</a> </p>";
  echo "<p><a href='location_info.php' >Show Location Information</a> </p>";
  echo "<p><a href='logout.php'>Log Out</a> </p>";
}

//shows unlinked when not logged in
else{ 
    echo "<p>Show Employee Information</p>";
    echo "<p>Show Location Information</p>";
    echo "<br><br><br>";
    
  }
?>
  

  
</body>
</html>