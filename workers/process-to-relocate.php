<?php
require('_include.php');
/**
 * Bzips, renames and puts files into relocate/ so they can be
 * copied to Amazon's S3.
 *
 * New file names: collection-{ts}-{uniqid}.bz2
 */

// Create a unique ID for the machine (in case of clustering)
$files = glob(ROOT_DIR . '/data/process/collection*.txt');
foreach ($files as $file) {
    $newFile = 'collection-'.nowTS().'-'.uniqid().'.bz2';
    echo "Processing: $file to $newFile\n";

}

