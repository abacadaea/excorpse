<?php
function getUser ($user) {
    $res = mysql_query ("SELECT * FROM Users WHERE username = '$user'");
    if (mysql_num_rows ($res) > 0)
	return mysql_fetch_array ($res);
    else
	return null;
}

function validUsername ($username) {
    if (isValidInput ($username) == false)
	return "Username must consist of alphanumeric characters, or one of the characters !@#$%^&*()_.";
    if (strlen ($username) < 4)
	return "Username must be at least 4 characters long";
    if (getUser ($username) != null)
	return "Username already in use";
    
    return null; 
}
//check valid sanitize
function validPassword ($password) {
    if (isValidInput ($password) == false)
	return "Password must consist of alphanumeric characters, or one of the characters !@#$%^&*()_.";
    if (strlen ($password) < 8)
	return "Password must be at least 8 characters long";
    
    return null;
}
//check valid and unique
function validEmail ($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL) == false)
	return "Invalid email address";
    if (isValidInput ($email) == false)
	return "Inavlid email address";

    //unique
    $res = mysql_query ("SELECT * FROM Users WHERE email = '$email'");
    if (mysql_num_rows ($res) > 0)
	return "Email already in use";

    return null;
}

function noSpamRegister () { //CHANGE IF SCALING UP
    $delay = 2 * 60;
    $threshold = 10;
    $lowerBound = time () - $delay;
    $res = mysql_query ("SELECT * FROM Users WHERE joined > $lowerBound");
    
    if ($res != false && mysql_num_rows ($res) >= $threshold) {
	$time = time ();
	$error = "Too many registration attempts at " . date("Y-m-d H:i:s", time());
	mysql_query ("INSERT INTO Errors (time, text) VALUES ($time, '$error')");
	return false;
    }else {
	return true;
    }
}

//true if works
function userRegister ($user, $pass, $passconf) {
    $validate = validUsername ($user);
    if ($validate != null)
	return $validate;
    
    $validate = validPassword ($pass);
    if ($validate != null)
	return $validate;

    if ($pass != $passconf)
	return "Passwords do not match";

    $pass = md5 ($pass);

    $joined = time ();
    $joinedText = date ("M d Y", $joined);
    $lastVisit = $joined;

    $query = "INSERT INTO Users (username, password, joined, joinedText, lastVisit) VALUES ('$user', '$pass', $joined, '$joinedText', $lastVisit)";
    mysql_query ($query);
    //debug ($query);
    return null;
}


function getPass ($user) {
    $row = getUser ($user);
    return $row["password"];
}
function checkPass ($user, $pass) {
    $pass = md5($pass);
    return (getPass ($user) == $pass);
}
function setPass ($user, $pass) {
    $pass = md5 ($pass);
    mysql_query ("UPDATE Users SET password = '$pass' WHERE username = '$user'");
}

function userGetColumn ($user, $col) {
    $row = getUser ($user);
    return $row["$col"];
}

function userSetColumn ($user, $val, $col) {
    $ok = mysql_query ("UPDATE Users SET $col = '$val' WHERE username = '$user'");    
}


//User URL display
//edit STYLE userURL
function getColor ($rating) {
    //EDIT
    return '#888';
}
function getUserURL ($user) {
    $row = getUser ($user);
    return "<a href = '/user/?name=$user'>$user</a>"; //CHANGECHANGE
}

//macro
function numActiveUsers () {
    $res = mysql_query ("SELECT * FROM Users WHERE isActive = 1");
    return mysql_num_rows ($res);
}

function login ($user, $length) {
    global $USER_COOKIE;
    debug ("Logging in $user for $length seconds");
    setcookie ("$USER_COOKIE", $user, time () + $length, "/");
    setcookie ("numSubmit", 0, time() - 3600, "/");

    header ("location: /redirect.php");
}
function logout ($user) {
    global $USER_COOKIE;
    setcookie ("$USER_COOKIE", "", time () - 3600, "/");
    header ("location: /redirect.php");
}
?>
