<?php
	include('includes/db.php');
	include_once('includes/steamLogin.php');
	$steam = new steamClass();

	$steamNi = $db->query("SELECT * FROM users_socialmedia WHERE user_id = '19'");
	$steamNa = $steamNi->fetch_assoc();
	$steamId = $steamNa['steam_id'];
	$file 	 = json_decode(file_get_contents("includes/cache/SteamSummaries/SteamLibrary/{$steamId}.json"));
	$i 		 = 0;

	if (isset($_GET['game'])) {
		$app = $_GET['game'];
		$JSONapp = json_decode(file_get_contents('http://api.steampowered.com/ISteamNews/GetNewsForApp/v0002/?appid={$app}&count=3&maxlength=300&format=json'));
		
	}


	while ($i <= $file->response->game_count -1) {
			$test = $file->response->games[$i]->appid;
			
			echo "<a href=\"?game=$test\">$test </a>: ";
			if (empty($file->response->games[$i]->playtime_forever)) {
				echo " no";
			}
			else{
				echo $file->response->games[$i]->playtime_forever;
			}
			echo "; <br>";
			$i++;
	}


	
?>
