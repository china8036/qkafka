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
$msg = $cousunmer->getMsg();
var_dump($msg);
$cousunmer->done($msg);