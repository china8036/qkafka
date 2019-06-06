<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Qqes\Kafka;

/**
 * Description of Producer
 *
 * @author wang
 */
use RdKafka\Conf;
use RdKafka\Producer as Kproducer;
use RdKafka\TopicConf;
class Producer extends Kafka {

    /**
     * pro_topic
     * @var RdKafka\ProducerTopic
     */
    protected $pro_topic;
    
    
    /**
     * 
     * @param type $brokers
     * @param type $topic_name
     */
    public function __construct($brokers, $topic_name) {
        parent::__construct();
        $conf = new Conf();
        $rk = new Kproducer($conf);
        $rk->setLogLevel(LOG_DEBUG);
        $rk->addBrokers($brokers);

        $cf = new TopicConf();
        
        // -1必须等所有brokers同步完成的确认 1当前服务器确认 0不确认，这里如果是0回调里的offset无返回，如果是1和-1会返回offset
        // 我们可以利用该机制做消息生产的确认，不过还不是100%，因为有可能会中途kafka服务器挂掉
        $cf->set('request.required.acks', 1);
        $this->pro_topic =  $rk->newTopic($topic_name, $cf);
    }
    
    /**
     * add msd to queue
     * @param type $msg
     * @return type
     */
    public function queue($msg, $key = null, $partition = 0){
        if(is_array($msg)){
            $msg = serialize($msg);
        }
       return  $this->pro_topic->produce($partition, 0, $msg, $key);
    }
    
    /**
     * 
     * @param string $class
     * @param string $method
     * @param mix $args
     * @param inter $partition
     * @return type
     */
    public function queueCall($class, $method, $args, $key = null, $partition = 0){
        return $this->queue([Kafka::CLASS_KEY => $class, Kafka::METHOD_KEY => $method, Kafka::ARGS_KEY => $args], $key, $partition);
    }

}
