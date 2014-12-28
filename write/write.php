<?php
$line = "";
$msg = "";

if (isset ($_POST["submitAdd"])) {
    $line = $_POST["line"];
    $line = stripslashes ($line);
    $id = $_POST["submitAdd"];

    if ($id == -1){
	//already error message;
    }else if ($_COOKIE["numSubmit"] >= 3 && !isLoggedIn ()) {
	$msg = errorMessage ("You may only submit up to three lines as a guest. Register <a href = '/register'>here</a>");
    }else if (!isset ($line) || strlen($line) == 0) {
	$msg = errorMessage ("Please write the next line");
    }else {
	if (!isValidInput ($line)) {
	    $msg = errorMessage ("Invalid chararacters used");
	}else {
	    addLine ($line, $id, $user);
	    $msg = successMessage ("Line \"$line\" added successfully");
	    $line = "";

	    if (isset ($_COOKIE["numSubmit"]))
		$numsubmit = $_COOKIE["numSubmit"] + 1;
	    else
		$numsubmit = 0;
	    setcookie ("numSubmit", $numsubmit, time () + 3600 * 24, "/");
	}
    }
}

$prevLine = "";
$id = -1;
$row = getLineRow ($room, $user);
$isLastLine = "";
if ($row == null) {
    $msg .= errorMessage ("No lines currently available.");
}else {
    $prevLine = $row["content"];
    $id = $row["poemID"];
    if (isLastLine ($id)) {
	//$isLastLine = warningMessage ("This is the last line of this poem. Make it a good one!");
	$isLastLine = "This is the last line of this poem. Make it a good one!";
    }
}
  
?>
    <div id = "msg">
	<?php echo $msg; ?>
    </div>
<h3>Write the next line</h3>
<div class = "jumbotron">
    <?php
	echo "<h3>$prevLine</h3>";
    ?>
    <form method = "post" target = "_self" class = "line-input">
	<input type = "text" name = "line" placeholder = "Line" value = "<?php echo $line;?>"></input>
	<br>
	<button class = "btn btn-success" type = "submit" name = "submitAdd" value = "<?php echo $id;?>">Submit</button>
	<button class = "btn btn-primary" type = "submit" name = "skip">Skip</button>
    </form>
    <?php 
	echo "<p class = 'muted'>$isLastLine</p>";
	if (!isLoggedIn ()) {
	    echo "<p class = 'muted'>You are not logged in. Your responses will be recorded as anonymous. You can make an account real quick <a href = '/register'>here</a>.</p>";
	}
    ?>
</div>
