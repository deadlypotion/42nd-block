<?php
/**
*functions goes here
*/


session_start();
    include('includes/db.php');
	include('includes/functions/userPanel.php');
	include('includes/functions/guilds.php');
    include('includes/functions/404.php');
    
    $posts = true;
    $C404 = new class404();
	$userPanelClass = new userPanelC();
    $ip = $_SERVER['REMOTE_ADDR'] = '::1' ? '127.0.0.1' : $_SERVER['REMOTE_ADDR'];
    $ipQuery = $db->query("SELECT * FROM ip_connections WHERE ip_address = '$ip'");
    $ipQueryFetched = $ipQuery->fetch_assoc();
	//if isset login session.
    if(!isset($_SESSION['username'])){
        if($ipQuery->num_rows == 1){
            echo 'somthing';
            if(!isset($_SESSION['username'])){
                echo " wrong";
                $_SESSION['username'] = $ipQueryFetched['username'];
                header('Location: '. $_SERVER['PHP_SELF']);
            }
            else{
                echo $_SESSION['username'];

            }
        }
	   else{
		header("Location: join.php");
       }
	}
    
	else{
		$username = $_SESSION['username'];
		if (isset($_GET['logout'])) {
			header("Location: includes/functions/logout.php?from=index.php");
		}

	}


?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<meta charset="utf-8">
		<link rel="shortcut icon" type="image/ico" href="css/imgs/favicon.jpg" />
		<link rel="stylesheet" type="text/css" href="css/import.css">
		<link rel="stylesheet" type="text/css" href="css/colors.css">
		<script src="js/jquery-2.0.3.min.js"></script>
		<style type="text/css">
		#mainBlock{display: inline-block; *display: inline; zoom: 1; vertical-align: top; font-size: 12px;}

		</style>
        <script>
        $(function() {
          $('a[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
              var target = $(this.hash);
              target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
              if (target.length) {
                $('html,body').animate({
                  scrollTop: target.offset().top
                }, 500);
                return false;
              }
            }
          });
        });
        $(window).scroll(function(){
        	if($(window).scrollTop() >= 700){
        		$('#scrollToTop').fadeIn('fast', function(){
        			$(this).css({'opacity':'0.7'});
        			$('#scrollToTop').hover(function(){$(this).css({'opacity':'1'});},
										function(){$(this).css({'opacity':'0.7'});
					});
        		});
				
				
			}
			if($(window).scrollTop() >= 350){
				$('#floatingMainMenu').fadeIn('slow',function(){});
			}
			else{
				$('#scrollToTop').fadeOut('fast');
				$('#floatingMainMenu').fadeOut('fast');
			}
        });
        

        </script>
	</head>
	<body>
        <div id="mainBody">
            <!-- side bar-->
            <div id="sidebar">

                <h2 style="font-size:32pt;">Friends Connected:</h1>
                <hr />
                <div style="font-size:16pt;line-height:40px;">
                    <?php
                        $userId2 = $userPanelClass->userId($_SESSION['username']);
                        $userPanelClass->friendsConnected($userId2);
                    ?>
                </div>
            </div>
            <div id="scrollToTop">
            	<a href="#mainBody">
            		<img src="./css/imgs/up-arrow.png">
            	</a>
            </div>
            <div id="floatingMainMenu">
            	<ul style="">
                	<li><a href="./id"><?php echo $username;?></a></li>

            	</ul>
            </div>
            <!--header-->
            <header>
                <div id="header">
                    <div id="headerText">

                    </div>
                    <div id="headerContainer">
                        <a href="index.php" style="text-decoration:none;cursor:auto;">
                            <div id="logo">
                                <div id="logoText">
                                    the<b>42</b>block
                                </div>
                            </div>
                        </a>
                        <div id="overFlow-mainMenu">
                            <div id="mainMenuContainer">
                                <div class="mainMenu" id="mainMenu">
                                    <ul style="position:relative;float:right;right:50px;">
                                        <li><a href="?logout">logout</a></li>
                                        <li><a href="./id">hello, <?php echo $username;?></a></li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="bottom-mainMenu">
                        <ul>
                            <li><a href="#">friends</a>			</li>
                            <li><a href="#">games</a>			</li>
                            <li><a href="./guilds">guilds</a>	</li>
                            <li><a href="#">chat</a>			</li>
                            <li><a href="#">the Backgrounder</a></li>
                            <li><a href="#">contact</a>			</li>
                        </ul>
                    </div>
                </div>
            </header>

            <!--mainBlock-->
            <div id="mainBlockIndex">
                <div>
                    
                    <!--This block menu for PHP functions. see source code to learn more.-->
                    <?php
                        # here goes the functions transfer by url (GET)
                        # userpanel function
                        if(isset($_GET['guilds'])){

                            $guilds = new guilds();
                            if($_GET['guilds'] == null){

                                $guilds->mainGuild();
                                exit();
                            }
                            else{
                                $guildId = $_GET['guilds'];
                                $guildQuery   = $db->query("SELECT * FROM guilds WHERE guild_id = '$guildId'");
                                $guildMember  = $db->query("SELECT * FROM guilds_apply WHERE guild_id = '$guildId' AND member_username = '$username'");
                                
                                $guildMembera= $guildMember->fetch_array();

                                if($guildQuery->num_rows == 0){
                                    $C404->function404();
                                    exit();
                                }
                                if($guildMembera['member_type'] == 'manager'){
                                    $guilds->adminPage($_GET['guilds']);
                                    $posts = false;
                                }
                                else{
                                    
                                    $guilds->guildPage($_GET['guilds']);
                                    $posts = false;
                                }
                            }

                        }
                        if (isset($_GET['id'])) {

                            if (isset($_GET['userId'])) {
                                $userId = $_GET['userId'];


                                $idQuery = $db->query("SELECT * FROM users WHERE user_id = '$userId'");

                                if($idQuery->num_rows == 0){
                                    $C404->function404();
                                    exit();
                                }
                                $userPanel = $userPanelClass->userPanel($userId);
                                $posts = false;
                            }
                            elseif(!isset($_GET['userId'])){
                                $userIdGet = $userPanelClass->userId($username);
                                header("Location: /42block/id?userId=$userIdGet");
                            }

                        }
                        # seccess message
                        elseif (isset($_GET['seccess'])) {
                            if ($_GET['secces'] = 'steam') {
                                echo "<div id=\"seccessGreen\"> you seccessfuly got disconected from Steam! </div>";
                            }
                        }
                        #otherwise it'll display the normal news feed

                        else{
                            if($posts == true){
                                include_once('includes/posts.php');
                                $posts = new posts();
                                $posts->postsFunction();
                            }
                        }
                        

                    ?>
                    
                </div>
            </div>
            <br><br>
            <!-- footer goes here -->
            <div id="footer">
                <div id="subfooter">
                    <div id="footer-logo" onmouseover="$('.up-arrow').css({'opacity':'1'})" onmouseout="$('.up-arrow').css({'opacity':'0'});">
                        <a href="#mainBody" style="text-decoration:none;">
                            <div id="footer-logoText">
                                <img class="up-arrow" src="css/imgs/up-arrow.png">
                                the<b>42</b>block
                                
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <script src="js/indexScript.js"></script>
        </div>
	</body>
</html>