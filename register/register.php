<?php 
$root = "./..";
require_once ($root.'/assets/php/base.php');

if (isLoggedIn ())
{
    header ('location: /');
}

require_once ($root.'/assets/php/user.php');

//check form
$user = "";
$error = "";

if (isset ($_POST["submit"])) {
    unset ($_POST["submit"]);

    if (noSpamRegister ()) {
	$user = $_POST["username"];
	$pass = $_POST["password"];
	$passconf = $_POST["password-conf"];

	$validate = userRegister ($user, $pass, $passconf);
	
	//debug ("User registration attempt: $user");
	if ($validate == null) {
	    login ($user, 3600);
	}else {
	    $error = errorMessage ($validate);
	}
    }else {
	$error = errorMessage ("Too many users registered in the past few minutes. Please try again in a few minutes.");
    }
}

require_once ($root.'/assets/php/time.php');

require_once ($root.'/assets/display/headerDisplay.php');
?>
<script type = "text/javascript">
    $('#link-register').addClass('active');
</script>

      <div id = "error-msg">
	<?php echo $error;?>
      </div>

      <form class="form-signin" target = "_self" method = "post">
        <h3 class="form-signin-heading">Register</h3>
        <input name = "username" type="text" value = "<?php echo $user;?>" class="input-block-level" placeholder="Username">
        <input name = "password" type="password" class="input-block-level" placeholder="Password">
        <input name = "password-conf" type="password" class="input-block-level" placeholder="Retype Password">
        <button name = "submit" class="btn btn-large btn-primary" type="submit">Register</button>
	<!--
	<br>
	<br>
	<i>Don't have a username? <a href = "/register">Register here!</a></i>-->
      </form>

<?php
    require_once ($root.'/assets/display/footerDisplay.php');
?>
