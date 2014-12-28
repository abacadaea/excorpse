<?php 
//$root = $_SERVER['DOCUMENT_ROOT'];
$root = '.';
//require_once ($root.'/assets/php/base.php');
require_once ($root.'/assets/php/base.php');

require_once ($root.'/assets/php/user.php');
require_once ($root.'/assets/php/time.php');
require_once ($root.'/assets/php/server.php');

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

if (isset ($_POST["delete"])) {
    $id = $_POST["delete"];
    delPoem ($id);
}

require_once ($root.'/assets/display/headerDisplay.php');
?>
<script type = "text/javascript">
    $('#link-view').addClass('active');
</script>
<h3>Recently Completed Poems</h3>
<div class = 'poem'>
<?php
//$lines_room = "lines_public";
$lines_room = "lines_$room";
$res = mysql_query ("SELECT * FROM Poems WHERE complete = 1 ORDER BY timeComplete DESC");
$i = 0;
while ($row = mysql_fetch_array ($res)) {
    if ($i % 2 == 0)
	echo "<div class = 'row'>";
    echo "<div class = 'span4'>";
    
    //poem
    $out = getPoemDisplay ($row, $user);
    echo $out;
    //poem\

    echo "</div>";
    if ($i % 2 == 1)
	echo "</div>";
    $i ++;
}
?>
</div>

<?php
    require_once ($root.'/assets/display/footerDisplay.php');
?>


