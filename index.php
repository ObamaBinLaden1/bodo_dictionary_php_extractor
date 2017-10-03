<?php
require __DIR__.'/vendor/autoload.php';
use Kreait\Firebase;

$firebase = (new Firebase\Factory())
		->withCredentials(__DIR__.'/thebodo-2b322-firebase-adminsdk-3drfz-1c7f880e75.json')
		->withDatabaseUri('https://thebodo-2b322.firebaseio.com/')
		->create();
$database = $firebase->getDatabase();
$reference = $database->getReference('dictionary');


$con=mysqli_init();

if (!$con)
  {
  die("mysqli_init failed");
  }

if (!mysqli_real_connect($con,"localhost","root","","the_bodo"))
  {
  die("Connect Error: " . mysqli_connect_error());
  }
echo PHP_EOL.'mysqli connected'.PHP_EOL;

mysqli_set_charset($con,"utf8");

$total = 176023;
$query = "SELECT * from dictionary LIMIT 170000,6023";
$result=mysqli_query($con,$query);
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
$updates = [];
while ($row=mysqli_fetch_assoc($result)) {
	$data = [
		'word' => $row['word'],
		'wordtype' => $row['wordtype'],
		'wordtype' => $row['wordtype'],
		'eng_definition' => $row['definition'],
		'bodo_definition' => $row['bodo_definition'].''
	];
   echo('<p/>'.$row['id'].'. '.$row['word'].' => '.$row['definition'].'</p>');
   // $reference->push($data);
   $updates['dictionary/'.$row['id']] = $data;
}
$database->getReference() // this is the root reference
   ->update($updates);
?>
</body>
</html>

<?php
mysqli_free_result($result);
mysqli_close($con);

// /thebodo-2b322-firebase-adminsdk-3drfz-1c7f880e75
?>