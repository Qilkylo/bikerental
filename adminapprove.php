<! –– Code author : Nurfairuz Binti Ahmad ––>

<?php

require_once('connection.php');

$bookid = $_GET['id'];

// Fetch booking details
$sql = "SELECT * FROM booking WHERE BOOK_Id = $bookid";
$result = mysqli_query($con, $sql);
$res = mysqli_fetch_assoc($result);

// Fetch bike details
$bike_id = $res['BIKE_ID'];
$sql2 = "SELECT * FROM bikes WHERE BIKE_ID = $bike_id";
$bikeres = mysqli_query($con, $sql2);
$bikeresult = mysqli_fetch_assoc($bikeres);

$email = $res['EMAIL'];
$bikename = $bikeresult['BIKE_NAME'];

// Check if the bike is available
if ($bikeresult['AVAILABILITY'] > 1) {
    
	// Check if the booking status is not one of the statuses that should prevent approval
    if ($res['BOOK_STATUS'] == 'APPROVED' || $res['BOOK_STATUS'] == 'RETURNED' || $res['BOOK_STATUS'] == 'IN USE' || $res['BOOK_STATUS'] == 'REJECTED') {
        echo '<script>alert("ACTION CANNOT PROCEED, MAYBE ALREADY APPROVED")</script>';
        echo '<script>window.location.href = "adminbook.php";</script>';
    
	} else {
       
		// Check if receipt exists in the payment table
        $paymentQuery = "SELECT * FROM payment WHERE book_id = $bookid";
        $paymentResult = mysqli_query($con, $paymentQuery);
        $paymentExists = mysqli_num_rows($paymentResult) > 0;

        if (!$paymentExists) {
            echo '<script>alert("Receipt not uploaded. Cannot change status.")</script>';
            echo '<script>window.location.href = "adminbook.php";</script>';
        
		} else {
           
			// Update booking status to 'APPROVED'
            $query = "UPDATE booking SET BOOK_STATUS='APPROVED' WHERE BOOK_ID=$bookid";
            $queryy = mysqli_query($con, $query);

            // Update bike availability
            $newAvailability = $bikeresult['AVAILABILITY'] - 1;
            $updateBikeQuery = "UPDATE bikes SET AVAILABILITY=$newAvailability WHERE BIKE_ID=$bike_id";
            $updateBikeResult = mysqli_query($con, $updateBikeQuery);

            if ($updateBikeResult) {
                echo '<script>alert("APPROVED SUCCESSFULLY")</script>';
                echo '<script>window.location.href = "adminbook.php";</script>';
            
			} else {
                echo '<script>alert("Failed to update bike availability")</script>';
                echo '<script>window.location.href = "adminbook.php";</script>';
            }
        }
    }
	
} else {
    echo '<script>alert("BIKE IS NOT AVAILABLE")</script>';
    echo '<script>window.location.href = "adminbook.php";</script>';
}

?>
