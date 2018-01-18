<?php 
//MQ config
$config['mq']['server'] = '10.0.1.187';
$config['mq']['port'] = '5672';
$config['mq']['user'] = 'pushsystem';
$config['mq']['password'] = 'Push123!@#';

//MQ chat config
$config['mq']['payment_mq_exchange'] = '';
$config['mq']['payment_mq_routing'] = 'IOSQUEUEIN';
