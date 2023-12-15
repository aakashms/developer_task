<?php

// $redis = new Redis();
// $redis->connect('127.0.0.1', 6379);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    if (isset($_GET['email'])) {
        $email = $_GET['email'];
        
        $mysql_host = 'localhost';
        $mysql_user = 'root';
        $mysql_password = '';
        $mysql_db = 'register_details';

        $mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_db);

        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }

        $stmt = $mysqli->prepare("SELECT email, name, address FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $userData = $result->fetch_assoc();

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($userData);
        } else {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(['error' => 'User not found']);
        }

        $stmt->close();
        $mysqli->close();
    } else {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['error' => 'Missing email']);
    }
}

    // $response = array();
    // $response['email'] = $_SESSION["email"];
    // $response['name'] = $_SESSION["name"]; 
    // $response['address'] = $_SESSION["address"];
    // header('Content-Type: application/json; charset=utf-8');
    // echo json_encode($response);

?>
   
   




