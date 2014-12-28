<?php 
//$root = $_SERVER['DOCUMENT_ROOT'];
$root = "./..";
require_once ($root.'/assets/php/base.php');

if (isLoggedIn ())
{
    header ('location: /');
}

require_once ($root.'/assets/php/user.php');

$user = "";
$error = "";

if (isset ($_POST["submit"])) {
    $user = $_POST["username"];
    $pass = $_POST["password"];
    $remember = $_POST["remember-me"];

    $validate = checkPass ($user, $pass);
    $time = ($remember == 1 ? 3600 * 24 * 30 : 3600);

    if ($validate == true) {
	login ($user, $time);
    }else {
	$error = errorMessage ("Invalid username/password combination");
    }
}

require_once ($root.'/assets/display/headerDisplay.php');
?>
<script type = "text/javascript">
    $('#link-login').addClass('active');
</script>

      <div id = "error-msg">
	<?php echo $error;?>      
      </div>

      <form class="form-signin" target = "_self" method = "post">
        <h3 class="form-signin-heading">Login</h3>
        <input name = "username" type="text" value = "<?php echo "$user";?>" class="input-block-level" placeholder="Username">
        <input name = "password" type="password" class="input-block-level" placeholder="Password">
        <label class="checkbox">
	  <input name = "remember-me" type = "hidden" value = "0">
          <input name = "remember-me" type="checkbox" value = "1"> Remember me
        </label>
        <button name = "submit" class="btn btn-large btn-primary" type="submit">Sign In</button>
      </form>

<?php
    require_once ($root.'/assets/display/footerDisplay.php');
?>
