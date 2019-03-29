<?php

namespace App\Utils;

class TimeUtil
{
    static public function testRange($start_time1, $end_time1, $start_time2, $end_time2)
    {
        return ($start_time1 <= $end_time2 && $start_time2 <= $end_time1);
    }
}
