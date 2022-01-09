<?php

namespace App\Service;

class Slugify
{

    function generate($str)
    {
        str_replace(' ', '-', $str);
    }
}
