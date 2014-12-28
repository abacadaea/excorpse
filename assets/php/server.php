<?php
function validLineAdd ($poemID) {
    $row = getRow ("Poems", "ID", $poemID);
    if ($row == null)
	return false;
    if ($row["complete"])
	return false;

    return true;
}

function addLine ($line, $poemID, $user) {
    $line = addslashes ($line);

    $row = getRow ("Poems", "ID", $poemID);
    $linesWritten = $row["linesWritten"];
    $length = $row["length"];
    $room = $row["room"];
    $lines_room = "lines_".$room;

    //add line
    $query = "INSERT INTO $lines_room (content, lineNum, poemID, room, user) VALUES ('$line', $linesWritten, $poemID, '$room', '$user')";
    $res = mysql_query ($query);
    if (!$res)
	die ($query);

    //update poems lines written
    $linesWritten = $linesWritten + 1;
    mysql_query ("UPDATE Poems SET linesWritten = $linesWritten, lastUser = '$user' WHERE ID = $poemID");

    //update rooms number of participating users
    incrementCol ("Rooms", "numLines", "name", $room);

    //update users
    if (strlen($user) > 0)
	incrementCol ("Users", "numLines", "username", $user);

    //end poem if necessary
    if ($linesWritten == $length) {
	endPoem ($poemID);
    }
}

function endPoem ($id) {
    $res = mysql_query ("SELECT * FROM Poems WHERE ID = $id");
    if (!$res)
	return "Poem doesn't exist";

    $row = mysql_fetch_array ($res);
    $room = $row["room"];

    $row = getRow ("Rooms", "name", $room);
    $inprogress = $row ["numInProgress"] - 1;
    $complete = $row ["numComplete"] + 1;
    if ($inprogress < 0)
	return "Database Error";

    //text
    $lines_room = "lines_$room";
    $text = "";
    $res = mysql_query ("SELECT * FROM $lines_room WHERE poemID = $id ORDER BY lineNum ASC");

    //get text
    $authors = "";
    while ($row = mysql_fetch_array ($res)) {
	$name = ($row["user"] ? $row["user"] : "<i>Anonymous</i>");
	$authors .= "$name,";
	$text .= $row["content"]."<br>";
    }

    $authors = addslashes ($authors);
    $text = addslashes ($text);

    //update
    $time = time ();
    mysql_query ("UPDATE Poems SET complete = 1, timeComplete = $time, poemText = '$text', authorText = '$authors' WHERE ID = $id");
    mysql_query ("UPDATE Rooms SET numInProgress = $inprogress, numComplete = $complete");
}

function addPoem ($room, $length) {
    if ($room == null || strlen($room) == 0)
	$room = "public";
    mysql_query ("INSERT INTO Poems (room, length) VALUES ('$room', $length)");
    $id = mysql_insert_id ();
    if (!isRoom ($room))
	addRoom ($room);

    incrementCol ("Rooms", "numInProgress", "name", $room);
    return $id;
}

function delPoem ($id) {
    $row = getRow ("Poems","ID", $id);
    $room = $row["room"];
    $lines_room = "lines_$room"; //*
    mysql_query ("DELETE FROM Poems WHERE ID = $id");
    mysql_query ("DELETE FROM $lines_room WHERE poemID = $id");
    decrementCol ("Rooms", "numCompleted", "name", $room);
}

function isComplete ($id) {
    $row = getRow ("Poems","ID", $id);
    return ($row["complete"]);
}

function isRoom ($roomName) {
    $res = mysql_query ("SELECT * FROM Rooms WHERE name = '$roomName'");
    return (mysql_num_rows ($res) > 0);
}
function addRoom ($room) {
    $lineTable = "lines_$room";
    debug ($lineTable);
    mysql_query ("CREATE TABLE $lineTable LIKE lines_");
    mysql_query ("TRUNCATE TABLE $lineTable");
    mysql_query ("INSERT INTO Rooms (name) VALUES ('$room')");
}

/*
Generating things
*/

function getLineRow ($room, $user) {
    $Lines = "lines_$room";
    
    $res = mysql_query 
	("SELECT * FROM Poems 
	  WHERE room = '$room'
	  AND lastUser != '$user'
	  AND complete = 0
	  ORDER BY RAND() 
	  LIMIT 10");
    
    $row = mysql_fetch_array ($res);
    if ($row != null) {
	$id = $row["ID"];
	$lineNum = $row["linesWritten"] - 1;
	$res = mysql_query ("SELECT * FROM $Lines WHERE lineNum = $lineNum AND poemID = $id");
	$row = mysql_fetch_array ($res);
	return $row;
    }
    return null;
}

function isLastLine ($id) {
    $row = getRow ("Poems", "ID", $id);
    return ($row["linesWritten"] + 1 == $row ["length"]);
}

function hasAuthor ($user, $authors) {
    $alist = explode (",", $authors);
    for ($i = 0; $i < count ($alist) - 1; $i ++) {
	if ($alist [$i] == $user) {
	    return true;
	}
    }
    return false;
}

function highlightAuthor ($user, $authors) {
    if (strlen ($user) == 0)
	return $authors;

    $alist = explode (",", $authors);
    for ($i = 0; $i < count ($alist); $i ++) {
	if ($alist [$i] == $user) {
	    $alist [$i] = "<span class = 'author-self'>$user</span>";
	}
    }
    array_pop ($alist);
    return implode (",", $alist);
}

function getPoemDisplay ($row, $user = "") {
    global $userRole;

    $id = $row["ID"];
    $room = $row["room"];
    $lines_room = "lines_$room";

    $ret = "<a class = 'muted' href = '/view.php?id=$id'>#$id</a><br>";
    $ret .= $row ["poemText"];
    $ret .= "<span class = 'author'><b>Authors: </b>" 
	    . highlightAuthor ($user, $row ["authorText"]);
    $ret .= "<br><b>Completed</b> " . timeDiffDisplay (time () - $row["timeComplete"]) . "</span>";

    if ($userRole == "admin") {
	$ret .= 
	    "<form method = 'post'><button class = 'btn btn-small btn-danger' 
		     name = 'delete'
		     value = '$id' 
		     formtarget='_self'>
		Delete
	    </button></form>";
    }

    return $ret . "<br>";
}

function getAllPoems () {
    return mysql_query ("SELECT * FROM Poems WHERE complete = 1");
}

function totalLines () {
    $res = mysql_query ("SELECT * FROM Rooms");
    $tot = 0;
    while ($row = mysql_fetch_array ($res)) {
	$tot += $row["numLines"];
    }
    return $tot;
}

/*
function getPoemDisplay ($id, $user = "", $lines_room = "lines_public") {
    $ret = "<table>
		<tr><th><span class = 'muted'>#$id</span></th><th>Author</th></tr>
		";
    $res = mysql_query ("SELECT * FROM $lines_room WHERE poemID = $id ORDER BY lineNum ASC");

    while ($row = mysql_fetch_array ($res)) {
	$author = ($row["user"] ? $row["user"] : "<i>Anonymous</i>");
	if ($row["user"] == $user && strlen ($user) > 0)
	    $add = "<tr class = 'highlight'>";
	else
	    $add = "<tr>";
	$add .= "<td>" . $row["content"] . "</td>";
	$add .= "<td>$author</td></tr>";
	$ret .= $add;
    }

    $ret .= "</table><br>";
    return $ret;
}
*/

?>
