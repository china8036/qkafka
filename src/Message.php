<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Qqes\Kafka;

/**
 * Description of Message
 *
 * @author wang
 */
use RdKafka\Message as Kmessage;

class Message {

    public $partition;
    public $payload;
    public $key;
    public $offset;

    function __construct(Kmessage $message) {
        $this->partition = $message->partition;
        $this->payload = $message->payload;
        $this->key = $message->key;
        $this->offset = $message->offset;
    }

}
