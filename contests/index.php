<?php 
foreach ($_COOKIE as $key=>$val)
{
    if (substr ($key, 0, 6) == "phpcsl") {
	setcookie ("$key", "", time() - 3600); 
    }
}

//$root = $_SERVER['DOCUMENT_ROOT'];
$root = '..';
//require_once ($root.'/assets/php/base.php');
require_once ($root.'/assets/php/base.php');

require_once ($root.'/assets/php/user.php');
require_once ($root.'/assets/php/time.php');
require_once ($root.'/assets/php/post.php');
require_once ($root.'/assets/php/userInContest.php');
require_once ($root.'/assets/php/macroContest.php');

debug ("HI");
foreach ($_COOKIE as $key=>$val)
  {
    echo $key.' is '.$val."<br>\n";
  }

?>
