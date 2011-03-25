<?php
require_once('../libs/Socket/Beanstalk.php');
$bean = new Socket_Beanstalk();
$bean->watch('writer');
while (true) {    
    $job = $bean->reserve();
    //echo "ID: $job[id]\n";
    echo '.';
    $bean->delete($job['id']);
}