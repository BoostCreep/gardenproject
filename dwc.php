<?php
// Settings
// host, user and password settings
$host = "localhost";
$user = "temp_user1";
$password = "pwd_user1";
$database = "temperatures";

//how many hours backwards do you want results to be shown in web page.
$hours = 24;

// make connection to database
$connectdb = mysqli_connect($host,$user,$password)
or die ("Cannot reach database");

// select db
mysqli_select_db($connectdb,$database)
or die ("Cannot select database");

// sql command that selects all entires from current time and X hours backwards
$sql="SELECT * FROM temperaturedata WHERE dateandtime >= (NOW() - INTERVAL $hours HOUR) order by dateandtime desc";

//NOTE: If you want to show all entries from current date in web page uncomment line below by removing //
//$sql="select * from temperaturedata where date(dateandtime) = curdate();";

// set query to variable
$temperatures = mysqli_query($connectdb,$sql);

// create content to web page
?>
<html>
<head>
<title>Gibbs Garden</title>
</head>

<body>
</body>
<center><b>The Gibbs Garden</b></center>
<table width="800" border="1" cellpadding="1" cellspacing="1" align="center">
<tr>
<th>Date</th>
<th>Sensor</th>
<th>Temperature</th>
<th>Humidity</th>
<tr>
<?php
// loop all the results that were read from database and "draw" to web page
while($temperature=mysqli_fetch_assoc($temperatures)){
echo "<tr>";
echo "<td>".$temperature['dateandtime']."</td>";
echo "<td>".$temperature['sensor']."</td>";
echo "<td>".$temperature['temperature']."</td>";
echo "<td>".$temperature['humidity']."</td>";
echo "<tr>";
}
?>
</table>
<br>


</br>
<center><b>Deep Water Culture Bucket </b></center>
<center>
<body>

<?php
echo "<table style='border: solid 1px black;'>";
 echo "<tr><th>Date</th><th>Time</th><th>Temperature</th></tr>";

class TableRows extends RecursiveIteratorIterator { 
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }

    function current() {
        return "<td style='width: 150px; border: 1px solid black;'>" . parent::current(). "</td>";
    }

    function beginChildren() { 
        echo "<tr>"; 
    } 

    function endChildren() { 
        echo "</tr>" . "\n";
    } 
} 

$servername = "localhost";
$username = "temp_user1";
$password = "pwd_user1";
$dbname = "temperatures";
$hours = "24";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT date, time, ROUND(value*1.8+32,2) FROM temp_log WHERE date >=(NOW() - INTERVAL $hours HOUR) ORDER BY date desc,time desc");
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 

    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
        echo $v;
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
?> 

</body>
</center>
</html>
