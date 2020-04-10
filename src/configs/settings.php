<?php

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

if($_ENV['ENV_APP'] == 'DEV'){
  return [
    'settings' => [
      'displayErrorDetails' => true, // set to false in production
      'addContentLengthHeader' => false, // Allow the web server to send the content-length header
      // Renderer settings
      'renderer' => [
        'template_path' => __DIR__ . '/../templates/',
      ],
      // Monolog settings
      'logger' => [
        'name' => 'slim-app',
        'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../../logs/app.log',
        'level' => \Monolog\Logger::DEBUG,
      ],
      'constants' => [
        'base_url' => 'http://localhost:3000/',
        'static_url' => 'http://localhost:3000/public/',
        'ambiente_static' => 'desarrollo',
        'ambiente_csrf' => 'active',
        'ambiente_session' => 'active',
        'login' => [
          'usuario' => 'admin',
          'contrasenia' => 'sistema123'
        ],
        'key' => 'LxFV3PyEv1bhQ',
        'csrf' => [
          'secret' => 'PKBcauXg6sTXz7Ddlty0nejVgoUodXL89KNxcrfwkEme0Huqtj6jjt4fP7v2uF4L',
          'key' => 'csrf_val'
        ],
        'period' => '2020-I',
        'oauth' => [
          'google' => [
            'client_id' => '1044701093820-jam7g5carn4nghkkhqr75ustq0l5vrum.apps.googleusercontent.com',
            'client_secret' => '_gRRhQeMc6HKcCWum1hprRhy',
            'url' => 'https://oauth2.googleapis.com/token',
          ],
        ],
      ],
    ],
  ];
}

if($_ENV['ENV_APP'] == 'SWP'){
  return [
    'settings' => [
      'displayErrorDetails' => true, // set to false in production
      'addContentLengthHeader' => false, // Allow the web server to send the content-length header
      // Renderer settings
      'renderer' => [
        'template_path' => __DIR__ . '/../templates/',
      ],
      // Monolog settings
      'logger' => [
        'name' => 'slim-app',
        'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../../logs/app.log',
        'level' => \Monolog\Logger::DEBUG,
      ],
      'constants' => [
        'base_url' => 'http://softweb.pe/tw/',
        'static_url' => 'http://softweb.pe/tw/public/',
        'ambiente_static' => 'desarrollo',
        'ambiente_csrf' => 'active',
        'ambiente_session' => 'active',
        'login' => [
          'usuario' => 'admin',
          'contrasenia' => 'sistema123'
        ],
        'key' => 'LxFV3PyEv1bhQ',
        'csrf' => [
          'secret' => 'PKBcauXg6sTXz7Ddlty0nejVgoUodXL89KNxcrfwkEme0Huqtj6jjt4fP7v2uF4L',
          'key' => 'csrf_val'
        ],
        'period' => '2020-I',
        'oauth' => [
          'google' => [
            'client_id' => '1044701093820-jam7g5carn4nghkkhqr75ustq0l5vrum.apps.googleusercontent.com',
            'client_secret' => '_gRRhQeMc6HKcCWum1hprRhy',
            'url' => 'https://oauth2.googleapis.com/token',
          ],
        ],
      ],
    ],
  ];
}