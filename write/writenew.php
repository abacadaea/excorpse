<?php
$line = "";
$msg = "";
$length = $DEFAULT_LENGTH; 

if (isset ($_POST["submitNew"])) {
    $line = $_POST["line"];
    $line = stripslashes ($line);
    $length = $_POST["numLines"];

    //if has slashes, strip slashes
    /*$hasslash = false;
    for ($i = 0; $i < strlen ($line); $i ++) {
	if (ord ('\\') == ord ($str[$i])) {
	    $hasslash = true;
	    break;
	}
    }
    if ($hasslash)*/

    if (!isset ($line) || strlen($line) == 0) {
	$msg = errorMessage ("Please enter in a line of poetry");
    }else {
	if (!isValidInput ($line)) {
	    $msg = errorMessage ("Invalid chararacters used");
	}else {
	    $id = addPoem ($room, $length);
	    addLine ($line, $id, $user);
	    $msg = successMessage ("Poem beginning with \"$line\" added successfully");
	    $line = "";
	}
    }
}
  
?>

    <div id = "msg">
	<?php echo $msg; ?>
    </div>
<h3>
<?php
    echo "Start a new poem";
?>
</h3>

<div class = "jumbotron">
    <form method = "post" target = "_self" class = "line-input">
	<input type = "text" name = "line" placeholder = "Line" value = "<?php echo $line;?>">
	<br>
	Number of lines: 
	<select name = "numLines" style = "width: 50px">
	    <option value = "3">3</option>
	    <option value = "4">4</option>
	    <option value = "5">5</option>
	    <option value = "6">6</option>
	    <option value = "7">7</option>
	    <option value = "8">8</option>
	    <option value = "9">9</option>
	    <option value = "10">10</option>
	    <option value = "11">11</option>
	    <option value = "12">12</option>
	    <option value = "13">13</option>
	    <option selected = "selected" value = "14">14</option>
	    <option value = "15">15</option>
	    <option value = "16">16</option>
	    <option value = "18">18</option>
	    <option value = "20">20</option>
	    <option value = "20">30</option>
	    <option value = "20">50</option>
	</select>
	<br>
	<input class = "btn btn-success" type = "submit" name = "submitNew" value = "Submit">
    </form>
</div>
