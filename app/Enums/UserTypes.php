<?php

namespace App\Enums;

enum UserTypes: string 
{

    /*These are the different selections for the user type, basic = to a simple account limited 
    on funtions and premium for a full functionality account*/
    case Basic = "basic";
    case Premium = "premium";
    case Admin = "admin";

}
