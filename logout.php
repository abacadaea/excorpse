<?php 
    $root = ".";
    require_once ('./assets/php/base.php');
    require_once ('./assets/php/user.php');

    if (isLoggedIn()){
	logout ($_COOKIE[$USER_COOKIE]);
    }
    header ("location: /");
?>
