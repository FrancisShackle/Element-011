<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<center> <h1 style="color:black" >Log Out</h1>
<br>


<form action="/logout.php" method="post">
<input type="submit" name="submit">
</form>

<?php

//resets sessions and its variables
if(isset($_POST['submit'])){
  session_unset();
}
?>

<p><a href="home.php">Back to Home</a> </p>

</body>
</html>

