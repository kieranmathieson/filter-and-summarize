<?php
//Open the file for reading.
$handle = fopen('messages.csv', 'r');
//Initialize accumulators.
$recordCount = 0;
$badRecords = 0; //Records with bad data of some kind.
$numMessages = array( 5 => 0, 13 => 0, 23 => 0 ); //Number of messages for the three channels.
$messageTotalLength = array( 5 => 0, 13 => 0, 23 => 0 ); //Message length totals for the channels.
while ( ! feof($handle)) {
    //Read a record as a single string.
    $record = fgets($handle);
    $recordCount++;
    //Parse the record into fields.
    $recordOK = parseRecord($record, $messageId, $userId, $when, $channelId, $message);
    if ( ! $recordOK ) {
        $badRecords++;
    }
    else {
        //Accumulate data about the three channels.
        if ( $channelId == 5 || $channelId == 13 || $channelId == 23 ) {
            $numMessages[$channelId]++;
            $messageTotalLength[$channelId] += strlen($message);
        }
    }
}
//Close the data file.
fclose($handle);
//Compute means.
$avMessageLengthCh5 = $messageTotalLength[5] / $numMessages[5];
$avMessageLengthCh13 = $messageTotalLength[13] / $numMessages[13];
$avMessageLengthCh23 = $messageTotalLength[23] / $numMessages[23];
//Show the output.
print "Number of records: $recordCount\n";
print "Number of bad records: $badRecords\n";
print "-----\n";
print "Channel 5\n";
print "  Number of messages: $numMessages[5]\n";
print "  Average message length: $avMessageLengthCh5\n";
print "-----\n";
print "Channel 13\n";
print "  Number of messages: $numMessages[13]\n";
print "  Average message length: $avMessageLengthCh13\n";
print "-----\n";
print "Channel 23\n";
print "  Number of messages: $numMessages[23]\n";
print "  Average message length: $avMessageLengthCh23\n";
//Done! Celebrate.

//Parse an input record. Break it into fields, and check for errors.
//Return TRUE if the data is OK, FALSE if not.
function parseRecord( $record, &$messageId, &$userId, &$when, &$channelId, &$message ) {
    //Split record into fields.
    $fields = explode(',', $record);
    //Should be five fields.
    if ( sizeof($fields) != 5 ) {
        return FALSE;
    }
    //Put fields into variables.
    $messageId = $fields[0];
    $userId = $fields[1];
    $when = $fields[2];
    $channelId = $fields[3];
    $message = $fields[4];
    //Check data types.
    if ( ! is_numeric($messageId) || ! is_numeric($userId) || ! is_numeric($channelId) || ! strtotime($when) ) {
        return FALSE;
    }
    //The record has past all the tests.
    return TRUE;
}
