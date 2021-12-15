<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    
<center> <h1 style="color:black" >Edit Table</h1>

<!-- creates form to enter new locaiton info -->
<form action="/location_info_edit.php" method="post">
  <label>Location ID</label>
  <input type="text" name="locationid" >    
  <br><br>
  <label>Location Name</label>
  <input type="text" name="locationname" >
  <br><br>
  <label>Location Type</label>
  <input type="text" name="locationtype" >
  <br><br>
  <label>Capacity</label>
  <input type="text" name="capacity">
  <br><br>
  <label>Open House (HH:MM-HH:MM)</label>
  <input type="text" name="openhours">
  <br><br>
  <input type="submit" name="submit">
</form>

<?php

$link = mysqli_connect("127.0.0.1", "phpmyadmin", "phpmyadmin","Database");
  if($link === false){
    echo "<p><a href='home.php'>Back to Home</a> </p>";
    exit("Could not connect ".mysqli_connect_error());
  }

//check if the location ID already exists 
$sql = "SELECT LocationID FROM Location WHERE LocationID = ". mysqli_real_escape_string($link,$_POST["locationid"]); 
$result = mysqli_query($link, $sql);  
  

  if(isset($_POST['submit'])){
    if (mysqli_num_rows($result) === 0){
      //inserts new location into database if location ID doesn't exist
      $sqlInsert = "INSERT INTO Location VALUES ('{$_POST["locationid"]}', '{$_POST["locationname"]}', '{$_POST["locationtype"]}', '{$_POST["capacity"]}', '{$_POST["openhours"]}')";
      mysqli_query($link, $sqlInsert);
    }
    else{
      echo "Location ID already exists";
    }
  
  }


?>
<br>
<p><a href='location_info.php'>Back to LI database</a></p>

</body>
</html>