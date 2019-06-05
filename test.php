<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$ext = '{"orderId":"GPA.3381-4204-1684-98784","packageName":"com.witgame.thyj","productId":"com.thyj.300","purchaseTime":1535465247245,"purchaseState":0,"developerPayload":"FX0-20180828220711-00233580","purchaseToken":"hdfhkpbdacffkbcmkeogfipk.AO-J1OzbbQ6aYqHveok0iqdZ1kl3b5CBpsvkCCsAUW4LgmCZMQcUZQowTOrHU2HFlWJiyMTVnreNHl9V7ipCHU5MykFbhhPJoA2SUz6IstVhOIjkqrRDtq8"}';
$extArray = json_decode($ext, true);
echo json_encode($extArray);