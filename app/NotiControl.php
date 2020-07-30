<?php

namespace App;

use App\Logics\DateFormatter;

class NotiControl
{
    public static function getTime($value)
    {
        $d=new DateFormatter(strtotime($value));
        return $d->getFormattedTime();
    }

  
}
