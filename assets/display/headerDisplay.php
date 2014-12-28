<?php
    $userRole = null;
    if (isLoggedIn ()) {
	$user = $_COOKIE[$USER_COOKIE];
	$curtime = time ();

	mysql_query ("UPDATE Users SET lastVisit = $curtime WHERE username = '$user'");
	$userRow = getUser ($user);
	$userRole = $userRow['userRole'];
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Cadavre Exquis Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/assets/css/bootstrap.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <script src="/assets/js/jquery.min.js"></script>

    <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 40px;
      }
    </style>
    <link href="/assets/css/bootstrap-responsive.css" rel="stylesheet">
  </head>

  <body>

    <div class = "container-narrow">
      <div class="masthead">
        <ul class="nav nav-pills pull-right">
		  <li id = "link-home"><a href="/">Home</a></li>
		  <li id = "link-about"><a href="/about.php">About</a></li>
		  <li id = "link-write"><a href="/write">Write!</a></li>
		  <li id = "link-view"><a href="/scoreboard.php">Poems</a></li>
		  <!--<li id = "link-members"><a href="/user/list.php">Members</a></li>-->
		<?php
		  if ($userRole == 'admin')
		    echo "<li><a href='/admin'>Admin CP</a></li>";
		?>
	 <?php 
	    if (isLoggedIn ()) {
		$username = $_COOKIE[$USER_COOKIE];
		
		echo "<li id = 'link-user'>" . getUserURL ($username) . 
		    "</li> 
		    <li id = 'link-settings'><a href = '/user/settings'>Settings</a></li>
		    <li><a href = '/logout.php'>Logout</a></li>";
	    }else {
		echo "<li id = 'link-login'> <a href = '/login'>Login</a></li> 
		    <li id = 'link-register'> <a href = '/register'>Register</a></li>";
	    }
	    ?>
	</ul>

    <h3><a class = "muted" href = "/">Cadavre Exquis</a></h3>
  </div>

    <hr>

<!--CONTENT BEGIN-->
