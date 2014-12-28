<?php 
$root = "./..";
require_once ($root.'/assets/php/base.php');

/*
if (isLoggedIn () == false)
{
    debug ("Not logged In");
    header ('location: /');
    return;
}*/

require_once ($root.'/assets/php/user.php');
require_once ($root.'/assets/php/time.php');

function oppDir ($dir) { //hacky
    if ($dir == "ASC")
	return "DESC";
    else
	return "ASC";
}

$PAGE_SIZE = 20;

$error = null;

$order = "joined";
$dir = "ASC"; //check that this works
$arrow = "";

//pages
$page = 1;
$numPages = ceil (numActiveUsers () / $PAGE_SIZE);

if (isset ($_GET["page"])) {
    $page = $_GET["page"];
    if ($page <= 0 || $page > $numPages)
	$page = 1;
}
$start = ($page - 1) * $PAGE_SIZE;
$pageGET = "&page=$page";

$joinedSymbol = "";
$ratingSymbol = "";
$userSymbol = "";

$joinedDir = "DESC";
$ratingDir = "DESC";
$userDir = "ASC";

if (isset ($_GET["dir"])) {
    $dir = $_GET["dir"];
    if ($dir != "ASC" && $dir != "DESC")
	$dir = "ASC";
}

$arrow = ($dir == "ASC" ? "&#8593;" : "&#8595;"); //which arrow?

if (isset ($_GET["order"])) {
    $order = $_GET["order"];
}
    
if ($order == "joined") {
    $joinedSymbol = $arrow;
    $joinedDir = oppDir ($dir);
}
if ($order == "rating") {
    $ratingSymbol = $arrow;
    $ratingDir = oppDir ($dir);
}
if ($order == "username") {
    $userSymbol = $arrow;
    $userDir = oppDir ($dir);
}

//userRole = 'user'
$res = mysql_query ("SELECT * FROM Users WHERE isActive = 1 ORDER BY $order $dir LIMIT $start,$PAGE_SIZE");
if (!$res) {
    $error = "Invalid parameters";
}

//$res = mysql_query ("SELECT * FROM Users WHERE isActive = 1, numMatches > 0 ORDER BY $order DESC");

//page urls
$pageURLS = "<b>Goto page: ";
for ($i = 1; $i <= $numPages; $i ++) {//CHECK 
    $curPageURL = "";
    if ($i == $page)
	$curPageURL = "$i ";
    else
	$curPageURL = "<a href = '?order=$order&dir=$dir&page=$i'>$i</a> ";
    $pageURLS .= $curPageURL;
}
$pageURLS .= "</b>";

require_once ($root.'/assets/display/headerDisplay.php');
?>

<script type = "text/javascript">
    $('#link-members').addClass('active');
</script>

      <h2>Member List</h2>

      <div id = "error-msg">
	<?php if ($error != null) {echo $error; return;}?>      
      </div>
      <?php echo $pageURLS;?>
      <br>
      <br>
      <div id = "table">
	<table class = "table table-hover table-striped">
	    <tr>
		<th style = "width: 30%"><a href = "<?php echo "?order=username&dir=$userDir$pageGET";?>">Username</a>  <?php echo $userSymbol;?></th>
		<th style = "width: 10%"><a href = "<?php echo "?order=rating&dir=$ratingDir$pageGET";?>">Rating</a>  <?php echo $ratingSymbol;?></th>
		<th style = "width: 10%"><a href = "<?php echo "?order=joined&dir=$joinedDir$pageGET";?>">Member Since</a>  <?php echo $joinedSymbol;?></th>
	    </tr>
	    <?php
		while ($row = mysql_fetch_array ($res)) {
		    $username = $row["username"];
		    $rating = $row["rating"];
		    $joinedText = $row["joinedText"];

		    $userText = getUserURL ($username);

		    echo "
	    <tr>
		<td>$userText</td>
		<td>$rating</td>
		<td>$joinedText</td>
	    </tr>
		    ";
		}
	    ?>
	</table>
      </div>
      <?php echo $pageURLS;?>
<?php
    require_once ($root.'/assets/display/footerDisplay.php');
?>
