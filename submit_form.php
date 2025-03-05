<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "healthcare"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$stmt = $conn->prepare("INSERT INTO appointments (name, dob, email, gender, contact, arrival_time) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $name, $dob, $email, $gender, $contact, $arrival_time);


$name = htmlspecialchars($_POST['name']);
$dob = htmlspecialchars($_POST['dob']);
$email = htmlspecialchars($_POST['email']);
$gender = htmlspecialchars($_POST['gender']);
$contact = htmlspecialchars($_POST['contact']);
$arrival_time = htmlspecialchars($_POST['arrival_time']);

if ($stmt->execute()) {
    
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Appointment Confirmation</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 20px;
            }
            .container {
                max-width: 600px;
                margin: auto;
                background: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            h1 {
                color: #333;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>Successfully Registered!</h1>
            <p>Thank you, <strong>$name</strong>!</p>
            <p>You have successfully registered for the appointment.</p>
            <p>Appointment Timing: <strong>$arrival_time</strong></p>
            <p>Date of Birth: <strong>$dob</strong></p>
            <p>Email: <strong>$email</strong></p>
            <p>Gender: <strong>$gender</strong></p>
            <p>Contact Number: <strong>$contact</strong></p>
        </div>
    </body>
    </html>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
