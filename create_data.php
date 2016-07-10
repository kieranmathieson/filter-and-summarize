<?php
/**
 * Created by PhpStorm.
 * User: kieran
 * Date: 7/9/16
 * Time: 1:23 PM
 */
exit();
$numRecords = 1000;
$channels = [2, 3, 7, 5, 11, 13, 17, 19, 23];

$handle = fopen('messages.csv', 'w');
$recordCounter = 0;
$minTimeStamp = time();
$maxTimeStamp = $minTimeStamp + 2592000;
while ($recordCounter < $numRecords) {
    $messageId = rand(1024, 8192);
    $userId = rand(128, 256);
    $whenTimestamp = rand($minTimeStamp, $maxTimeStamp);
    $when = date(DATE_ISO8601, $whenTimestamp);
    $channel = $channels[rand(0, sizeof($channels) - 1)];
    $message = str_repeat('a ', rand(4, 128));
    fwrite($handle, $messageId . ',' . $userId . ',' . $when . ',' . $channel . ',\'' . $message . "'\n");
    $recordCounter++;
}
fclose($handle);


