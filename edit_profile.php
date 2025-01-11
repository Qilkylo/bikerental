<! –– Code author : Danneal Kendrick ––>

<?php
require_once('connection.php');

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$sql = "SELECT * FROM users WHERE EMAIL = '$email'";
$result = mysqli_query($con, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $rows = mysqli_fetch_assoc($result);
    } else {
        echo "User not found.";
        exit();
    }
} else {
    echo "Error fetching user details: " . mysqli_error($con);
    exit();
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIKE RENTAL</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #ABE7FF;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            text-align: left;
            width: 100%;
            max-width: 600px;
            margin-top: 20px;
        }

        h2 {
            color: #DC37B7;
            font-size: 40px;
            margin-bottom: 20px;
            text-align: center;
			font-weight: bold;
        }

        label {
            display: block;
            margin: 10px 0;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button.save-btn {
            background-color: #FFB2D8;
            color: black;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            display: inline-block;
				font-weight: bold;
        }

        button.save-btn:hover {
            background-color: #FFE3F3;
        }
		
		.home-btn a {
text-decoration: none; /* Remove underline */
    color: inherit; /* Inherit color from the parent */
}
        button.home-btn {
            background-color: #FFB2D8;
            color: black;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            position: absolute;
            top: 10px;
            left: 10px;
				font-weight: bold;
        }

        button.home-btn:hover {
            background-color: #FFE3F3;
        }
    </style>
</head>
<body>
    <button class="home-btn"><a href="profile.php">BACK</a></button>

    <form method="post" action="update_profile.php">
        <h2>EDIT PROFILE</h2>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $rows['NAME']; ?>" required>

        <label for="stud_num">Student Number:</label>
        <input type="text" id="stud_num" name="stud_num" value="<?php echo $rows['STUD_NUM']; ?>" required>

        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" value="<?php echo $rows['PHONE_NUMBER']; ?>" required>

        <!-- Non-editable email input -->
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo $rows['EMAIL']; ?>" readonly>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="male" <?php echo ($rows['GENDER'] === 'male') ? 'selected' : ''; ?>>Male</option>
            <option value="female" <?php echo ($rows['GENDER'] === 'female') ? 'selected' : ''; ?>>Female</option>
        </select>

        <button type="submit" class="save-btn">SAVE CHANGES</button>
    </form>
</body>
</html>


