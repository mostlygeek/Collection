<?php

define('ROOT_DIR', realpath('../'));
define('WORK_FILE', ROOT_DIR . '/data/work/collection.txt');
define('MB_100', 100 * 1024 * 1024);

/**
 * Returns the TimeStamp for now
 * @return int
 */
function nowTS()
{
    $tz = new DateTimeZone('UTC');
    $time = new DateTime('now', $tz);
    return $time->getTimestamp();
}