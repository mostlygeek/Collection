<?php

require('../libs/Socket/Beanstalk.php');

$FILENAME = '/tmp/collector.txt';
$useBeanstalk = false;

header('Content-Type: text/plain');

$tz = new DateTimeZone('UTC');
$now = new DateTime('now', $tz);

$record = array();
$record['s'] = $_SERVER['REMOTE_ADDR'];
$record['ts'] = $now->getTimestamp();
$record['d'] = $_REQUEST;

$str = json_encode($record);


if ($useBeanstalk) {
    $bean = new Socket_Beanstalk();
    if ($bean->connect() !== true) {
        die("no beanstalk");
    }
    $bean->useTube('writer');
    $jobId = $bean->put(0, 0, 10, $str);
    echo "Job ID: $jobId\n";
    
} else {
    $fp = fopen('/tmp/collector-test.txt', 'a');
    if (!$fp) {
        die("0");
    }
    fwrite($fp, "$str\n");
    fclose($fp);
}

echo 1;