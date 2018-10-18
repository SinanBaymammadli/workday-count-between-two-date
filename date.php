<?php

//The function returns the num. of business days between two dates and it skips the holidays
// returns integer
function getWorkDaysCount($startDate, $endDate, $holidays)
{
    // do strtotime calculations just once
    $endDate = strtotime($endDate);
    $startDate = strtotime($startDate);

    //The total number of days between the two dates. We compute the num. of seconds and divide it to 60*60*24
    //We add one to inlude both dates in the interval.
    $days = ($endDate - $startDate) / (60 * 60 * 24) + 1;

    $num_full_weeks = floor($days / 7);
    $num_remaining_days = fmod($days, 7);

    //It will return 1 if it's Monday,.. ,7 for Sunday
    $the_first_day_of_week = date("N", $startDate);
    $the_last_day_of_week = date("N", $endDate);

    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
    if ($the_first_day_of_week <= $the_last_day_of_week) {
        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) {
            $num_remaining_days--;
        }

        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) {
            $num_remaining_days--;
        }

    } else {
        // (edit by Tokes to fix an edge case where the start day was a Sunday
        // and the end day was NOT a Saturday)

        // the day of the week for start is later than the day of the week for end
        if ($the_first_day_of_week == 7) {
            // if the start date is a Sunday, then we definitely subtract 1 day
            $num_remaining_days--;

            if ($the_last_day_of_week == 6) {
                // if the end date is a Saturday, then we subtract another day
                $num_remaining_days--;
            }
        } else {
            // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
            // so we skip an entire weekend and subtract 2 days
            $num_remaining_days -= 2;
        }
    }

    //The num. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
    //---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
    $workingDays = $num_full_weeks * 5;
    if ($num_remaining_days > 0) {
        $workingDays += $num_remaining_days;
    }

    //We subtract the holidays
    foreach ($holidays as $holiday) {
        $holiday_time = strtotime($holiday);
        //If the holiday doesn't fall in weekend
        if ($startDate <= $holiday_time && $holiday_time <= $endDate && date("N", $holiday_time) != 6 && date("N", $holiday_time) != 7) {
            $workingDays--;
        }

    }

    return $workingDays;
}

// get dates from POST
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];

// set holidays
$holidays = [
    "2018-10-04",
    "2018-10-12",
    "2018-10-17",
];

// get num. of work days
$numberOfDays = getWorkDaysCount($startDate, $endDate, $holidays);

// set SESSION variables
session_start();
$_SESSION["startDate"] = $startDate;
$_SESSION["endDate"] = $endDate;
$_SESSION["numberOfDays"] = $numberOfDays;

// redirect to /
header("Location: /");
