<! –– Code author : Muhammad Asnawie ––>

<?php
// Assuming you have a MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bikerental";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Validate and insert into the database
    if (!empty($name) && !empty($email) && !empty($message)) {
        $sql = "INSERT INTO feedback (FED_ID, email, comment) VALUES ('$name', '$email', '$message')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to the feedback submitted page
            header("Location: feedsub.html");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the connection
$conn->close();
?>

