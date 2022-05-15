<?php return array (
  'botman/botman' => 
  array (
    'providers' => 
    array (
      0 => 'BotMan\\BotMan\\BotManServiceProvider',
    ),
    'aliases' => 
    array (
      'BotMan' => 'BotMan\\BotMan\\Facades\\BotMan',
    ),
  ),
  'botman/driver-telegram' => 
  array (
    'providers' => 
    array (
      0 => 'BotMan\\Drivers\\Telegram\\Providers\\TelegramServiceProvider',
    ),
  ),
  'botman/driver-web' => 
  array (
    'providers' => 
    array (
      0 => 'BotMan\\Drivers\\Web\\Providers\\WebServiceProvider',
    ),
  ),
  'facade/ignition' => 
  array (
    'providers' => 
    array (
      0 => 'Facade\\Ignition\\IgnitionServiceProvider',
    ),
    'aliases' => 
    array (
      'Flare' => 'Facade\\Ignition\\Facades\\Flare',
    ),
  ),
  'fruitcake/laravel-cors' => 
  array (
    'providers' => 
    array (
      0 => 'Fruitcake\\Cors\\CorsServiceProvider',
    ),
  ),
  'laravel/passport' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Passport\\PassportServiceProvider',
    ),
  ),
  'laravel/sail' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Sail\\SailServiceProvider',
    ),
  ),
  'laravel/sanctum' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Sanctum\\SanctumServiceProvider',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'nesbot/carbon' => 
  array (
    'providers' => 
    array (
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ),
  ),
  'nunomaduro/collision' => 
  array (
    'providers' => 
    array (
      0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    ),
  ),
  'scriptotek/google-books' => 
  array (
    'providers' => 
    array (
      0 => 'Scriptotek\\GoogleBooks\\GoogleBooksServiceProvider',
    ),
    'aliases' => 
    array (
      'GoogleBooks' => 'Scriptotek\\GoogleBooks\\GoogleBooksFacade',
    ),
  ),
);