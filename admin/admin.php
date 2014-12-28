<?php
function getAdminPass () {
    return "TopCoder123";
}
function numPosts () {
    $res = mysql_query ("SELECT * FROM Posts");
    return mysql_num_rows ($res);
}
function numVisiblePosts () {
    $res = mysql_query ("SELECT * FROM Posts WHERE isVisible = 1");
    return mysql_num_rows ($res);
}

function makePost ($title, $author, $content, $time, $timeText) {
    $content = addslashes ($content);
    mysql_query ("INSERT INTO Posts (title, author, content, time, timeText) 
    VALUES ('$title', '$author', '$content', $time, '$timeText')");
}

function updatePost ($id, $title, $author, $content) {
    $content = addslashes ($content);
    mysql_query ("UPDATE Posts SET title = '$title', author = '$author', content = '$content' WHERE postID = $id");
}

function getPostByTime ($time) {
    $res = mysql_query ("SELECT * FROM Posts WHERE time = $time");
    $row = mysql_fetch_array ($res);
    return $row;
}
function getPostByID ($id) {
    $res = mysql_query ("SELECT * FROM Posts WHERE postID = $id");
    $row = mysql_fetch_array ($res);
    return $row;
}

function getPostDisplayRaw ($title, $author, $content) {
    $ret ="<h3>$title</h3>"
	 ."By $author. <br><br>"
	 ."$content<br><hr>";
    return $ret;
}

function getPostDisplay ($postRow) {
    $title = $postRow["title"];
    $author = getUserURL($postRow["author"]);
    $time = $postRow["time"];
    $timeText = $postRow["timeText"];
    $timeDiff = time () - $time;
    $timeDiffDisplay = timeDiffDisplay ($timeDiff);
    //$content = htmlspecialchars ($postRow["content"]);
    $content = $postRow["content"];
    $id = $postRow["postID"];
    $isVis = $postRow["isVisible"];

    $ret ="<h3>$title</h3>"
	 ."By $author on $timeText ($timeDiffDisplay). <br><br>"
	 ."$content<br><br>";
    
    global $userRole;
    if ($userRole == 'admin') {
	if ($isVis)
	    $ret .= successMessage ("Visible");
	else
	    $ret .= errorMessage ("Hidden");

	$ret .= "<a class = 'btn btn-primary' href = '/admin/editPost.php?id=$id'>Edit</a>";
	if ($isVis) {
	    $ret .= " <a class = 'btn btn-primary' href = '/admin/modifyPost.php?id=$id&op=hide'>Hide</a>";
	}else {
	    $ret .= " <a class = 'btn btn-primary' href = '/admin/modifyPost.php?id=$id&op=show'>Show</a>";
	}
	//$ret .= " <a class = 'btn btn-danger' href = '/admin/modifyPost.php?id=$id&op=delete'>Delete</a>";
	
    }
    $ret .= "<hr><br>";
    
    return $ret;
}

function getAllPostDisplay ($page) {
    global $userRole;

    //pages
    $PAGE_SIZE = 20;
    $numPages = ceil (($userRole == "admin" ? numPosts () : numVisiblePosts ()) / $PAGE_SIZE);
    if ($page <= 0 || $page > $numPages)
	$page = 1;
    $start = ($page - 1) * $PAGE_SIZE;

    //mysql query
    $res;
    if ($userRole == "admin")
	$res = mysql_query ("SELECT * FROM Posts ORDER BY time DESC LIMIT $start, $PAGE_SIZE");
    else
	$res = mysql_query ("SELECT * FROM Posts WHERE isVisible = 1 ORDER BY time DESC LIMIT $start,$PAGE_SIZE");

    //page URLS
    $pageURLS = "<b>Goto page: ";
    for ($i = 1; $i <= $numPages; $i ++) {//CHECK 
	$curPageURL = "";
	if ($i == $page)
	    $curPageURL = "$i ";
	else
	    $curPageURL = "<a href = '?page=$i'>$i</a> ";
	$pageURLS .= $curPageURL;
    }
    $pageURLS .= "</b>";

    //display
    $ret = $pageURLS;
    while ($row = mysql_fetch_array ($res)) {
	$post = getPostDisplay ($row);
	$ret .= $post;
    }
    $ret .= $pageURLS;
    return $ret;
}
?>
