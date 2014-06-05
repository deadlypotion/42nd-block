<?php
	session_start();

	$err = '';
	include('/includes/db.php');
    

	if(isset($_SESSION['username'])){
		header('Loaction: includes/logout.php');
	}
	
	function errCount(){
		if(isset($_SESSION['errCount'])){
			$count = $_SESSION['errCount'];
			$_SESSION['errCount'] = $count + 1;
		}
		else{
			$_SESSION['errCount'] = 1;
		}
	}
	//---
	
	function loginCheck1($username,$password){
		if($username == '' || $password == ''){
		
			errCount();
			echo '1';
		}
		else{
			$check2 = loginCheck2($username,$password);
			
			if($check2 == 0.0){
				$err = 'This username is not found in the system. please come back and try again.';
				errCount();
				echo '2';
			}
			elseif($check2 == 0.1){
				$err = 'the password you entered not validate to this user. please make sure the caps-lock button is not on.';
				errCount();
				echo '3';
			}
			elseif ($check2 == 0.2) {
				errCount();
				echo '11';
			}
			elseif ($check2 == 0.21) {
				errCount();
				echo '12';
			}
			elseif ($check2 == 0.3) {
				errCount();
				echo '13';
			}
			else{
                $ip = $_SERVER['REMOTE_ADDR'] = '::1' ? '127.0.0.1' : $_SERVER['REMOTE_ADDR'];
				$_SESSION['username'] = $username;
				$_SESSION['errCount'] = 0;
				include('/includes/db.php');
				$db->query("UPDATE users SET connected = '1' WHERE username = '$username'");
                $db->query("INSERT INTO ip_connections (ip_address,username) VALUES ('$ip','$username')");
				echo '4';
			}
		}
		
		
	}
	function loginCheck2($username,$password){
		include('/includes/db.php');
		include_once('/includes/formCheck.php');
		$filter = new loginCheck;
		//----
		
		$check = $filter -> loginDbCheck($username,$password,$db);
		return $check;
	}
	function loginCheck3(){
		if(isset($_POST['submit'])){
			$username = $_POST['username'];
			$password = $_POST['pwrdL'];
			//------
			
			loginCheck1($username,$password);
			
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>login script</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/forms.css">
	<link rel="stylesheet" type="text/css" href="css/import.css">
	<script src="js/jquery-2.0.3.min.js"></script>
	
</head>
<body>
	<div id="mainLoginForm">
		<h1 style="border-bottom:5px solid rgba(255,255,255,0.7)">Login Form</h1>
		<h2>if you have an account, and you wish to sign in, please enter your details in the boxes below.</h2>
		<!--From goes HERE-->
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>" id="loginForm">
			<label>Username:</label>
			<input type="text" name="username" id="username" class="loginInput input" value="<?php ?>" /><br>
			<label>Password:</label>
			<input type="password" name="pwrdL" id="pwrdL" class="loginInput input" /><br>
			<label>Remember me?</label>
			<input type="hidden" name="hidden" id="hidden" value=""/>
			<input type="checkBox" name="rememberMe" value="1" class="rememberMe" />
			<input type="submit" name="submit" id="submit" value="submit">
			
		</form>
	</div>
	<div id="error"><?php loginCheck3(); 
		if (isset($_GET['steam'])) {
			echo "steam-ftw";
		}
	?></div>
<!--scripting-->
<script src="js/formsCheck.js"></script>

</body>
</html>