<?php


$conf = new RdKafka\Conf();

// Set the group id. This is required when storing offsets on the broker
$conf->set('group.id', 'default');
$conf->set('enable.auto.offset.store', 'false');// disable auto store offset to memory 
$rk = new RdKafka\Consumer($conf);
$rk->addBrokers('192.168.1.200');

$topicConf = new RdKafka\TopicConf();
$topicConf->set('auto.commit.interval.ms', 2000);
//$topicConf->set('consume.callback.max.messages', 1);

// Set the offset store method to 'file'
// $topicConf->set('offset.store.method', 'file');
// $topicConf->set('offset.store.path', sys_get_temp_dir());

// Alternatively, set the offset store method to 'broker'
//$topicConf->set('offset.store.method', 'broker');
//$topicConf->set('auto.commit.enable', 'false');//commit memory to file or broker

// Set where to start consuming messages when there is no initial offset in
// offset store or the desired offset is out of range.
// 'smallest': start from the beginning
$topicConf->set('auto.offset.reset', 'smallest');

$topic = $rk->newTopic('test', $topicConf);

$partition = 0;
// Start consuming partition 0
$topic->consumeStart($partition, RD_KAFKA_OFFSET_STORED);

while (true) {
    $message = $topic->consume($partition, 3 * 1000);
    switch ($message->err) {
        case RD_KAFKA_RESP_ERR_NO_ERROR:
            echo time() . ":receive\r\n";
            var_dump($message);
            $topic->offsetStore($message->partition, $message->offset);//
            //$topic
            break;
        case RD_KAFKA_RESP_ERR__PARTITION_EOF:
        case RD_KAFKA_RESP_ERR__TIMED_OUT:
            echo $message->errstr() . PHP_EOL;
            break;
        default:
            throw new \Exception($message->errstr(), $message->err);
            break;
    }
}