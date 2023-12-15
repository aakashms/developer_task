<?php

//session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mysql_host = 'localhost';
    $mysql_user = 'root';
    $mysql_password = '';
    $mysql_db = 'register_details';

    $mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_db);

    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    $email = $_POST["email"];
    $password = $_POST["password"];


    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // $_SESSION['email'] = $row['email'];
        // $_SESSION['name'] = $row['name'];
        // $_SESSION['address'] = $row['address'];

        $name = $row['name'];
        $address = $row['address'];
        
        $userDetails = array(
            "email" => $email,
            "name" => $name,
            "address" => $address
        );

        echo json_encode($userDetails);

    } else {
        echo "fail";
    }

    $mysqli->close();
    $stmt->close();
}
?>
