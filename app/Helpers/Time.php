<?php

/**
 * Time helper
 *
 * @param $seconds
 *
 * @return $seconds
 */

function seconds_to_words($seconds)
{
    $ret = "";

    /*** get the days ***/
    $days = intval(intval($seconds) / (3600*24));
    if($days> 0)
    {
        $ret .= "$days days ";
    }

    /*** get the hours ***/
    $hours = (intval($seconds) / 3600) % 24;
    if($hours > 0)
    {
        $ret .= "$hours hours ";
    }

    /*** get the minutes ***/
    $minutes = (intval($seconds) / 60) % 60;
    if ($minutes < 10) {
        $ret .= "0$minutes:";
    } else {
        $ret .= "$minutes:";
    }

    /*** get the seconds ***/
    $seconds = intval($seconds) % 60;
    if ($seconds < 10) {
        $ret .= "0$seconds";
    } else {
        $ret .= "$seconds";
    }

    return $ret;
}
