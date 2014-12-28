<?php 
$root = ".";
require_once ($root.'/assets/php/base.php');
require_once ($root.'/assets/php/user.php');
require_once ($root.'/assets/php/time.php');
require_once ($root.'/assets/display/headerDisplay.php');
?>
<script type = "text/javascript">
    $('#link-about').addClass('active');
</script>

<h2>About</h2>

This is a fun, creative experiment to see what we can create together. <br>
<br>
<b>See also: <a href = "http://en.wikipedia.org/wiki/Exquisite_corpse">Exquisite Corpse</a></b>

<?php
    require_once ($root.'/assets/display/footerDisplay.php');
?>

