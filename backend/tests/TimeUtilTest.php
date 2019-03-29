<?php

use App\Utils\TimeUtil;

class TimeUtilTest extends TestCase
{
    /**
     * @return array
     */
    public function timeDataProvider() {
        return array(
            array(
                array(
                    'start_time' => DateTime::createFromFormat('Y-m-d H:i:s', '2020-01-01 00:00:00'),
                    'end_time' => DateTime::createFromFormat('Y-m-d H:i:s', '2020-01-01 01:00:00'),
                ),
                array(
                    'start_time' => DateTime::createFromFormat('Y-m-d H:i:s', '2020-01-01 02:00:00'),
                    'end_time' => DateTime::createFromFormat('Y-m-d H:i:s', '2020-01-01 03:00:00'),
                ),
                false
            ),
            array(
                array(
                    'start_time' => DateTime::createFromFormat('Y-m-d H:i:s', '2020-01-01 00:00:00'),
                    'end_time' => DateTime::createFromFormat('Y-m-d H:i:s', '2020-01-01 01:00:00'),
                ),
                array(
                    'start_time' => DateTime::createFromFormat('Y-m-d H:i:s', '2020-01-01 00:30:00'),
                    'end_time' => DateTime::createFromFormat('Y-m-d H:i:s', '2020-01-01 01:30:00'),
                ),
                true
            ),
        );
    }

    /**
     * Tests time overlapping detection function
     *
     * @dataProvider timeDataProvider
     * @param $time1
     * @param $time2
     * @param boolean $expected
     */
    public function testAddDocument($time1, $time2, $expected) {
        $this->assertSame(
            TimeUtil::testRange($time1['start_time'], $time1['end_time'], $time2['start_time'], $time2['end_time']),
            $expected
        );
    }
}
