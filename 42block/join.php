<?php

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<link rel="stylesheet" type="text/css" href="css/import.css">
		<link rel="stylesheet" type="text/css" href="css/colors.css">
		<link rel="stylesheet" type="text/css" href="css/forms.css">
		<script src="js/jquery-2.0.3.min.js"></script>
        <!--<script>
        var userAgent = navigator.userAgent.toLowerCase();

        // Figure out what browser is being used.
        var Browser = {
            Version: (userAgent.match(/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/) || [])[1],
            Chrome: /chrome/.test(userAgent),
            Safari: /webkit/.test(userAgent),
            Opera: /opera/.test(userAgent),
            IE: /msie/.test(userAgent) && !/opera/.test(userAgent),
            Mozilla: /mozilla/.test(userAgent) && !/(compatible|webkit)/.test(userAgent),
            Check: function() { alert(userAgent); }
        };

        if (Browser.Chrome || Browser.Mozilla) {
            // Do your stuff for Firefox and Chrome.
        }
        else if (Browser.IE) {
            
        }
        else {
            // The browser is Safari, Opera or some other.
        }
        </script>-->
	</head>
	<body>
		<div id="mainBox" style="width:1000px;position:relative;top:100px;">
			<div id="joinPageP1">
				<h1>welcome to the 42nd block</h1>
				<h2>if you already have an account, you can login with the form from your left. otherwise, you can register with the form <a href="register.php">HERE</a>.</h2>
			</div>
			<div id="joinPageP2">
				<form method="post" action="login.php">
					<h1>Login</h1>
					<label>Username:</label>
					<input type="text" name="username" id="username" class="loginInput input" /><br>
					<label>Password:</label>
					<input type="password" name="pwrdL" id="pwrdL" class="loginInput input" /><br>
					<label>Remember me?</label>
					<input type="hidden" name="hidden" id="hidden" value=""/>
					<input type="checkBox" name="rememberMe" value="1" class="rememberMe" />
					<input type="submit" name="submit" id="submit" value="submit">
					
				</form>
			</div>
		</div>
	</body>
</html>