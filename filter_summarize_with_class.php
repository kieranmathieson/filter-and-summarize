<?php

namespace FilterAndSummarize;

require 'autoloader.php';

//Initialize accumulators.
$recordCount = 0;
$badRecords = 0; //Records with bad data of some kind.
//Ids of channels to track.
$channelsToTrack = [5, 13, 23];
//Create channels.
$channels = [];
try {
    foreach ($channelsToTrack as $channelId) {
        $channels[$channelId] = new Channel($channelId);
    }
} catch (\Exception $e) {
    exit("Problem defining channels: {$e->getMessage()}");
}
//Open the file for reading.
$handle = fopen('messages.csv', 'r');
while ( ! feof($handle)) {
    //Read a record as a single string.
    $record = fgets($handle);
    $recordCount++;
    try {
        //Create a message object.
        $message = new Message($record);
        //Is the message in a tracked channel?
        if (in_array($message->getChannelId(), $channelsToTrack)) {
            $channels[$message->getChannelId()]->recordMessage($message);
        }
    } catch (\Exception $e) {
        $badRecords++;
    }
}
//Close the data file.
fclose($handle);
//Show the output.
print "Number of records: $recordCount\n";
print "Number of bad records: $badRecords\n";
foreach ($channels as $channel) {
    print "-----\n";
    print "Channel {$channel->getId()}\n";
    print "  Number of messages: {$channel->getNumMessages()}\n";
    print "  Average message length: {$channel->getAverageMessageLength()}\n";
}
