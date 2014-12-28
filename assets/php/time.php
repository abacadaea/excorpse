<?php
function getTimeText ($time) { //check
    return date ('M d Y H:i', $time);
}

function timeDiffText ($number, $text) {
    $s = ($number > 1 ? "s" : "");
    return "$number $text$s ago";
}

function timeDiffDisplay ($time) {
    $sec = $time % 60; 
    $time /= 60;

    $min = $time % 60;
    $time /= 60;

    $hour = $time % 24;
    $time /= 24;

    $day = $time % 30;
    $time /= 30;

    $month = $time % 12;
    $time /= 12;

    $year = floor ($time);

    if ($year > 0) //CHECK
	return timeDiffText ($year, "year");
    else if ($month > 0)
	return timeDiffText ($month, "month");
    else if ($day > 0)
	return timeDiffText ($day, "day");
    else if ($hour > 0)
	return timeDiffText ($hour, "hour");
    else if ($min > 0)
	return timeDiffText ($min, "minute");
    //else if ($sec > 10)
	//return timeDiffText ($sec, "second");
    else
	return "Just now";
}
?>
