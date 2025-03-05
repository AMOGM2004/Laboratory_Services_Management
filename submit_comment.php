<?php
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "healthcare"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']); // Sanitize user input
    $comment = $conn->real_escape_string($_POST['comment']); // Sanitize user input

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO blog_comments (name, comment) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $comment);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('Comment submitted successfully!'); window.location.href='blog_comments.html';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

$conn->close();
?>




<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "healthcare";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM blog_comments ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="comment">';
        echo '<h4>' . $row['name'] . '</h4>';
        echo '<p>' . $row['comment'] . '</p>';
        echo '<span>' . $row['created_at'] . '</span>';
        echo '</div>';
    }
} else {
    echo "No comments yet!";
}

$conn->close();
?>
