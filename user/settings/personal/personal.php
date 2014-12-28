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
    $name = $_POST["name"];
    $school = $_POST["school"];

    userSetColumn ($user, $name, "name");
    userSetColumn ($user, $school, "school");
    $msg = successMessage ("Info updated successfully");
}



$userRow = getUser ($user);
$name = $userRow ["name"];
$school = $userRow ["school"];

require_once ($root.'/assets/display/headerDisplay.php');
?>
<script type = "text/javascript">
    $('#link-settings-personal').addClass('active');
</script>
<?php
    if (!isset ($_GET["name"]))
	require_once ($root.'/user/settings/settingsNavBar.php');
?>

      <div id = "msg">
	<?php echo $msg;?>      
      </div>

    
    <form class="form-settings" target = "_self" method = "post">    
        <h3 class="form-settings-heading">Personal Info</h3>
	<table style = "">
	<tr>
	    <td>Name</td>
	    <td><input name = "name" type="text" value = "<?php echo "$name";?>"></td>
	</tr>
	<tr>
	    <td>School</td>
	    <td><input name = "school" type="text" value = "<?php echo "$school";?>"></td>
	</tr>
	 </table>

        <button name = "submit" class="btn btn-primary" type="submit">Update</button>
<form class = "form-settings">

    </form>

<?php
    require_once ($root.'/assets/display/footerDisplay.php');
?>

