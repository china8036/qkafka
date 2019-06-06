<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Qqes\Kafka;

/**
 * Description of Consumer
 *
 * @author wang
 */
use RdKafka\Conf;
use RdKafka\Consumer as Kconsumer;
use RdKafka\TopicConf;
class Consumer extends Kafka {

    /**
     *
     * @var RdKafka\ConsumerTopic 
     */
    protected $con_topic;
    
    
    /**
     * partition
     * @var inter
     */
    protected $partition;

    public function __construct($brokers, $topic_nam, $partition) {
        parent::__construct();
        $this->partition = $partition;
        $conf = new Conf();

// Set the group id. This is required when storing offsets on the broker
        $conf->set('group.id', 'default');
        $conf->set('enable.auto.offset.store', 'false'); // disable auto store offset to memory 
        $rk = new Kconsumer($conf);
        $rk->addBrokers($brokers);

        $topicConf = new TopicConf();
        $topicConf->set('auto.commit.interval.ms', 2000);
        $topicConf->set('auto.offset.reset', 'smallest');

        $this->con_topic  = $rk->newTopic($topic_nam, $topicConf);

            
        // Start consuming partition 0
        $this->con_topic->consumeStart($this->partition, RD_KAFKA_OFFSET_STORED);
    }

    /**
     * 
     * @param type $partition
     * @param type $timeout
     * @throws \Exception
     */
    public function getMsg($timeout = 3000) {
        $message = $this->con_topic->consume($this->partition, $timeout);
        switch ($message->err) {
            case RD_KAFKA_RESP_ERR_NO_ERROR:
                if($message == null){
                    return null;
                }
                return new Message($message);
//            case RD_KAFKA_RESP_ERR__PARTITION_EOF:
//            case RD_KAFKA_RESP_ERR__TIMED_OUT:
//                throw new Exception($message->errstr(), $message->err);
            default:
                throw new Exception($message->errstr(), $message->err);
        }
    }

    /**
     * 
     * @param \Qqes\Kafka\Message $message
     */
    public function done(Message $message){
         $this->con_topic->offsetStore($message->partition, $message->offset); 
    }
}
