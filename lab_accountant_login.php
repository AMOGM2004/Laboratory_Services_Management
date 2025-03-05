<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "healthcare";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $waiter_id = $_POST['waiter_id'];
    $waiter_password = $_POST['waiter_password'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT * FROM lab_accountant_login WHERE user_id = ? AND user_password = ?");
    $stmt->bind_param("ss", $waiter_id, $waiter_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Store user ID in the session
        $_SESSION['user_id'] = $waiter_id;

        // Conditional redirection based on credentials
        if ($waiter_id === 'Admin' && $waiter_password === 'Admin2004') {
            header("Location: view_users.php");
            exit;
        } elseif ($waiter_id === 'Admin' && $waiter_password === 'Blog2004') {
            header("Location: view_comments1.php");
            exit;
        } else {
            $error = "Invalid ID or Password!";
            echo "<script>alert('Invalid ID or Password!');</script>";
        }
    } else {
        $error = "Invalid ID or Password!";
        echo "<script>alert('Invalid ID or Password!');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style1.class">
    <link rel="stylesheet" href="styles.css" />
    <style>
        .margin{
            margin-bottom:50px;
        }
        </style>
</head>
<body>

<header class="margin">
    <nav class="section__container nav__container">
        <div class="nav__logo">Health<span>Care</span></div>
        <ul class="nav__links">
            <li class="link"><a href="index.html">Home</a></li>
            <li class="link"><a href="dummyabout.html">About Us</a></li>
            <li class="link"><a href="dummyservices.html">Services</a></li>
            <li class="link"><a href="view_comments.php">Blog</a></li>
            <li class="link"><a href="lab_accountant_login.php">Admin</a></li>
        </ul>
        <a href="blog_comments.html"><button class="btn">Feedback</button></a>
    </nav>
</header>

<div class="login-container" style="background-color: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); width: 100%; max-width: 400px; margin: 0 auto;">
    <h2 style="margin-bottom: 25px; color: #333; font-weight: 700; font-size: 24px; text-align: center;">Admin Login</h2>

    <?php if ($error) : ?>
        <div class="error" style="color: #dc3545; margin-bottom: 15px; font-weight: 500; text-align: center; font-size: 14px;"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="input-group" style="margin-bottom: 20px;">
            <label for="waiter_id" style="display: block; margin-bottom: 8px; color: #555; font-weight: 500; font-size: 14px;">User Name</label>
            <input type="text" placeholder="Enter Your UserName" id="waiter_id" name="waiter_id" required style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; transition: all 0.3s ease;" onfocus="this.style.borderColor='#007bff'; this.style.boxShadow='0 0 8px rgba(0, 123, 255, 0.2)';" onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none';">
        </div>
        <div class="input-group" style="margin-bottom: 20px;">
            <label for="waiter_password" style="display: block; margin-bottom: 8px; color: #555; font-weight: 500; font-size: 14px;">Password</label>
            <input type="password" placeholder="Enter Your Password" id="waiter_password" name="waiter_password" required style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; transition: all 0.3s ease;" onfocus="this.style.borderColor='#007bff'; this.style.boxShadow='0 0 8px rgba(0, 123, 255, 0.2)';" onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none';">
        </div>
        <button type="submit" class="btn" style="width: 100%; padding: 14px; background-color: #007bff; color: white; border: none; border-radius: 8px; font-size: 16px; cursor: pointer; transition: background-color 0.3s ease; font-weight: 500;" onmouseover="this.style.backgroundColor='#0056b3';" onmouseout="this.style.backgroundColor='#007bff';">Login</button>
    </form>
</div>

</body>
</html>
