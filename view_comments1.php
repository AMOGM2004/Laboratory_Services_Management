<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "healthcare";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a delete request has been made
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_comment'])) {
    $comment_id = $_POST['comment_id']; // Get the comment ID to delete
    $delete_sql = "DELETE FROM blog_comments WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $comment_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Comment deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting comment: " . $conn->error . "');</script>";
    }
    
    $stmt->close();
}

// Fetch all comments
$sql = "SELECT * FROM blog_comments ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Comments</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .comment {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            background: #fafafa;
            transition: background 0.3s;
        }
        .comment:hover {
            background: #f1f1f1;
        }
        .comment h4 {
            margin: 0 0 10px 0;
            color: #007BFF;
        }
        .comment p {
            margin: 0 0 10px 0;
            color: #555;
        }
        .comment span {
            display: block;
            font-size: 12px;
            color: #999;
            text-align: right;
        }
        .no-comments {
            text-align: center;
            color: #555;
            font-size: 18px;
            margin-top: 20px;
        }
        .margin {
            margin-bottom: 50px;
        }
        .delete-button {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<link rel="stylesheet" href="styles.css">
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

<div class="container" id="1">
    <h1>Blog Comments</h1>

    <?php if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="comment">';
            echo '<h4>' . htmlspecialchars($row['name']) . '</h4>';
            echo '<p>' . htmlspecialchars($row['comment']) . '</p>';
            echo '<span>' . htmlspecialchars($row['created_at']) . '</span>';
            echo '<form method="POST" style="margin-top: 10px;">';
            echo '<input type="hidden" name="comment_id" value="' . $row['id'] . '">';
            echo '<button type="submit" name="delete_comment" class="delete-button">Clear</button>';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo '<div class="no-comments">No comments yet!</div>';
    } ?>

</div>

</body>
</html>

<?php
$conn->close();
?>
