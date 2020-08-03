<!DOCTYPE HTML PUBLIC >
<html>
<head>
<style>
.header {
  border: 1px outset blue;
  background-color:lightblue;
  text-align:center
  }
.dashboard {
  height:30vh;
  background-color: #008080;
  display: flex;
  align-items:center;
  }
.circle{
  border-radius: 50%;
  width: 15vw;
  height: 15vh;
  background-color: #5F9EA0;
  display:flex;
  align-items: center;
  justify-content: space-around;
  }
.row {
  display: row;
  justify-content: space-around;
  width: 100%
}
</style>
</head>
<body> 
<h1 class = "header">KUCHERERA SMART HOME</h1>

<?php

$hostname = "localhost";
$username = "Tinashe";
$password = "Smarthome";
$db = "mydatabase";

$dbconnect=mysqli_connect($hostname,$username,$password,$db);

if ($dbconnect->connect_error) 
{
  die("Database connection failed: " . $dbconnect->connect_error);
 }

?>


<?php

$query = mysqli_query($dbconnect, "SELECT * FROM Temp_humidity ORDER BY entry_id DESC LIMIT 1")
   or die (mysqli_error($dbconnect));
$row = mysqli_fetch_array($query);
$n = 1;
echo "<p>Last Updated: {$row['date_time']}</p>";
while($n == 1){
    echo 
        
        "<div class = 'dashboard'>
          <div class = 'row no-padding'>
            <div class = 'col'>
              <div class = 'circle'>
                <h1>Temperature: {$row['temp']} °C </h1></div></div></div>
          <div class = 'row no-padding'>
            <div class = 'col'>
                <div class = 'circle' >
                  <h1>Humidity: {$row['humidity']} %</h1></div></div></div>";
    $n++;

}
?>
 </div>
</body>
</html>
