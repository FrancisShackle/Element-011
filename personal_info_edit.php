<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  
<center> <h1 style="color:black" >Add User</h1>
  <br>

<!-- creates form to enter new locaiton info -->
<form action="/personal_info_edit.php" method="post">
  <label>Employee ID</label>
  <input type="text" name="employeeid" >    
  <br><br>
  <label>Employee Name</label>
  <input type="text" name="employeename" >
  <br><br>
  <label>Email</label>
  <input type="text" name="email" >
  <br><br>
  <label>Wage</label>
  <input type="text" name="wage">
  <br><br>
  <label>Join Date</label>
  <input type="date" name="date">
  <br><br>
  <label>Location ID</label>
  <input type="text" name="locationid">
  <br><br>
  <input type="submit" name="submit">
</form>

<?php

$link = mysqli_connect("127.0.0.1", "phpmyadmin", "phpmyadmin","Database");
  if($link === false){
    echo "<p><a href='home.php'>Back to Home</a> </p>";
    exit("Could not connect ".mysqli_connect_error());
  }

//check if the employee ID already exists 
$sql = "SELECT EmployeeID FROM PersonalInfo WHERE EmployeeID = ". mysqli_real_escape_string($link,$_POST["employeeid"]); 
$result = mysqli_query($link, $sql);  
  
  if(isset($_POST['submit'])){
    if (mysqli_num_rows($result) === 0){
      //inserts new employee into database if employee ID doesn't exist
      $sqlInsert = "INSERT INTO PersonalInfo VALUES ('{$_POST["employeeid"]}', '{$_POST["employeename"]}', '{$_POST["email"]}', '{$_POST["wage"]}', '{$_POST["date"]}',
      '{$_POST["locationid"]}')";
      mysqli_query($link, $sqlInsert);
    }
    else{
      echo "Employee ID already exists";
    }
  
  }


?>
<br>
<p><a href='personal_info.php'>Back to PI database</a></p>
</body>
</html>