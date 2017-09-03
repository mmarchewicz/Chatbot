<?php
require_once __DIR__ . '/vendor/autoload.php';

use mmarchewicz\chatbot\ChatBot;

/**
* Obtain data from Facebook and setup variables $hubVerifyToken and $accessToken
* Read readme file for full instalation process
*/
$hubVerifyToken = '';
$accessToken = '';

$bot = new ChatBot($hubVerifyToken, $accessToken);
$bot->init();