<?php
//ah frick
$date = $_GET['date'];

//first of all we should set up actual navigation buttons and stuff
$datenum = strtotime($date);
if(!$datenum){http_response_code(403); exit;} //DONT LET THEM KILL US WITH FILE EXPLOITS

$nextday = date('Y-m-d',strtotime('+1 day', $datenum));
$prevday = date('Y-m-d',strtotime('-1 day', $datenum));

chdir('/home/cryotheum/Minecraft/logs');
if(file_exists($date . '-1.log.gz') || date('Y-m-d') == $date) { ?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $date; ?> Log | Noorquacker Ind.</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/log.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta charset="utf-8" />
	<script>
		function resizeIframe(obj) {
			obj.style.height = (obj.contentWindow.document.documentElement.scrollHeight +10)+ 'px';
		}
	</script>
</head>
<body>
	<h1><?php echo $_GET['date']; ?></h1>
	<h2>Chat Log | <a href="https://www.nqind.com">Noorquacker Ind.</a></h2>
	<p>
		<ul class="pager">
			<li class="previous"><a href="?date=<?php echo $prevday; ?>">Previous</a></li>
			<li><a class="" href="index.php?year=<?php echo date('Y',$datenum).'&month='.date('m',$datenum);?>">Return</a></li>
			<li class="next"><a class="next2" href="?date=<?php echo $nextday; ?>">Next</a></li>
		</ul>
	</p>
	<iframe src="https://mc.nqind.com/chat/iframe.php?date=<?php echo $date; ?>" onload="resizeIframe(this)"></iframe>
	<p>
		<ul class="pager">
			<li class="previous"><a href="?date=<?php echo $prevday; ?>">Previous</a></li>
			<li><a class="" href="index.php?year=<?php echo date('Y',$datenum).'&month='.date('m',$datenum);?>">Return</a></li>
			<li class="next"><a class="next2" href="?date=<?php echo $nextday; ?>">Next</a></li>
		</ul>
	</p>
</html>
<?php
}
else { ?>
<!DOCTYPE html>
<html>
<head>
	<title>Log Not Found | Noorquacker Ind.</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/log.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta charset="utf-8" />
</head>
<body>
	<h1>Log not found.</h1>
	<h2><button class="btn btn-primary" onclick="window.history.back()">Return</button></h2>
</body>
</html>
<?php
} ?>
