<?php 
//$root = $_SERVER['DOCUMENT_ROOT'];
$root = '..';
//require_once ($root.'/assets/php/base.php');
require_once ($root.'/assets/php/base.php');

require_once ($root.'/assets/php/user.php');
require_once ($root.'/assets/php/time.php');

if (isLoggedIn () == false)
{
    header ('location: /');
    return;
}

$user = $_COOKIE["HCuser"];
$userRow = getUser ($user);
$userRole = $userRow["userRole"];

if ($userRole != "admin")
{
    header ('location: /');
    return;
}

require_once ($root.'/assets/display/headerDisplay.php');

require_once ('adminNavBar.php');
require_once ($root.'/view.php');
?>

<?php
    require_once ($root.'/assets/display/footerDisplay.php');
?>

