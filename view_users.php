<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "healthcare"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $deleteSql = "DELETE FROM appointments WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $delete_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Record deleted successfully.');</script>";
    } else {
        echo "<script>alert('Error deleting record: " . $stmt->error . "');</script>";
    }
    
    $stmt->close();
}

$sql = "SELECT * FROM appointments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <style>
        *{
            padding: 0;
             margin: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #007BFF;
            color: white;
        }
        .button {
            background-color: #dc3545; 
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #c82333; 
        }
      .margin{
        margin-bottom:30px;

      }
      .two{
        margin-top:10px;
      }

      h1 {
            color: #003366;
            font-family: Arial, sans-serif; 
            font-size: 2.0em; /* Larger size for emphasis */
            text-align: center;
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
            <li class="link"><a href="blog_comments.html">Blog</a></li>
            <li class="link"><a href="lab_accountant_login.php">Admin</a></li>
            
          </ul>
          <a href="blog_comments.html" ><button class="btn">Feedback</button></a>>
        </nav>
        </header >
      
    
    <div class="container">
     <center>   <h1>User Details</h1></center>
        <table class="two">
            <tr>
               
                <th>Name</th>
                <th>Email</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Contact Number</th>
                <th>Preferred Time</th>
                <th>Action</th>
            </tr>
            <?php if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                       
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['dob']}</td>
                        <td>{$row['gender']}</td>
                        <td>{$row['contact']}</td>
                        <td>{$row['arrival_time']}</td>
                        <td>
                            <form method='post' action=''>
                                <input type='hidden' name='delete_id' value='{$row['id']}'>
                                <button type='submit' class='button'>OK</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No records found</td></tr>";
            } ?>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
