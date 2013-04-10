<?php
/**
 * Created by Esbocreations
 * Date: 11-3-13
 * Time: 11:30
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Validator\Constraints as Assert;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/config/general.php';
require_once __DIR__ . '/../src/functions/general.php';
require_once __DIR__ . '/../src/functions/offers.php';
require_once __DIR__ . '/../src/functions/categories.php';


$app = new Silex\Application();
$app['debug'] = true;
$app->register(new Silex\Provider\TwigServiceProvider(), array(
  'twig.path' => __DIR__ . '/views',
  'twig.options' => array('autoescape' => false),
));

//Session handling
$app->register(new Silex\Provider\SessionServiceProvider());

//Form validator
$app->register(new Silex\Provider\ValidatorServiceProvider());

//Path generation
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());


//Error log
//$app->register(new Silex\Provider\MonologServiceProvider(), array(
//  'monolog.logfile' => __DIR__.'/log/error.log',
//  'monolog.level' => 300,
//));

//Mailer
$app->register(new Silex\Provider\SwiftmailerServiceProvider());

$app['swiftmailer.options'] = array(
  'host' => MAIL_HOST,
  'port' => MAIL_PORT,
  'username' => MAIL_USER,
  'password' => MAIL_PASS,
);

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
  'db.options' => array(
    'host' => DB_HOST,
    'driver' => 'pdo_mysql', #change if you not using mysql
    'dbname' => DB_DATA,
    'user' => DB_USER,
    'password' => DB_PASS,
    'charset' => DB_CHARSET,
    'path' => __DIR__ . '/app.db',
  ),
));

$app->get('/', function (Request $request) use ($app) {


  return $app['twig']->render('index.twig', array());
});

#error handling
$app->error(function (\Exception $e, $code) use ($app) {
  switch ($code) {
    case 404:
//      $app['monolog']->addError('<pre>Tryed to access: '.$request->getRequestUri().' , page was not found.\n'.$e.'</pre>');
      $message = 'The requested page could not be found.';
      break;
    default:
//      $app['monolog']->addError('<pre>We are sorry, but something went terribly wrong.<br>'.$e.'</pre>');
      $message = '<pre>We are sorry, but something went terribly wrong.<br>' . $e . '</pre>';
  }

  return new Response($message);
});

$app->run();