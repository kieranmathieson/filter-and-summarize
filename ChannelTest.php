<?php
/**
 * Created by PhpStorm.
 * User: kieran
 * Date: 7/10/16
 * Time: 3:57 PM
 */

namespace FilterAndSummarize;

require 'autoloader.php';

class ChannelTest extends \PHPUnit_Framework_TestCase {
    public function testChannelCreation() {
        $channel = new Channel(5);
        $this->assertEquals( $channel->getId(), 5);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Bad channel id
     */
    public function testBadMessageId() {
        $channel = new Channel('DOG');
    }

    public function testDataAccumulation() {
        $record = '2749,222,2016-08-03T13:29:15-0400,17,\'123456\'';
        $m1 = new Message($record);
        $record = '7349,323,2016-08-03T13:29:15-0410,17,\'1234\'';
        $m2 = new Message($record);
        $channel = new Channel(17);
        $channel->recordMessage($m1);
        $channel->recordMessage($m2);
        $this->assertEquals( $channel->getNumMessages(), 2 );
        $this->assertEquals( $channel->getAverageMessageLength(), 5 );
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Channel.RecordMessage expects a Message object
     */
    public function testBadMessageObject() {
        $channel = new Channel(17);
        //Next line should throw.
        $channel->recordMessage(new Channel(9));
    }

}
