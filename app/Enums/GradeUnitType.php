<?php

namespace App\Enums;

enum GradeUnitType : string
{

    /* These are the options for the preference of unit grade that the user want to use */
    case Farenheight = "°F";
    case Celsious = "°C";
    case Kelvin = "°K";

}
