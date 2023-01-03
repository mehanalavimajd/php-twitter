<?php
    ini_set('error_reporting',E_ALL);
    ini_set('display_errors',1);
// Use this namespace
use Steampixel\Route;

// Include router class
include 'src/Steampixel/Route.php';

// Define a global basepath
define('BASEPATH',"/php-twitter/");


// Add base route (startpage)
Route::add('/', function () {
  include("./views/home.php");
});

Route::add('/login', function () {
  include("./views/login.php");
},['get','post']);

Route::add("/signup", function () {
  include("./views/signup.php");
}, ['get', 'post']);

Route::add("/logout", function () {
  include("./views/logout.php");
});

Route::add("/api/tweet", function () {
  include("./api/tweet.php");
}, 'post');

Route::add("/user/([a-z-0-9-]*)", function ($slug) {
  $_GET['user'] = $slug;
  include("./views/user.php");
});
Route::run(BASEPATH);