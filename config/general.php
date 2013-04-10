<?php
define('CHARSET', 'utf-8');
define('DB_CHARSET', 'utf8');
define('SALT', 'yourrandomsalt');
define('IP', $_SERVER['SERVER_ADDR']);
define('DNS', $_SERVER['HTTP_HOST']);

if ($_SERVER['HTTPS'] === 'on') {
  define('SCHEME', 'https://');
} else {
  define('SCHEME', 'http://');
}

define('DOMAIN_ROOT', SCHEME . 'localhost');

if (php_sapi_name() != 'cli') {
  define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
} else {
  define('DOCUMENT_ROOT', $_SERVER['PWD'] . DOMAIN_ROOT);
}

define('SITE_EMAIL', 'info@yourdomain.tld');

#Global database settings
define('DB_HOST', 'localhost'); #Change if not on a localhost
define('DB_USER', 'root'); #Change this to your mysql user
define('DB_PASS', ''); #Change this to your mysql user password
define('DB_DATA', 'minecraft'); #Change this to your minecraft database

#Mail server settings
define('MAIL_HOST', 'localhost'); #Change if not on a localhost
define('MAIL_USER', 'root'); #Change this to your email user
define('MAIL_PASS', ''); #Change this to your email user password
define('MAIL_PORT', '25'); #Change this if you dont use default port