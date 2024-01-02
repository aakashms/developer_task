<?php
require 'db.php';
require '../vendor/autoload.php';


$collection = getMongoCollection('developer', 'profiles');
function fetchUserData($email) {
    global $collection;

    // Check Redis
    $userData = getUserData($email);

    if (!$userData) {
        // If not in Redis, fetch from MongoDB
        $userData = $collection->findOne(['email' => $email]);
        if ($userData) {
            // Store in Redis for future use
            setUserData($email, $userData);
        }
    }

    if ($userData) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($userData);
    } else {
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
}

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
    } 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $dob = $_POST['dob'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $gender = $_POST['gender'];
        $designation = $_POST['designation'];

        // Use Redis to store session data
        $redisUserData = getUserData($email);

        if ($redisUserData && $redisUserData == [
        "email" => $email,
        "name" => $name,
        "age" => $age,
        "dob" => $dob,
        "address" => $address,
        "phone" => $phone,
        "gender" => $gender,
        "designation" => $designation,
    ]) {
        echo json_encode(['status' => 'success', 'action' => 'no_changes']);
        exit;
    }

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
                if ($result->getModifiedCount() > 0) {
                    $action = 'updated';
                }

            } else {
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
                if ($result->getInsertedCount() > 0) {
                    $action = 'inserted';
                }
            }

            if (isset($action)) {

                setUserData($email, [
                    "email" => $email,
                    "name" => $name,
                    "age" => $age,
                    "dob" => $dob,
                    "address" => $address,
                    "phone" => $phone,
                    "gender" => $gender,
                    "designation" => $designation,
                ]);
                
                echo json_encode(['status' => 'success', 'action' => $action]);
            } else {
                
                echo json_encode(['status' => 'error', 'message' => 'No action performed']);
            }
            
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['status' => 'error', 'message' => 'Failed to save data: ' . $e->getMessage()]);
            error_log('MongoDB Error: ' . $e->getMessage());
        }

    }


?>