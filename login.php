<?php

session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
</head>
<body>
    
<center> <h1 style="color:black" >Log In</h1>
  <br>

  <!-- form to take user inputs -->
<form action="/login.php" method="post">
  <label>Username</label>
  <input type="text" name="username" >    
  <br>
  <br>
  <label>Password</label>
  <input type="password" name="password" >
  <br>
  <br>
  <input type="submit" name="submit">
</form>

<?php
  //creates connection to database
  $link = mysqli_connect("127.0.0.1", "phpmyadmin", "phpmyadmin","Database");

  //checks connection
  if($link === false){ 
    echo "<p><a href='home.php'>Back to Home</a> </p>";
    exit("Could not connect ".mysqli_connect_error()); 
  }

  //searches database for username
  $sql = "SELECT Username FROM Users WHERE Username = '". mysqli_real_escape_string($link,$_POST["username"])."'";
  
  $result = mysqli_query($link, $sql);  
  

  if(isset($_POST['submit'])){

    //checks amount of rows matching query, if username is in database then rows is going to = 1
    if (mysqli_num_rows($result) > 0){ 
      //if username is in the database, check passwords match
      $sqlpassword = "SELECT Password From Users WHERE Username = '". mysqli_real_escape_string($link,$_POST["username"])."'";
      $result = mysqli_query($link, $sqlpassword);
      $dbpass = mysqli_fetch_array($result);

      if ($dbpass["Password"] === $_POST['password']){
        echo "Log in successful";
        $_SESSION["loginstatus"] = $_POST['username']; 
      }

      else{
        echo "Username and password do not match";
      }  
    }
    else{
        echo "Username does not exist";
    }
  }
?>

<p><a href="home.php">Back to Home</a> </p>
</body>
</html>