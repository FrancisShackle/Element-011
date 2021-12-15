<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href = "stylesheet.css">
    <title>Location Info</title>
</head>
<body>

  <center> <h1 style="color:black" >Location</h1>
  <br>

  <!-- links to add location page -->
  <p><a href="location_info_edit.php">Add Location</a> </p>

<?php
  $link = mysqli_connect("127.0.0.1", "phpmyadmin", "phpmyadmin","Database"); 

  
  if($link === false){
    echo "<p><a href='home.php'>Back to Home</a> </p>";
    exit("Could not connect ".mysqli_connect_error()); 
  }
  
  //inputs for querying database
  echo"<form action='/location_info.php' method='post'>";
  echo"<label>Search</label>";
  echo"<input type='search' name='search' >";
  echo"<br>";
  echo"<br>";
  echo"<input type='submit' name='submit' value='Search'>";
  echo"<input type='submit' name='reset' value='Reset'"; //resets table shown
  echo"<br>";
  echo"<br>";
  echo"</form>";

  $searchquery = $_POST["search"];
  
  //statement for querying database
  $sqlsearch = "SELECT * FROM Location WHERE LocationID LIKE '%$searchquery%'
                OR Name LIKE '%$searchquery%'
                OR LocationType LIKE '%$searchquery%'
                OR PersonCapacity LIKE '%$searchquery%'
                OR OpenHours LIKE '%$searchquery%'";


  


  //creates table 
  echo "<form action='/location_info.php' method='post'>";
  echo "<table border = '1'> 
  <tr>
  <th>  &emsp;&emsp;&emsp;&emsp;Location ID&emsp;&emsp;&emsp;&emsp;  </th>
  <th>  &emsp;&emsp;&emsp;&emsp;Location&emsp;&emsp;&emsp;&emsp;  </th>
  <th>  &emsp;&emsp;&emsp;&emsp;Location Type&emsp;&emsp;&emsp;&emsp;  </th>
  <th>  &emsp;&emsp;&emsp;&emsp;Capacity&emsp;&emsp;&emsp;&emsp;   </th>
  <th>  &emsp;&emsp;&emsp;&emsp;Open Hours&emsp;&emsp;&emsp;&emsp;   </th>";

  //if search button pressed, change result to query database with the search term
  if (isset($_POST['submit'])){
    $result = mysqli_query($link, $sqlsearch);
  }
  else{
    //statement for retrieving all info from relevant table
    $sql = "SELECT * FROM Location";
    $result = mysqli_query($link, $sql);
  }

  //fills table with results from sql query
  while($row = mysqli_fetch_array($result))
  {
    echo "<tr>";
    echo "<td><center>" .$row['LocationID'] . "</center></td>";
    echo "<td><center>" .$row['Name'] . "</center></td>";
    echo "<td><center>" .$row['LocationType'] . "</center></td>";
    echo "<td><center>" .$row['PersonCapacity'] . "</center></td>";
    echo "<td><center>" .$row['OpenHours'] . "</center></td>";

    //adds delete and edit buttons to table, assigning them the value of location ID
    echo "<td><button type='submit' name='delete' value='".$row['LocationID']."'>Delete</button></td>";
    echo "<td><button type='submit' name='edit' value='".$row['LocationID']."'>Edit</button></td>";
    echo "</tr>";
  }

  echo "</table>";
  echo "</form>";

//if delete button pressed, removes selected row
if (isset($_POST['delete'])){
  //checks if employees have the same location ID
  $employee = "SELECT * FROM PersonalInfo WHERE LocationID = ".$_POST['delete'];
  $employeeresult = mysqli_query($link, $employee);
  //if no employees have location ID, delete
  if (mysqli_num_rows($employeeresult) === 0){
    $sql = "DELETE FROM Location WHERE LocationID = ".$_POST['delete'];
    $result = mysqli_query($link, $sql);
    echo "<meta http-equiv='refresh' content='0'>";
  }
  else{
    echo "You can't delete location because employees are still assigned to it";
  }
}

//if edit button pressed, display inputs to edit
if (isset($_POST['edit'])){
  $sql = "SELECT * FROM Location WHERE LocationID = ". mysqli_real_escape_string($link,$_POST["edit"]);
  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_array($result); 
  echo $row['LocationType'];
  //fills input boxes with existing data to change

  echo "<br>";
  echo "<form action='/location_info.php' method='post'>";
  echo "<label>Location ID</label>";
  echo "<input type='hidden' name='locationid' value='".$row['LocationID']."'>";
  echo "<br><br>";
  echo "<label>Location Name</label>";
  echo "<input type='text' name='locationname' value='".$row['Name']."'>";
  echo "<br><br>";
  echo "<label>Location Type</label>";
  echo "<input type='text' name='locationtype' value='".$row['LocationType']."'>";
  echo "<br><br>";
  echo "<label>Capacity</label>";
  echo "<input type='text' name='personcapacity' value='".$row['PersonCapacity']."'>";
  echo "<br><br>";
  echo "<label>Open Hours (HH:MM-HH:MM)</label>";
  echo "<input type='text' name='openhours' value='".$row['OpenHours']."'>";
  echo "<br><br>";
  echo "<input type='submit' name='submitnew'>";
  echo "</form>";
}

//updates table from new user inputs
if (isset($_POST['submitnew'])){
  $sqlInsert = "UPDATE Location SET Name = '{$_POST["locationname"]}', LocationType = '{$_POST["locationtype"]}',
  PersonCapacity = '{$_POST["personcapacity"]}', OpenHours = '{$_POST["openhours"]}' WHERE LocationID = ". mysqli_real_escape_string($link,$_POST["locationid"]);
  mysqli_query($link, $sqlInsert);
  echo "<meta http-equiv='refresh' content='0'>";//refresh to display new data
}


?>
<p><a href="home.php">Back to Home</a> </p>

</body>
</html>