<?php
header('Content-Type: text/plain');

$tz = new DateTimeZone('UTC');
$now = new DateTime('now', $tz);

$record = array();
$record['ip'] = $_SERVER['REMOTE_ADDR'];
$record['ts'] = $now->getTimestamp();
if (!empty($_REQUEST)) {
    $record['d'] = $_REQUEST;
}

$str = json_encode($record);

$fp = fopen('../data/work/collection.txt', 'a');
if (!$fp) {
    die("0");
}
fwrite($fp, "$str\n");
fclose($fp);

echo 1;