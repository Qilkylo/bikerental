<! –– Code author : Nurfairuz Binti Ahmad ––>

<?php

require_once('connection.php');

$bikeid = $_GET['id'];

// Retrieve the image filename from the database before deleting the record
$sql_select_image = "SELECT BIKE_IMG FROM bikes WHERE BIKE_ID = $bikeid";
$result_select_image = mysqli_query($con, $sql_select_image);

if ($result_select_image) {
    $row = mysqli_fetch_assoc($result_select_image);
    $image_filename = $row['BIKE_IMG'];

    // Delete the image file
    if ($image_filename) {
        $image_path = 'images/' . $image_filename;
        
		if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
}

// Delete the record from the database
$sql_delete_bike = "DELETE FROM bikes WHERE BIKE_ID = $bikeid";
$result_delete_bike = mysqli_query($con, $sql_delete_bike);

if ($result_delete_bike) {
    echo '<script>alert("BIKE DELETED SUCCESSFULLY")</script>';
    echo '<script>window.location.href = "adminbike.php";</script>';

} else {
    echo '<script>alert("Failed to delete bike record")</script>';
    echo '<script>window.location.href = "adminbike.php";</script>';
}

?>
