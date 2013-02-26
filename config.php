<?php
#Minecraft server settings
define('MQ_SERVER_ADDR', 'localhost');
define('MQ_SERVER_PORT', 25575);
define('MQ_SERVER_PASS', 'localhost');
define('MQ_TIMEOUT', 2);

#Global database settings
define('DB_HOST', 'localhost'); #Change if not on a localhost
define('DB_USER', 'root'); #Change this to your mysql user
define('DB_PASS', ''); #Change this to your mysql user password
define('DB_DATA', 'minecraft'); #Change this to your minecraft database

#Hawkeye table settings
define('HE_PLAYER_TABLE', 'hawk_players');
define('HE_WORLD_TABLE', 'hawk_worlds');
define('HE_LOG_TABLE', 'hawkeye');

#Mcbans API
define('MCBANS_API', '');

#PATH settings
if ($_SERVER['HTTPS'] === 'on') {
  define('SCHEME', 'https://');
} else {
  define('SCHEME', 'http://');
}

define('IP', $_SERVER['SERVER_ADDR']);
define('DNS', $_SERVER['HTTP_HOST']);
define('DOMAIN_ROOT', SCHEME . 'dev.kortingscode2013.nl');

if (php_sapi_name() != 'cli') {
  define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT'] . '');
} else {
  define('DOCUMENT_ROOT', $_SERVER['PWD'] . DOMAIN_ROOT);
}
define('CORE_PATH', DOCUMENT_ROOT . '/core/');
define('CHARSET', 'UTF-8');