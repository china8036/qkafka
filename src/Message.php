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
    protected $call_params;

    function __construct(Kmessage $message) {
        $this->partition = $message->partition;
        $this->payload = $message->payload;
        $this->key = $message->key;
        $this->offset = $message->offset;
    }

    /**
     * 
     * @return type
     * @throws Exception
     */
    public function getClass() {
        $this->initCallMsg();
        if (!isset($this->call_params[Kafka::CLASS_KEY])) {
            throw new Exception('Can not caller class:' . $this->payload);
        }
        return $this->call_params[Kafka::CLASS_KEY];
    }

    /**
     * 
     * @return type
     * @throws Exception
     */
    public function getMethod() {
        $this->initCallMsg();
        if (!isset($this->call_params[Kafka::METHOD_KEY])) {
            throw new Exception('Can not caller method:' . $this->payload);
        }
        return $this->call_params[Kafka::METHOD_KEY];
    }

    /**
     * 
     * @return type
     */
    public function getArgs() {
        $this->initCallMsg();
        if (!isset($this->call_params[Kafka::ARGS_KEY])) {
            return [];
        }
        return $this->call_params[Kafka::ARGS_KEY];
    }

    /**
     * init call msg
     * @return type
     * @throws Exception
     */
    private function initCallMsg() {
        if (is_array($this->call_params)) {
            return;
        }
        $this->call_params = unserialize($this->payload);
        if ($this->call_params === false) {
            throw new Exception('payload can not be un serialize:' . $this->payload);
        }
    }

}
