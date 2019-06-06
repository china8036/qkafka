<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include '../src/Kafka.php';
include '../src/Exception.php';
include '../src/Message.php';
include '../src/Consumer.php';
include '../src/Producer.php';

$producer = new Qqes\Kafka\Producer('192.168.1.200', 'test');

$i = 0;
while(true){
    $producer->queue('test:' . time(), $i++);
    $producer->queueCall('Qqes\Test', 'call', ['test' . time()]);
    sleep(1);
}