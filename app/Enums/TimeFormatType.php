<?php

namespace App\Enums;

enum TimeFormatType : string
{
    /* This enum saves the values for the time format, 
    choosen by the user to be displayed */
    case TwelveHours = "12H";
    case TwentyFourHours = "24H";

}
