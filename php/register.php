
<?php



// $redis = new Redis();
// $redis->connect('127.0.0.1', 6379);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $mysql_host = 'localhost';
    $mysql_user = 'root';
    $mysql_password = '';
    $mysql_db = 'register_details';

    $mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_db);

    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    $name = $_POST["name"];
    $email = $_POST["email"];
    $addr = $_POST["addr"];
    $password = $_POST["password"];

    $sql = "INSERT INTO users (name, email, address, password) 
            VALUES ('$name', '$email', '$addr', '$password')";

    if ($mysqli->query($sql) === TRUE) {
    header("Location: ../login.html");
    } 
    else 
    {
        echo "Error adding student: " . $mysqli->error;
    }
}
?>

