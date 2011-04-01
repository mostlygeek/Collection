<?php
/**
 * Transitions files from the work/ to the process state. Design to be run
 * in a continuous daemon (daemontools) and wakes up and works every
 * minute or so. 
 *
 * Rules:
 *
 *  1. Force is on.
 *  2. First record in file > 1HR
 *  3. File is > 100MB (uncompressed)
 */

require_once('_include.php');
echo "Processing work -> process\n";

$tz = new DateTimeZone('UTC');
$now = new DateTime('now', $tz);
$nowts = $now->getTimestamp();

if (!file_exists(WORK_FILE)) {
    echo "  -- No Work file. Skip.\n";
    goto END; 
}

$force = true; 
if ($force) {
    echo "  -- Force Mode\n";
    goto MOVE; 
}

if (filesize(WORK_FILE) >= MB_100) {
    echo "  -- > 100MB\n";
    goto MOVE;
}

// Check if first record > 1HR
$fp = fopen($filename, 'r'); // just for reading
$line = fgets($fp);

$data = json_decode($line, true);
if ($data) {
    if (isset($data['ts'])) {
        $timestamp = intval($data['ts']);
        $age = $nowts - $timestamp;
        if ($age > 3600) {
            echo "  -- First Record > 1Hr\n";
            goto MOVE;
        }
    }
}

GOTO END;

/**
 * MOVE ACTION ... 
 */
MOVE:
$newname = ROOT_DIR . '/data/process/collection-'.$nowts.'.txt';
rename(WORK_FILE, $newname);

/**
 * Finished.
 */
END: