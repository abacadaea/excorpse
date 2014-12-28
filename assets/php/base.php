<?php
//debugging
error_reporting(E_ALL);
//ini_set(‘display_errors’,0);

$KFACTOR = 16;
$USER_COOKIE = "ECuser";
$DEFAULT_LENGTH = 14;

$con;
//assumes location of included file is same as location of original
require_once($root.'/assets/PhpConsole.php');
PhpConsole::start();

function connect () {
    if ($_SERVER["SERVER_NAME"] == "localhost") {
	define("DB_SERVER", "localhost");
	define("DB_USER", "abacadaea");
	define("DB_PASS", "TopCoder123");
	define("DB_NAME", "excorpse1");
    }else {
	//remote server
	define("DB_SERVER", "mysql15.000webhost.com");
	define("DB_USER", "a7797993_admin");
	define("DB_PASS", "TopCoder123");
	define("DB_NAME", "a7797993_1");
	/*
	define("DB_SERVER", "mysql1.000webhost.com");
	define("DB_USER", "a2163234_admin");
	define("DB_PASS", "TopCoder123");
	define("DB_NAME", "a2163234_haicoo");
	*/
    }

    global $con;
    $con = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
    if (!$con){
	die('Could not connect: ' . mysql_error());
    }
    $success = mysql_select_db(DB_NAME, $con);
}

function isLoggedIn () {
    global $USER_COOKIE;
    return (isset ($_COOKIE[$USER_COOKIE]));
}

$validCharacters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_.,'\";:!? ";
$isValidCharacter = array (256);
function setIsValidCharacter () {
    global $validCharacters;
    global $isValidCharacter;
    for ($i = 0; $i < 256; $i ++)
	$isValidCharacter[$i] = false;
    for ($i = 0; $i < strlen ($validCharacters); $i ++)
	$isValidCharacter [ord ($validCharacters[$i])] = true;
}
function isValidInput ($str) {
    global $isValidCharacter;
    for ($i = 0; $i < strlen ($str); $i ++)
	if ($isValidCharacter [ord ($str [$i])] == false)
	    return false;
    
    return true;
}
function isValidRoom ($str) {
    for ($i = 0; $i < strlen ($str); $i ++) {
	$ord = ord ($str[$i]);
	if (ord ('0') <= $ord && $ord <= ord ('9'))
	    continue;
	if (ord ('a') <= $ord && $ord <= ord ('z'))
	    continue;
	if (ord ('A') <= $ord && $ord <= ord ('Z'))
	    continue;
	return false;
    }
    
    return true;
}


function errorMessage ($msg) {
    return "<div class = 'alert alert-error'> $msg </div>";
}
function successMessage ($msg) {
    return "<div class = 'alert alert-success'> $msg </div>";
}
function warningMessage ($msg) {
    return "<div class = 'alert alert-block'> $msg </div>";
}

function getRow ($table, $col, $val) {
    $res = mysql_query ("SELECT * FROM $table WHERE $col = '$val'");
    if ($res)
	return mysql_fetch_array ($res);
    else
	return null;
}

function setRow ($table, $col, $val, $col2, $val2) {
    //check
    mysql_query ("UPDATE $table SET $col = '$val' WHERE $col2 = '$val2'");
}

function delRow ($table, $col, $val) {
    //check
    mysql_query ("DELETE FROM $table WHERE $col = '$val'");
}

function incrementCol ($table, $col, $col2, $val2) {
    mysql_query ("UPDATE $table SET $col = $col + 1 WHERE $col2 = '$val2'");
}
function decrementCol ($table, $col, $col2, $val2) {
    mysql_query ("UPDATE $table SET $col = $col - 1 WHERE $col2 = '$val2'");
}

function updateRating ($table, $a, $b) {
    global $KFACTOR;

    $row1 = getRow ($table, "ID", $a);
    $row2 = getRow ($table, "ID", $b);

    $rat1 = $row1["rating"];
    $rat2 = $row2["rating"];

    $q1 = pow (10.0, $rat1 / 400.0);
    $q2 = pow (10.0, $rat2 / 400.0);

    $e1 = $q1 / ($q1 + $q2);
    $e2 = $q2 / ($q1 + $q2);

    $new1 = $rat1 + (1 - $e1) * $KFACTOR;
    $new2 = $rat2 + (0 - $e2) * $KFACTOR;

    debug ($new1, $new2);

    setRow ($table, "rating", $new1, "ID", $a); 
    setRow ($table, "rating", $new2, "ID", $b); 
}


setIsValidCharacter ();

connect ();

date_default_timezone_set('America/Los_Angeles');

?>
