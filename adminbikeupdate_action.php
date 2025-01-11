<! –– Code author : Nurfairuz Binti Ahmad ––>

<?php

require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updatebike'])) {
    $bikeid = isset($_POST['bikeid']) ? intval($_POST['bikeid']) : 0;

    if ($bikeid <= 0) {
        echo "Invalid bike ID";
        exit();
    }

    $bikename = mysqli_real_escape_string($con, $_POST['bikename']);
    $avail = intval($_POST['avail']);
    $price = intval($_POST['price']);

    // Handle file upload
    if ($_FILES['fileToUpload']['size'] > 0) {
        
		// Fetch the old photo file name from the database
        $sqlOldPhoto = "SELECT BIKE_IMG FROM bikes WHERE BIKE_ID = $bikeid";
        $resultOldPhoto = mysqli_query($con, $sqlOldPhoto);

        if (mysqli_num_rows($resultOldPhoto) > 0) {
            $rowOldPhoto = mysqli_fetch_assoc($resultOldPhoto);
            $oldPhotoFilename = $rowOldPhoto['BIKE_IMG'];

            // Delete the old photo file
            if (file_exists("images/$oldPhotoFilename")) {
                unlink("images/$oldPhotoFilename");
            }
        }

        // Move the new photo file
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        
		move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

        // Update database with new image filename
        $sql = "UPDATE bikes SET BIKE_NAME='$bikename', AVAILABILITY=$avail, PRICE=$price, BIKE_IMG='" . basename($_FILES["fileToUpload"]["name"]) . "' WHERE BIKE_ID=$bikeid";
    
	} else {
        
		// Update database without changing the image
        $sql = "UPDATE bikes SET BIKE_NAME='$bikename', AVAILABILITY=$avail, PRICE=$price WHERE BIKE_ID=$bikeid";
    }

    if (mysqli_query($con, $sql)) {
        echo '<script>alert("BIKE UPDATED SUCCESSFULLY")</script>';
        echo '<script>window.location.href = "adminbike.php";</script>';
        exit();
    
	} else {
        echo '<script>alert("Error updating record: ' . mysqli_error($con) . '")</script>';
        echo '<script>window.location.href = "adminbikeupdate.php?id=' . $bikeid . '";</script>';
    }

} else {
    echo '<script>alert("Invalid request")</script>';
	echo '<script>window.location.href = "adminbike.php";</script>';
}

?>
