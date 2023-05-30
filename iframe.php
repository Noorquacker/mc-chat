<?php
ob_start("ob_gzhandler");

//Security Thing!
if(!strtotime($_GET['date'])) {
	http_response_code(403);
	exit;
}
//Why the frick can't I just put html in an iframe and be done with it? I gotta have it in a separate file?


//list of plugins that output messages that you want to hide
//messages must contain [pluginname] to be suppresed
//like putting dynmap will suppress lines with [dynmap]
$plugins = array('dynmap', 'Vault', 'Multiverse-Core', 'LockettePro', 'Multiverse-SignPortals', 'LogBlock', 'PerWorldInventory', 'Multiverse-Portals', 'EssentialsSpawn', 'Multiverse-NetherPortals', 'DrugsXL', 'Essentials', 'ProtocolLib', 'CleanroomGenerator', 'DropSpawner', 'FastAsyncWorldEdit', 'PermissionsEx', 'ConsoleChat', 'WorldEditSUI', 'ajParkour', 'WorldEdit', 'EssentialsChat', 'EssentialsSpawn', 'EssentialsAntiBuild', 'EssentialsSpawn', 'EssentialsGeoIP', 'floodgate-bukkit', 'Minecraft\.BlocksHub', 'LuckPerms', 'BlocksHub', 'CompassTracking');

$antiplugin = '';
foreach($plugins as &$plugin) {
	$antiplugin .= '|\[' . $plugin . '\]';
}

//You know how big my logfile is because I forgot this line?
$log = '';

//grep and sed filter string
//the log gets piped to this command thing in order to make a filter that's turbo fast because it's not in php

//I added '\]$' somewhere and I don't know why, it removes achievements and kills with named weapons
$filter = "egrep 'Server thread/INFO|Async Chat Thread' | ".
"egrep -v '\-\-\-\-\-\-\-\- World Settings For \[|Item Merge Radius: |com\.sk89q\.worldedit\.bukkit\.adapter\.impl|Item Despawn Rate: |Arrow Despawn Rate: |Cactus Growth Modifier: |Cane Growth Modifier: |Melon Growth Modifier: |Mushroom Growth Modifier: |Pumpkin Growth Modifier: |Sapling Growth Modifier: |Wheat Growth Modifier: |NetherWart Growth Modifier: |Mob Spawn Range: |Nerfing mobs spawned from spawners: |View Distance: |Max Entity Collisions: |Custom Map Seeds: |Entity Activation Range: |Max TNT Explosions: |Tile Max Tick Time: |Random Lighting Updates: |Entity Tracking Range: |Hopper Transfer: |Structure Info Saving: |Allow Zombie Pigmen to spawn from portal blocks: |Zombie Aggressive Towards Villager:| Experience Merge Radius: |Preparing start region for level |A Mojang provided command.|Preparing spawn area: |Preparing spawn area for |Starting Minecraft server on |Default game type: |Preparing level \"|\[@: |: All invocations failed: |blocks filled\]|issued server command|\[PvP|\[*Factions*\]|\[Essentials\]|\[DrugsXL\]|Saving chunks for level|\] Loading|\[WorldGuard\]|Beetroot Growth Modifier: |Carrot Growth Modifier: |Potato Growth Modifier: |Vine Growth Modifier: |Cocoa Growth Modifier: |Bamboo Growth Modifier: |SweetBerry Growth Modifier: |ThreadedAnvilChunkStorage |Kelp Growth Modifier: |Preparing start region for dimension " . $antiplugin . "' |" .
"sed -r 's/\[Async Chat Thread - #[0-9]*\/INFO\]: //g'|".
"sed -r 's/\[Server thread\/INFO]: //g'|".
"sed -r 's/\/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}:[0-9]{1,5}/\/X_IP_HIDDEN/g'|".
"sed -r 's/\- IP Address:.\[. [0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/X_IP_HIDDEN/g'|".
"sed -r 's/logged in with entity id.*/logged in with entity id \[X_COORDS_HIDDEN\]/g'|".
"sed -r 's/https:\/\/luckperms.net\/editor\/[0-9A-z]/https:\/\/luckperms.net\/editor\/\[X_ID_HIDDEN\]/g'|".
"sed -r 's/\[User Authenticator #[0-9]*\/INFO\]: //g'";
$urlexp = "sed -r 's/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,4}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/<a href=\"&\">&<\/a>/g'";

chdir('/home/cryotheum/Minecraft/logs');
if($_GET['date'] == date('Y-m-d')) {
	$log .= "[Log from TODAY]\n";
	$log .= shell_exec("cat latest.log |" . $filter . "| aha -b -n |" . $urlexp);
} else {
	for($i = 0; $i < 20; $i++) {
		if(file_exists($_GET["date"]) . "-" . strval($i) . ".log.gz") {
			//pigz shaved response time from 700ms to 300ms. it works for decompression "on my machine"
			$log .= shell_exec("pigz -c -d " . $_GET["date"] . "-" . strval($i) . ".log.gz |" . $filter . "| aha -b -n |" . $urlexp) . "<br>";
		}
		else{
			break;
		}
	}
}

if(strlen($log) > 100000) {
	echo '<h1>Unsafe mode: displaying logs over 100KB</h1>';
	//die();
}

//Header
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!-- This file was created with the aha Ansi HTML Adapter. https://github.com/theZiz/aha -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xml+xhtml; charset=UTF-8" />
<title>Why are you in the iframe?</title>
</head>
<body style="color:white; background-color:black">
<pre>
<!-- Temporarily disabled. Will restore later -->
<?php echo $log; ?>
</pre>
</body>
</html>
<?php ob_end_flush(); ?>
