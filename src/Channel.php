<?php

namespace FilterAndSummarize;

/**
 * Class Channel
 *
 * Represents a channel in the company message system.
 *
 * @package FilterAndSummarize
 */
class Channel {
    /**
     * Channel id.
     * @var int
     */
    protected $id = 0;

    /**
     * Number of messages sent.
     * @var int
     */
    protected $numMessagesSent = 0;

    /**
     * Total characters in the messages sent in this channel.
     * @var int
     */
    protected $totalCharsSent = 0;

    /**
     * Channel constructor.
     * @param int $id Channel id.
     */
    public function __construct($id) {
        if ( $id ) {
            $this->setId($id);
        }
    }

    /**
     * Get the channel id.
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set the channel id.
     * @param int $id Channel id.
     * @throws \Exception if the param is not a positive integer.
     */
    public function setId($id) {
        if ( $id == '' || ! is_numeric($id) || $id < 0 ) {
            throw new \Exception("Bad channel id: " . $id);
        }
        $this->id = $id;
    }

    /**
     * Record a message sent on the channel.
     * @param Message $message Message sent.
     * @throws \Exception if the parameter is not a Message.
     */
    public function recordMessage($message) {
        if ( get_class($message) != 'FilterAndSummarize\\Message' ) {
            throw new \Exception("Channel.RecordMessage expects a Message object: " . get_class($message));
        }
        $this->numMessagesSent++;
        $this->totalCharsSent += strlen( $message->getContent() );
    }

    /**
     * Get the number of messages sent in the channel.
     * @return int Number of messages.
     */
    public function getNumMessages() {
        return $this->numMessagesSent;
    }

    /**
     * Get the average length of messages sent in the channel.
     * @return float|int Average message length.
     */
    public function getAverageMessageLength() {
        //Don't divide by 0 if no messages recorded.
        if ( $this->numMessagesSent == 0 ) {
            return 0;
        }
        return $this->totalCharsSent/$this->numMessagesSent;
    }
}
