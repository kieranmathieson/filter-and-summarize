<?php

namespace FilterAndSummarize;

/**
 * Class Message
 *
 * Represents a singme message sent through the company message system.
 *
 * @package FilterAndSummarize
 */
class Message {
    /**
     * Message id.
     * @var int
     */
    protected $messageId;

    /**
     * Id of the user who sent the message.
     * @var int
     */
    protected $userId;

    /**
     * Id of the channel the message was sent over.
     * @var int
     */
    protected $channelId;

    /**
     * When the message was sent. Timestamp.
     * @var int
     */
    protected $when;

    /**
     * The message.
     * @var string
     */
    protected $content;

    /**
     * Message constructor.
     * @param string $data Concatenated fields, comma separated.
     * @throws \Exception if there is bad data.
     */
    public function __construct($data ) {
        if ( is_string($data) ) {
            //Remove extra spaces and new lines.
            $data = trim($data);
            //Separate the data into fields.
            $fields = explode(',', $data);
            //Right number of fields?
            if ( sizeof($fields) != 5 ) {
                throw new \Exception("Missing data in record: $data");
            }
            //Set the properties. setX will throw an exception if there's a problem.
            $this->setMessageId( $fields[0] );
            $this->setUserId( $fields[1] );
            $this->setWhen( $fields[2] );
            $this->setChannelId( $fields[3] );
            $this->setContent( $fields[4] );
        }
        else {
            throw new \Exception("Unknown message format");
        }
    }

    /**
     * Set the message id.
     * @param int $id The message id.
     * @throws \Exception if param not a valid id.
     */
    public function setMessageId($id) {
        if ( ! Message::hasValidIdFormat($id) ) {
            throw new \Exception("Bad message id: $id");
        }
        $this->messageId = $id;
    }

    /**
     * Get the message id.
     * @return int The message id.
     */
    public function getMessageId() {
        return $this->messageId;
    }

    /**
     * Set the user id.
     * @param int $id The user id.
     * @throws \Exception if param not a valid id.
     */
    public function setUserId($id) {
        if ( ! Message::hasValidIdFormat($id) ) {
            throw new \Exception("Bad user id: $id");
        }
        $this->userId = $id;
    }

    /**
     * Get the user id.
     * @return int The user id.
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * Set the channel id.
     * @param int $id The channel id.
     * @throws \Exception if param not a valid id.
     */
    public function setChannelId($id) {
        if ( ! Message::hasValidIdFormat($id) ) {
            throw new \Exception("Bad channel id: $id");
        }
        $this->channelId = $id;
    }

    /**
     * Get the channel id.
     * @return int The channel id.
     */
    public function getChannelId() {
        return $this->channelId;
    }

    /**
     * Does a value have the format of a valid id?
     * @param mixed $toCheck The value to check.
     * @return bool True if the value is a valid id, else false.
     */
    public static function hasValidIdFormat($toCheck) {
        return $toCheck != '' && is_numeric($toCheck) && $toCheck > 0;
    }

    /**
     * Set the date/time the mssage was sent.
     * @param string $when When the message was sent.
     * @throws \Exception if the string does not represent a valid date/time.
     */
    public function setWhen($when) {
        $temp = strtotime($when);
        if ( ! $temp ) {
            throw new \Exception("Bad message time: $when");
        }
        $this->when = $temp;
    }

    /**
     * Get when the message was sent.
     * @return int When the message was sent, as a timestamp.
     */
    public function getWhen() {
        return $this->when;
    }

    /**
     * Set the content of the message.
     * @param string $content The content.
     */
    public function setContent($content) {
        //Make all forms of no content (e.g., FALSE) into an MT string.
        if ( ! $content ) {
            $content = '';
        }
        //If first and last chars are quotes, strip them off.
        $content = preg_replace('/^(\'|")(.*)(\'|")$/', '$2', $content);
        $this->content = $content;
    }

    /**
     * Get the content of the message.
     * @return string The content.
     */
    public function getContent() {
        return $this->content;
    }

}
