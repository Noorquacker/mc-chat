<!DOCTYPE html>
<html>
<head>
	<title>Chat Logs | Noorquacker Ind.</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/calendar.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
	<div class="jumbotron text-center">
		<h1>Chat Logs</h1>
<p>The Minecraft Server chat archive of <a>mc.nqind.com</a></p>
		<!--Yes, I use inline PHP, so everything will now look terribly inconsistent with tabs and stuff.
		If you don't like it, then go on a big company's website and see how garbage they are too -->
<?php
//Time to get to work.
include "calendar.php";
if(!key_exists("year",$_GET)) {
	$year = date("Y");
}
else {
	$year = $_GET["year"];
}
$year = intval($year);
if(!key_exists("month",$_GET)) {
	$month = date("n");
}
else {
	$month = $_GET["month"];
}
$month = intval($month);
$logs_f = scandir("/home/cryotheum/Minecraft/logs");
$years = array();
$months = array();
for($i = 1; $i < 13; $i++) {
	$months[$i] = array();
}
foreach($logs_f as $k) {
	$k = trim($k, ".log.gz");
	$k = explode("-", $k);
	if(array_search(intval($k[0]), $years) === false && intval($k[0]) != 0) {
		array_push($years, intval($k[0]));
	}
	//$logs[intval($k[0])][intval($k[1])][intval($k[2])] = intval($k[3]);
	//var_dump($k);
}
?>
		<div class="container">
			<ul class="pagination">
<?php
foreach($years as $i) {
	echo "<li" . (strval($i) == strval($year) ? " class=\"active\"" : "") . "><a href=\"?year=" . strval($i) . "&month=" . strval($month) . "\">" . strval($i) . "</a></li>\n"; //so this is why people want to hang themselves with php
}
$calendar = new Calendar();
?>
			</ul>
		</div>
		<div class="container">
			<?php echo $calendar->show($logs_f); ?>
		</div>
		<footer>Made with Quarantine Boredom by <a href="https://www.nqind.com">Noorquacker Ind.</a></footer>
	</div>
</body>
</html>
