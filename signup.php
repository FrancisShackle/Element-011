

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    
<center> <h1 style="color:black" >Sign Up</h1>
  <br>

<form action="/signup.php" method="post">
  <label>Username</label>
  <input type="text" name="username">    
  <br>
  <br>
  <label>Email Address</label>
  <input type="email" name="email" >
  <br>
  <br>
  <label>Password</label>
  <input type="password" name="password">
  <br>
  <br>
  <input type="submit" name="submit">
</form>

<?php
  $link = mysqli_connect("127.0.0.1", "phpmyadmin", "phpmyadmin","Database");
  if($link === false){
    echo "<p><a href='home.php'>Back to Home</a> </p>";
    exit("Could not connect ".mysqli_connect_error()); 
  }


  //searches db for username
  $sql = "SELECT Username FROM Users WHERE Username = '". mysqli_real_escape_string($link,$_POST["username"])."'";
  $result = mysqli_query($link, $sql);  

  
  if(isset($_POST['submit'])){

    //if username isnt in database, insert used details
    if (mysqli_num_rows($result) === 0){
        $sqlInsert = "INSERT INTO Users VALUES ('{$_POST["username"]}', '{$_POST["password"]}', '{$_POST["email"]}')";
        mysqli_query($link, $sqlInsert);
    }
    else{
      echo "Username is already taken";
    } 
  
  }

  
?>

<p><a href="home.php">Back to Home</a> </p>
</body>
</html>