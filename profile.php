<! –– Code author : Danneal Kendrick ––>

<!-- profile.php -->
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

        .profile-container {
    background-color: #6FAFDE;
    color: black;
    padding: 20px;
    border-radius: 12px;
    margin-top: 70px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}


        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            text-align: left;
            width: 100%;
            max-width: 600px;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #0E79C8;
            color: #fff;
        }

       .edit-profile-btn a,
.home-btn a {
    text-decoration: none; /* Remove underline */
    color: inherit; /* Inherit color from the parent */
}

.edit-profile-btn {
    background-color: #FFB2D8;
    color: black;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
    margin-top: 20px;
    display: inline-block;
	font-weight: bold;
	
}

.edit-profile-btn:hover {
    background-color: #FFE3F3;
}

.home-btn {
    background-color: #FFB2D8;
    color: black;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none; /* Remove underline from anchor tags inside buttons */
    font-size: 16px;
    transition: background-color 0.3s ease;
    margin-top: 20px;
    display: inline-block;
    position: absolute;
    top: 10px;
    left: 10px;
	font-weight: bold;
}

.home-btn:hover {
    background-color: #FFE3F3;
}




    </style>
</head>

<body>
    <div class="container">
        <div class="profile-container">
            <h2 style="font-size: 35px;">USER PROFILE</h2>
            <table>
                
                <tr>
                    <td>Username :</td>
                    <td><?php echo $rows['NAME']; ?></td>
                </tr>
                <tr>
                    <td>Email :</td>
                    <td><?php echo $rows['EMAIL']; ?></td>
                </tr>
                <tr>
                    <td>Student Number :</td>
                    <td><?php echo $rows['STUD_NUM']; ?></td>
                </tr>
                <tr>
                    <td>Phone Number :</td>
                    <td><?php echo $rows['PHONE_NUMBER']; ?></td>
                </tr>
                <tr>
                    <td>Gender :</td>
                    <td><?php echo ucfirst($rows['GENDER']); ?></td>
                </tr>
            </table>
        </div>
        <button class="edit-profile-btn"><a href="edit_profile.php">EDIT PROFILE</a></button>
        <button class="home-btn"><a href="menu.php">HOME</a></button>
    </div>

    <script>
        // JavaScript to handle notification display
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const successMessage = urlParams.get('success');
            const errorMessage = urlParams.get('error');

            if (successMessage) {
                alert('Profile updated successfully!');
            } else if (errorMessage) {
                alert('Error updating profile: ' + decodeURIComponent(errorMessage));
            }
        });
    </script>
</body>

</html>
