<?php

//$redis = new Redis();
//$redis->connect('127.0.0.1', 6379);

if (isset($_GET['sessionToken'])) {
    $sessionToken = $_GET['sessionToken'];
    $userData = $redis->get('user:' . $sessionToken);

    if ($userData) {
       
        $userDataArray = json_decode($userData, true);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($userDataArray);
    } else {
       
        header('HTTP/1.1 401 Unauthorized');
        echo json_encode(['error' => 'Invalid or expired session token']);
    }
} 

session_start();
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $response = array();
    $response['email'] = $_SESSION["email"];
    $response['name'] = $_SESSION["name"]; 
    $response['address'] = $_SESSION["address"];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
   
}
?>


