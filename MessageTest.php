<?php
/**
 * Created by PhpStorm.
 * User: kieran
 * Date: 7/10/16
 * Time: 2:52 PM
 */

namespace FilterAndSummarize;

require 'autoloader.php';

class MessageTest extends \PHPUnit_Framework_TestCase {
    public function testValidMessageCreation() {
        $record = '2749,222,2016-08-03T13:29:15-0400,17,\'123456\'';
        $m = new Message($record);
        $this->assertEquals( $m->getMessageId(), 2749);
        $this->assertEquals( $m->getUserId(), 222);
        $this->assertEquals( $m->getWhen(), strtotime('2016-08-03T13:29:15-0400'));
        $this->assertEquals( $m->getChannelId(), 17);
        $this->assertEquals( $m->getContent(), '123456');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Bad message id
     */
    public function testBadMessageId() {
        $record = '2DOG749,222,2016-08-03T13:29:15-0400,17,\'123456\'';
        $m = new Message($record);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Bad user id
     */
    public function testBadUserId() {
        $record = '2749,22DOG2,2016-08-03T13:29:15-0400,17,\'123456\'';
        $m = new Message($record);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Bad message time
     */
    public function testBadWhen() {
        $record = '2749,222,201DOG6-08-03T13:29:15-0400,17,\'123456\'';
        $m = new Message($record);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Bad channel id
     */
    public function testBadChannelId() {
        $record = '2749,222,2016-08-03T13:29:15-0400,1DOG7,\'123456\'';
        $m = new Message($record);
    }

}
