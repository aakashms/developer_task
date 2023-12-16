<?php

require __DIR__ . '/../vendor/autoload.php';

$dbUsername = 'developer';
$dbPassword = 'DSA6eTZHUzp3ceDh';

$client = new MongoDB\Client(
    "mongodb+srv://{$dbUsername}:{$dbPassword}@authcluster.wl6e93k.mongodb.net/"
);

    $collection = $client->selectCollection('developer', 'profiles');

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET['email'])) {
            $email = $_GET['email'];

            $userData = $collection->findOne(['email' => $email]);

            if ($userData) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($userData);
            } else {
                header('HTTP/1.1 404 Not Found');
                echo json_encode(['status' => 'error', 'message' => 'User not found']);
            }
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['status' => 'error', 'message' => 'Missing email']);
        }
    } if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $dob = $_POST['dob'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $gender = $_POST['gender'];
        $designation = $_POST['designation'];
    
        $existingUser = $collection->findOne(['email' => $email]);
    
        try {
            if ($existingUser) {
                // Update user data in MongoDB
                $result = $collection->updateOne(
                    ['email' => $email],
                    [
                        '$set' => [
                            'name' => $name,
                            'age' => $age,
                            'dob' => $dob,
                            'address' => $address,
                            'phone' => $phone,
                            'gender' => $gender,
                            'designation' => $designation,
                        ],
                    ]
                );
            } else {
                // Insert user data into MongoDB
                $result = $collection->insertOne([
                    'email' => $email,
                    'name' => $name,
                    'age' => $age,
                    'dob' => $dob,
                    'address' => $address,
                    'phone' => $phone,
                    'gender' => $gender,
                    'designation' => $designation,
                ]);
            }
    
            if ($result->getInsertedCount() > 0 || $result->getModifiedCount() > 0) {
                // Data saved successfully
                $action = $existingUser ? 'Updated' : 'Submitted';
                echo json_encode(['status' => 'success', 'message' => "User data $action successfully"]);
            } else {
                // Error saving data
                echo json_encode(['status' => 'error', 'message' => 'Failed to save data']);
            }
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Failed to save data: ' . $e->getMessage()]);
            error_log('MongoDB Error: ' . $e->getMessage());
        }
    }


?>