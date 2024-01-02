
<?php
require 'db.php';


// $redis = new Redis();
// $redis->connect('127.0.0.1', 6379);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $addr = $_POST["addr"];
    $password = $_POST["password"];

    $checkQry = "SELECT * FROM users WHERE email = ?";
    $checkStmt = $mysqli->prepare($checkQry);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        
        echo "user_email";
    } else{
        $stmt = $mysqli->prepare("INSERT INTO users (name, email, address, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $addr, $password);
        
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "failure";
        }

        $stmt->close();
    }

    
    $checkStmt->close();
    $mysqli->close();
}
?>

