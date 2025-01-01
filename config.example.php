<?php return [

  'paths' => 
  [
    'base_directory' => '/var/www',
    'app_directory' => '/var/www/App'
  ],

  'database' => 
  [
    'host' => 'localhost',
    'port' => '3306',
    'dbname' => 'test',
    'username' => 'root',
    'password' => 'password',
    'charset' => 'utf8mb4'
  ],

  'autoload' => 
  [
    'paths' => 
    [
      'Controllers',
      'Logic'
    ],
  ],

];