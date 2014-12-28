<?php 
$root = '.';
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

$startDate = "August 4, 2013";

require_once ($root.'/assets/display/headerDisplay.php');
?>
<script type = "text/javascript">
    $('#link-home').addClass('active');
</script>

<div class = "jumbotron">
    <h2>Cadavre Exquis</h2>
    <h3>Collaborative Poetry Project</h3>
    <h4>Click <a href = "/write">Here</a> to Start Writing!</h4>
    <h4><?php echo totalLines(); ?> Lines of poetry written since <?php echo $startDate; ?>!</h4>
</div>

<?php
    require_once ($root.'/assets/display/footerDisplay.php');
?>
