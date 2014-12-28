<?php 
$root = '..';
include ($root.'/assets/php/base.php');

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

require_once ($root.'/assets/display/headerDisplay.php');
?>
<script type = "text/javascript">
    $('#link-write').addClass('active');
</script>

<?php
    require_once ($root.'/write/write.php');
    echo "<br><br><br><hr>";
    if (isLoggedIn ()) {
	require_once ($root.'/write/writenew.php');
	echo "<hr>";
    }
    require_once ($root.'/vote/vote.php');
?>

<?php
    require_once ($root.'/assets/display/footerDisplay.php');
?>
