<?php

namespace Qqes\Kafka;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Kafka
 *
 * @author wang
 */
class Kafka {

    const CLASS_KEY = 'class';
    const METHOD_KEY = 'method';
    const ARGS_KEY = 'args';

    //put your code here

    public function __construct() {
        if (!class_exists('\RdKafka\Conf')) {
            throw new Exception('Can not found rdkafka php extension, Please visit url https://github.com/arnaud-lb/php-rdkafka to install it');
        }
    }

}
