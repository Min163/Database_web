<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by TEMPLATED
http://templated.co
Released for free under the Creative Commons Attribution License

Name       : Plushiness 
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20131117

-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Min's Cinema</title>
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
<link href="default.css" rel="stylesheet" type="text/css" media="all" />
<link href="fonts.css" rel="stylesheet" type="text/css" media="all" />

</head>
<body>
	<div class="container">
	<header>
		<div id="header-wrapper">
			<div id="header" class="container">
				<div id="logo">
					<span class="icon icon-film"></span>
					<h1><a href="index.php">Min's Cinema</a></h1>
					<span>Design by <a href="http://templated.co" rel="nofollow">TEMPLATED</a></span>
				</div>
				<div id="triangle-up"></div>
			</div>
		</div>
		<div id="menu-wrapper">
			<div id="menu">
				<ul>
					<?php
               		$c_id = $_COOKIE[cookie_id];
               	
                	if(!$_COOKIE[cookie_id] || !$_COOKIE[cookie_name]){
                		echo "<li><a href='login.php'>Login</a></li>";
                	}
                	else{
                		if($_COOKIE[cookie_admin] == 0){ //일반고객일 때
                			echo "<li><a href='logout.php'> $_COOKIE[cookie_name] Logout</a></li>";
                			echo "<li><a href='booking_view.php?c_id={$c_id}'>Booking</a></li>";
                		}
                		else{ //관리자일 때
                			echo "<li><a href='logout.php'> administer Logout</a></li>";
                		}
                		echo "<li><a href='member_view.php?c_id={$c_id}'>My Cinema</a></li>";
                	}
               		?>
					<li><a href="movie_list.php" accesskey="3">Movie</a></li>
					<li><a href="schedule_view.php" accesskey="4">Schedule</a></li>
				</ul>
				</form>
			</div>
		</div>
	</header>
	</div>
	<div class="container">
