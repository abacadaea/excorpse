<?php 
$root = "./../../..";
require_once ($root.'/assets/php/base.php');


if (isLoggedIn () == false)
{
    debug ("Not logged In");
    header ('location: /');
    return;
}

require_once ($root.'/assets/php/user.php');
require_once ($root.'/assets/php/time.php');

$user = $_COOKIE["HCuser"];
$msg = "";

if (isset ($_POST["submit"])) {
    $email = $_POST["email"];
    $oldPass = $_POST["oldPass"];
    $pass = $_POST["pass"];
    $passConf = $_POST["passConf"];

    if (!checkPass ($user, $oldPass)) {
	$msg = errorMessage ("Incorrect password. Please enter old password to change settings.");
    } else {
	//set email
	if ($email != userGetColumn ($user, "email")) {
	    $emailOK = validEmail ($email);
	    if ($emailOK != null)
		$msg = errorMessage ($emailOK);
	    else {
		$msg = successMessage ("Email updated successfully");
		userSetColumn ($user, $email, "email");
	    }
	}

	//set password
	if ($pass != null) {
	    $passOK = validPassword ($pass);
	    if ($passOK)
		$msg .= errorMessage ($passOK);
	    else if ($pass != $passConf)
		$msg .= errorMessage ("Passwords do not match");
	    else {
		setPass ($user, $pass);
		$msg .= successMessage ("Password updated succesfully");
	    }
	}
    }
}


$userRow = getUser ($user);
$email = $userRow ["email"];

require_once ($root.'/assets/display/headerDisplay.php');
?>
<script type = "text/javascript">
    $('#link-settings').addClass('active');
    $('#link-settings-general').addClass('active');
</script>
<?php
    if (!isset ($_GET["name"]))
	require_once ($root.'/user/settings/settingsNavBar.php');
?>

      <div id = "msg">
	<?php echo $msg;?>      
      </div>


    
    <form class="form-settings" target = "_self" method = "post">    
        <h3 class="form-settings-heading">General Info</h3>
	<table style = "">
	<tr>
	    <td>Email</td>
	    <td><input name = "email" type="text" value = "<?php echo "$email";?>"></td>
	</tr>
	<tr>
	    <td>Old Password</td>
	    <td><input name = "oldPass" type="password"></td>
	</tr>
	<tr>
	    <td>New Password</td>
	    <td><input name = "pass" type="password"></td>
	</tr>
	<tr>
	    <td>Confirmation</td>
	    <td><input name = "passConf" type="password"></td>
	</tr>
	 </table>

        <button name = "submit" class="btn btn-primary" type="submit">Update</button>
<form class = "form-settings">

    </form>

<?php
    require_once ($root.'/assets/display/footerDisplay.php');
?>
