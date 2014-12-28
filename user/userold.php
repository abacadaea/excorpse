<?php 
//$root = $_SERVER['DOCUMENT_ROOT'];
$root = "./..";
require_once ($root.'/assets/php/base.php');


if (isLoggedIn () == false)
{
    header ('location: /');
    return;
}

require_once ($root.'/assets/php/user.php');
require_once ($root.'/assets/php/time.php');
require_once ($root.'/assets/php/server.php');

$user = "";
if (isset ($_GET["name"])) {
    $user = $_GET["name"];
}else {
    $user = $_COOKIE[$USER_COOKIE]; 
}

$error = null;

$joined = "";
$lastVisit = "";

$name = "";
$school = "";

$userRow = getUser ($user);
if ($userRow == null) {
    $error = errorMessage ("User '$user' does not exist");
}else {
    $joined = timeDiffDisplay (time () - $userRow ["joined"]);
    $lastVisit = timeDiffDisplay (time () - $userRow ["lastVisit"]);

    $name = $userRow ["name"]; //will be "" if not entered or invalid
    $school = $userRow ["school"];
}

require_once ($root.'/assets/display/headerDisplay.php');
?>
<script type = "text/javascript">
    $('#link-user').addClass('active');
</script>

<?php
if (!isset ($_GET["name"]))
    require_once ($root.'/user/userNavBar.php');
?>

<div class = "row">
    <div class = "span4">
      <div id = "error-msg">
	<?php if ($error != null) {echo $error; return;}?>      
      </div>

      <h3><?php echo getUserURL($user);?></h3>
      Joined: <?php echo $joined;?> <br>
      Last Visit: <?php echo $lastVisit;?> <br>
      <b>Name: </b> <?php echo $name;?> <br>
      <b>School: </b> <?php echo $school;?> <br>
    </div>
    <div class = "span6 poem">
	<h3>Recent Completed Poems</h3>
	<?php
	    $ids = getAllPoems ($user);
	    $i = 0;

	    while ($row = mysql_fetch_array ($ids)) {
		if (isComplete ($row["poemID"])) {
		    /*if ($i % 2 == 0)
			echo "<div class = 'row'>";
		    echo "<div class = 'span3'>";*/
		    
		    //poem
		    $out = getPoemDisplay ($row["poemID"], $user);
		    echo $out;
		    //poem\

		    /*
		    echo "</div>";
		    if ($i % 2 == 1)
			echo "</div>";
		    $i ++;
		}
	    }
	?>
    </div>
</div>
<?php
    require_once ($root.'/assets/display/footerDisplay.php');
?>

