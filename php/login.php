<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        $name = $row['name'];
        $address = $row['address'];
        $sessionId = md5(uniqid(rand(), true));
        $userDetails = array(
            "email" => $email,
            "name" => $name,
            "address" => $address
        );
    
        echo json_encode($userDetails);

    } else {
        echo "fail";
    }

    $stmt->close();
}
?>
