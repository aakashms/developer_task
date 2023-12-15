<?php

session_start();
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


    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $mysqli->query($sql);
    $sql1="SELECT name FROM users WHERE email = '$email'";
    $name = $mysqli->query($sql1);
    $sql2="SELECT address FROM users WHERE email = '$email'";
    $address = $mysqli->query($sql1);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        $_SESSION['email'] = $row['email'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['address'] = $row['address'];
        header("Location: ../profile.html");
    
    } else {
        echo "Invalid username or password";
    }

    $mysqli->close();
}
?>
