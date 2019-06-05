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
use RdKafka\Message;
class Message extends Message {

    public $err;
    public $topic_name;
    public $partition;
    public $payload;
    public $key;
    public $offset;

}
