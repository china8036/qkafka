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
use RdKafka\Producer;
use RdKafka\TopicConf;
class Producer extends Kafka {

    /**
     * pro_topic
     * @var RdKafka\ProducerTopic
     */
    protected $pro_topic;
    
    
    public function __construct($brokers, $topic_name) {
        parent::__construct();
        $conf = new Conf();
        $rk = new Producer($conf);
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
    public function queue($msg, $partition = 0){
       return  $this->pro_topic->produce($partition, 0, $msg);
    }

}