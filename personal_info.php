<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Info</title>
</head>
<body>

  <center> <h1 style="color:black" >Employees</h1>
  <br>

  <p><a href="personal_info_edit.php">Add Employee</a> </p>

<?php
  $link = mysqli_connect("127.0.0.1", "phpmyadmin", "phpmyadmin","Database");

   
  if($link === false){
    echo "<p><a href='home.php'>Back to Home</a> </p>";
    exit("Could not connect ".mysqli_connect_error()); 
  }
  
  //inputs for querying database
  echo"<form action='/personal_info.php' method='post'>";
  echo"<label>Search</label>";
  echo"<input type='search' name='search' >";
  echo"<br>";
  echo"<br>";
  echo"<input type='submit' name='searchsubmit' value='Search'>";
  echo"<input type='submit' name='reset' value='Reset'";//resets table shown
  echo"<br>";
  echo"<br>";
  echo"</form>";

  $searchquery = mysqli_real_escape_string($link,$_POST["search"]);
  
  //statement for querying database
  $sqlsearch = "SELECT * FROM PersonalInfo WHERE EmployeeID LIKE '%$searchquery%'
                OR EmployeeName LIKE '%$searchquery%'
                OR Email LIKE '%$searchquery%'
                OR Wage LIKE '%$searchquery%'
                OR JoinDate LIKE '%$searchquery%'
                OR LocationID LIKE '%$searchquery%'";




  

  echo "<form action='/personal_info.php' method='post'>";
  echo "<table border='1'> 
  <tr>
  <th>  &emsp;&emsp;&emsp;&emsp;Employee ID&emsp;&emsp;&emsp;  </th>
  <th>  &emsp;&emsp;&emsp;&emsp;Name&emsp;&emsp;&emsp;&emsp;  </th>
  <th>  &emsp;&emsp;&emsp;&emsp;Email&emsp;&emsp;&emsp;&emsp;   </th>
  <th>  &emsp;&emsp;&emsp;&emsp;Wage p/H&emsp;&emsp;&emsp;&emsp;   </th>
  <th>  &emsp;&emsp;&emsp;&emsp;Join Date&emsp;&emsp;&emsp;&emsp;   </th>
  <th>  &emsp;&emsp;&emsp;&emsp;Location ID&emsp;&emsp;&emsp;&emsp;   </th>";

  //if search button pressed, change result to query database with the search term
  if (isset($_POST['search'])){
    $result = mysqli_query($link, $sqlsearch);
  }
  else{
    //statement for retrieving all info from relevant table
    $sql = "SELECT * FROM PersonalInfo";
    $result = mysqli_query($link, $sql);
  }

  //fills table with results from sql query
  while($row = mysqli_fetch_array($result))
  {
    echo "<tr>";
    echo "<td><center>" .$row['EmployeeID'] . "</center></td>";
    echo "<td><center>" .$row['EmployeeName'] . "</center></td>";
    echo "<td><center>" .$row['Email'] . "</center></td>";
    echo "<td><center>" .$row['Wage'] . "</center></td>";
    echo "<td><center>" .$row['JoinDate'] . "</center></td>";
    echo "<td><center>" .$row['LocationID'] . "</center></td>";

    //adds delete and edit buttons to table, assigning them the value of location ID
    echo "<td><button type='submit' name='delete' value='".$row['EmployeeID']."'>Delete</button></td>";
    echo "<td><button type='submit' name='edit' value='".$row['EmployeeID']."'>Edit</button></td>";
    echo "</tr>";
  }




  echo "</table>";
echo "</form>";

//if delete button pressed, removes selected row
if(isset($_POST['delete'])){
  $sql = "DELETE FROM PersonalInfo WHERE EmployeeID = ".$_POST['delete'];
  $result = mysqli_query($link, $sql);
  echo "<meta http-equiv='refresh' content='0'>";
}

//if edit button pressed, display inputs to edit
if (isset($_POST['edit'])){
  //displaying employee data
  $sql = "SELECT * FROM PersonalInfo WHERE EmployeeID = ". mysqli_real_escape_string($link,$_POST["edit"]);
  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_array($result);

  //listing the locations
  $getlocation = "SELECT LocationID, Name FROM Location";
  $locationres = mysqli_query($link, $getlocation);
  
  //fills input boxes with existing data to change
  
  echo "<br>";
  echo "<form action='/personal_info.php' method='post'>";
  echo "<label>Employee ID</label>";
  echo "<input type='hidden' name='employeeid' value='".$row['EmployeeID']."'>";
  echo "<br><br>";
  echo "<label>Employee Name</label>";
  echo "<input type='text' name='employeename' value='".$row['EmployeeName']."'>";
  echo "<br><br>";
  echo "<label>Email</label>";
  echo "<input type='text' name='email' value='".$row['Email']."'>";
  echo "<br><br>";
  echo "<label>Wage</label>";
  echo "<input type='text' name='wage' value='".$row['Wage']."'>";
  echo "<br><br>";
  echo "<label>Join Date</label>";
  echo "<input type='date' name='date' value='".$row['JoinDate']."'>";
  echo "<br><br>";
  echo "<label>Location</label>";

  echo "<select name='locationid'>";
    //creates a drop menu to choose available locations
    while ($drop = mysqli_fetch_array($locationres)){
    echo "<option value=".$drop['LocationID'].">".$drop['Name']."</option>";
    }
  echo "</select>";
  echo "<br><br>";
  echo "<input type='submit' name='submitnew'>";
  echo "</form>";
  
}

//updates table from new user inputs
if (isset($_POST['submitnew'])){
  $sqlInsert = "UPDATE PersonalInfo SET EmployeeName = '{$_POST["employeename"]}', Email = '{$_POST["email"]}',
  Wage = '{$_POST["wage"]}', JoinDate = '{$_POST["date"]}', LocationID = '{$_POST["locationid"]}' WHERE EmployeeID = ". mysqli_real_escape_string($link,$_POST["employeeid"]);
  mysqli_query($link, $sqlInsert);
  echo "<meta http-equiv='refresh' content='0'>"; //refresh to display new data
}


?>
<br><br>
<p><a href="home.php">Back to Home</a> </p>

</body>
</html>