<!DOCTYPE HTML PUBLIC >
<html>
<head>
<style>
dl {
  display: flex;
  background-color: white;
  flex-direction: column;
  width: 100%;
  max-width: 300px;
  position: relative;
  padding: 20px;
}

dt {
  align-self: flex-start;
  width: 100%;
  font-weight: 700;
  display: block;
  text-align: left;
  font-size: 1.2em;
  font-weight: 700;
  margin-bottom: 20px;
  margin-left: 13px;
}

.text {
  font-weight: 600;
  display: flex;
  align-items: left;
  height: 40px;
  width: 120px;
  background-color: white;
  position: absolute;
  left: 0;
  justify-content: flex-end;
}

.percentage {
  font-size: .8em;
  line-height: 1;
  text-transform: uppercase;
  width: 80%;
  height: 40px;
  margin-left: 20px;
  background: repeating-linear-gradient(
  to right,
  #ddd,
  #ddd 1px,
  #fff 1px,
  #fff 5%
);
  
  &:after {
    content: "";
    display: block;
    background-color: #3d9970;
    width: 50px;
    margin-bottom: 10px;
    height: 90%;
    position: relative;
    top: 50%;
    transform: translateY(-50%);
    transition: background-color .3s ease;
    cursor: pointer;
  }
  &:hover,
  &:focus {
    &:after {
       background-color: #aaa; 
    }
  }
}

@for $i from 1 through 100 {
  .percentage-#{$i} {
    &:after {
      $value: ($i * 1%);
      width: $value;
    }
  }
}

html, body {
  height: 500px;
  font-family: "fira-sans-2",sans-serif;
  color: #333;
  background-color:black
}
.header {
  border: 1px outset blue;
  background-color:lightblue;
  }
.dashboard {
  height:30vh;
  background-color: black;
;
  display: flex;
  align-items:center;
  }
.circle{
  border-radius: 50%;
  width: 15vw;
  height: 15vh;
  background-color: #5F9EA0;
  display:flex;
  align-items:center;
  justify-content: space-around;
  }
.row {
  display: row;
  justify-content: space-around;
  width: 100%
}
.box {
  background-color:lightgrey;
  width = 300px;
  border = 5px lightblue;
  padding: 50px;
  margin: 20px;
}
</style>
</head>
<body> 
<div class = "header">
  <h1 style="font-size:60px;">SMART HOME</h1>
   <h1 align = "right">Making homes safer... </h1></div>

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
<p>Last Updated: time</p>
    <h1 class = 'box' text-align: right>Kucherera Cumming Residence</h1>
<div class = "dashboard">
<?php

$query = mysqli_query($dbconnect, "SELECT * FROM Temp_humidity ORDER BY entry_id DESC LIMIT 1");
$water = mysqli_query($dbconnect, "SELECT * FROM water_level ORDER BY entry_id DESC LIMIT 5")
   or die (mysqli_error($dbconnect));

$row = mysqli_fetch_array($query);
$n = 1;
$b =1;
$water_values = [];
while ($b==1){
  echo
  
          "<div class = 'row no-padding'>
            <div class = 'col'>
              <dl>
                <dt>
                  Latest water levels captured
                </dt>
  <dd class='percentage percentage-11'><span class='text'>water_values[0]</span></dd>
  <dd class='percentage percentage-49'><span class='text'>water_values[1]</span></dd>
  <dd class='percentage percentage-16'><span class='text'>water_values[2]</span></dd>
  <dd class='percentage percentage-5'><span class='text'>water_values[3]</span></dd>
  <dd class='percentage percentage-2'><span class='text'>water_values[4]</span></dd>
</dl></div></div>";
            $b++;
  }
while($n == 1){
    echo 
        
        
          "<div class = 'row no-padding'>
            <div class = 'col'>
              <div class = 'circle'>
                <h1>Temperature:{$row['temp']}°C </h1></div></div></div>
          <div class = 'row no-padding'>
            <div class = 'col'>
                <div class = 'circle' >
                  <h1>Humidity: {$row['humidity']} %</h1></div></div></div>
          <div class = 'row no-padding'>
            <div class = 'col'>
                <div class = 'circle' >
                  <h1>Flammable Gas</h1></div></div></div>";
    $n++;

}
?>
 </div>
 <h1 class = 'box' text-align: right>Cumming Polo Fields
            <h3>____The temp inside is the same as outside you might want to check your thermostat</h3></h1>
 <div class = 'dashboard'>
          <div class = 'row no-padding'>
            <div class = 'col'>
              <div class = 'circle'>
                <h1>Temperature</h1></div></div></div>
          <div class = 'row no-padding'>
            <div class = 'col'>
                <div class = 'circle' >
                  <h1>Humidity</h1></div></div></div>
          <div class = 'row no-padding'>
            <div class = 'col'>
                <div class = 'circle' >
                  <h1>Visibility</h1></div></div></div>
</div>
 
</body>
</html>
