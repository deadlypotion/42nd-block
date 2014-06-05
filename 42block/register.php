<?php
	
	function registerCheck1($username,$password,$password_a,$email,$gender,$date){
		
		// if's from here
		
		if($username == '' || $password == '' || $password_a == '' || $email == ''){
			echo '5';
		}
		elseif($password != $password_a){
			echo '7';
		}
		else{
			//check database query
			include('includes/db.php');
			include_once('includes/formCheck.php');
			$filter = new registerCheck;
			$check = $filter->registerDbCheck($email,$username,$db);
			
			if($check == 0.0){
				echo '8';
			}
			elseif($check == 0.1){
				echo '9';
			}
			elseif($check == 0.2){
				echo '10';
			}
			else{
				$insert = new registerInsertInto;
				$insert->insertInto($username,$password,$email,$date,$gender,$db);
				echo 'yes';
			}
		}
	}
	
	function registerCheck2(){
		if(isset($_POST['submit'])){
			$username = $_POST['username'];
			$password = $_POST['pwrdR'];
			$password_a = $_POST['pwrdA'];
			$email = $_POST['email'];
			
			if(isset($_POST['gender'])){
				$gender = $_POST['gender'];
			}
			else{
				$gender = '';
			}
			
			$date = $_POST['date'];
			registerCheck1($username,$password,$password_a,$email,$gender,$date);
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/forms.css">
	<link rel="stylesheet" type="text/css" href="css/import.css">
	<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.10.3.custom.min.css">
	<script src="js/jquery-2.0.3.min.js"></script>
	<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
	
</head>
<body>
<!-- recaptcha theme-->
<script type="text/javascript">
		var RecaptchaOptions = {
		theme : 'clean'
		};
</script>

	<div id="mainRegisterForm">
		<h1 style="border-bottom:5px solid rgba(255,255,255,0.7)">Register Form</h1>
		<h2>if you have an account, and you wish to sign in, please enter your details in the boxes below.</h2>
		<!--From goes HERE-->
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>" id="registerForm">
			<label>Username:</label>
			<input type="text" name="username" id="username" class="registerInput input" /><br>
			<label>Password:</label>
			<input type="password" name="pwrdR" id="pwrdR" class="registerInput input" /><br>
			<label>Re-Enter Password:</label>
			<input type="password" name="pwrdA" id="pwrdA" class="registerInput input" /><br>
			<label>E-mail:</label>
			<input type="email" name="email" id="email" class="registerInput input" /><br>
			<label style="position:relative;left:00px;">male:</label>
			<input type="radio" name="gender" id="gender" class="registerInput radioInput" value="1" />
			<label style="position:relative;left:200px;">female:</label>
			<input type="radio" name="gender" id="gender" class="registerInput radioInput" value="2" style="position:relative;left:300px;" /><br>
			<label>date of burn:</label>
			<input type="text" name="date" id="date" class="registerInput input" /><br>
			
			<!-- reCaptcha -->
			
			<script type="text/javascript"
				 src="http://www.google.com/recaptcha/api/challenge?k=6LeR6eISAAAAACu8yuukeFMiQGV7BGMSjW-uuW90">
			</script>
			  <noscript>
				 <iframe src="http://www.google.com/recaptcha/api/noscript?k=6LeR6eISAAAAACu8yuukeFMiQGV7BGMSjW-uuW90"
					 height="300" width="500" frameborder="0"></iframe><br>
				 <textarea name="recaptcha_challenge_field" rows="3" cols="40">
				 </textarea>
				 <input type="hidden" name="recaptcha_response_field"
					 value="manual_challenge">
			  </noscript>
			
			<input type="submit" name="submit" id="submit" value="submit">
			<input type="reset" name="reset" id="submit" value="reset">
			<br>
		</form>
	</div>
	<div id="error" style="margin-bottom:50px;"><?php	registerCheck2(); ?></div>
	<div style="margin-bottom:50px;background:blue;height:10px;position:absolute;"></div>
<!--scripting-->
<script src="js/formsCheck.js"></script>
<script>
$(document).ready(function(){
	$('#date').datepicker();
});

</script>
</body>
</html>