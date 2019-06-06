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

$cousunmer = new Qqes\Kafka\Consumer('192.168.1.200', 'test', 0);
while (true) {
    try{
        $msg = $cousunmer->getCallMsg();
        echo $msg->getClass() . "\r\n";
        echo $msg->getMethod() . "\r\n";
        var_dump($msg->getArgs());
    }catch(\Exception $e){
        echo $e->getMessage() . "\r\n";
    }
    //something to do
    
    //all done
    $cousunmer->done($msg);
}