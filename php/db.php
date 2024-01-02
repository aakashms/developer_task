<?php
require '../vendor/autoload.php'; // Include Composer autoloader
Predis\Autoloader::register(); // Register Predis autoloader

use MongoDB\Client;

// MySQL Configuration
$mysql_host = 'localhost';
$mysql_user = 'root';
$mysql_password = '';
$mysql_db = 'register_details';

$mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_db);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// MongoDB Configuration
$dbUsername = 'developer';
$dbPassword = 'DSA6eTZHUzp3ceDh';
$mongoUri = "mongodb+srv://{$dbUsername}:{$dbPassword}@authcluster.wl6e93k.mongodb.net/";
$mongoClient = new Client($mongoUri);


function getMongoCollection($dbName, $collectionName) {
    global $mongoClient;
    return $mongoClient->selectCollection($dbName, $collectionName);
}


$redis = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => '127.0.0.1',
    'port'   => 6379,
]);

function setUserData($email, $data) {
    global $redis;
    $redis->set($email, json_encode($data));
}


function getUserData($email) {
    global $redis;
    $data = $redis->get($email);
    return json_decode($data, true);
}

$redis->ping();
   
?>
