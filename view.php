<?php 
//$root = $_SERVER['DOCUMENT_ROOT'];
$root = '.';
//require_once ($root.'/assets/php/base.php');
require_once ($root.'/assets/php/base.php');

require_once ($root.'/assets/php/user.php');
require_once ($root.'/assets/php/time.php');
require_once ($root.'/assets/php/server.php');

$msg = "";
$user = "";
$room = "public";
if (isset ($_GET["room"]))
    $room = $_GET["room"];
if (!isValidRoom ($room))
    header ("location: ./");
if (isLoggedIn ()) 
    $user = $_COOKIE[$USER_COOKIE];
$userRow = getUser ($user);
$userRole = $userRow["userRole"];

$res = null;
if (isset ($_GET["id"])) {
    $id = $_GET["id"];
    $res = mysql_query ("SELECT * FROM Poems WHERE complete = 1 AND ID = $id");
}else {
    $res = mysql_query ("SELECT * FROM Poems WHERE complete = 1 ORDER BY RAND () LIMIT 1");
}

$row = mysql_fetch_array ($res);
if ($row) {
}else {
    $msg = errorMessage ("Poem not available");
}

require_once ($root.'/assets/display/headerDisplay.php');
?>
<div id = "msg">
<?php echo $msg; ?>
</div>
<div class = 'poem-big'>
<h3>View Poem</h3>
<?php
    if ($row) {
	echo getPoemDisplay ($row, $user);
    }
?>
</div>

<?php
    require_once ($root.'/assets/display/footerDisplay.php');
?>



