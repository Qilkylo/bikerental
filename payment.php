<! –– Code author : Muhammad Asnawie ––>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.1/css/all.min.css"
      href="main.js" 
    />
    <script src="main.js"></script>
    <link rel="stylesheet" href="css/pay.css" />
    <title>BIKE RENTAL</title>
    <script type="text/javascript">
        function preventBack() {
            window.history.forward(); 
        }
          
        setTimeout("preventBack()", 0);
          
        window.onunload = function () { null };
    </script>
  </head>
<body>
<style>
@import url("https://fonts.googleapis.com/css?family=Poppins&display=swap");

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}

body {
  background: linear-gradient(to bottom right, #ABE7FF 20%, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.05));
  background-position: center;
  background-size: cover;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
}

.card {
  margin-left: -1000px;
  background: linear-gradient(
    to bottom right,
    rgba(171, 231, 255, 0.2),
    rgba(255, 255, 255, 0.05)
  );
  text-align: right;
 
  box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.5), -1px -1px 2px #aaa,
    1px 1px 2px #555;
  backdrop-filter: blur(0.8rem);
  padding: 1.5rem;
  border-radius: 1rem;
  animation: 1s cubic-bezier(0.16, 1, 0.3, 1) cardEnter;
}

.card__row {
  display: flex;
  justify-content: space-between;
  padding-bottom: 2rem;
}

.card__title {
  font-weight: 600;
  font-size: 2.5rem;
  color: black;
  font-weight: 500;
  margin: 1rem 0 1.5rem;
  text-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);
   text-align: center;
}

.card__col {
  padding-right: 2rem;
  text-align: center;
}

.card__input {
  background: none;
  border: none;
  border-bottom: dashed 0.2rem rgba(255, 255, 255, 0.15);
  font-size: 1.2rem;
  color: black;
  text-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);
  text-align: center;
  cursor: pointer;
  padding-left: 18rem;
}
.card__input--large {
  font-size: 2rem;
  text-align: center;
  cursor: pointer;
}

.card__input::placeholder {
  color: rgba(255, 255, 255, 1);
  text-shadow: none;
  text-align: center;
}

.card__input:focus {
  outline: none;
  border-color: rgba(255, 255, 255, 0.6);
  text-align: center;
}

.card__label {
  display: block;
  color: black;
  text-shadow: 0 2px 2px rgba(0, 0, 0, 0.4);
  font-weight: 400;
  text-align: center;
}

.card__chip {
  align-self: flex-end;
}

.card__chip img {
  width: 13rem;
}

.card__brand {
  font-size: 3rem;
  color: #fff;
  min-width: 100px;
  min-height: 75px;
  text-align: right;
  text-shadow: 0 2px 2px rgba(0, 0, 0, 0.4);
}


@keyframes cardEnter {
  from {
    transform: translateY(100vh);
    opacity: 0.1;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}



  
.pay{
  width:200px;
  background: #FFB2D8;

  border:none;
  height: 40px;
  font-size: 18px;
  border-radius: 5px;
  cursor: pointer;
  color:black;
  transition: 0.4s ease;
  margin-left: 100px;
  text-align: center;
 font-weight: bold;

}

.pay:hover {
    background: #FFDDF6;
    color: black; /* Set the font color to the same as the background color */
}

.pay a{
  text-decoration: none;
  color: black;
  font-weight: bold;
  
}


.btn{
  width:200px;
  background: #FFB2D8;

  border:none;
  height: 40px;
  font-size: 18px;
  border-radius: 5px;
  cursor: pointer;
  color:black;
  transition: 0.4s ease;
  text-align: center;

}

.btn:hover {
    background: #FFDDF6;
    color: black; /* Set the font color to the same as the background color */
}

.btn a{
  text-decoration: none;
  color: black;
  font-weight: bold;
  
}

.payment{
  margin-top: -550px;
  margin-left: 500px;
  font-size: 40px;

}
</style>
<?php
require_once('connection.php');
session_start();

$email = $_SESSION['email'];

$sql = "SELECT * FROM booking WHERE EMAIL='$email' ORDER BY BOOK_ID DESC";
$cname = mysqli_query($con, $sql);
$email = mysqli_fetch_assoc($cname);
$bid = $email['BOOK_ID'];
$_SESSION['bid'] = $bid;

if (isset($_POST['pay'])) {
    $filetmp = $_FILES["RESIT_IMG"]["tmp_name"];
    $price = $email['PRICE'];

    if (empty($filetmp)) {
        echo '<script>alert("Please attach the payment receipt")</script>';
    } else {
        // Move the uploaded file to a directory on the server
        $uploadDir = 'receipts/'; // Specify your upload directory

        // Get the file extension
        $fileExtension = pathinfo($_FILES["RESIT_IMG"]["name"], PATHINFO_EXTENSION);

        // Construct the new file name using BOOK_ID and file extension
        $newFileName = 'BOOK_ID' . $bid . '.' . $fileExtension;

        $uploadFile = $uploadDir . $newFileName;

        if (move_uploaded_file($filetmp, $uploadFile)) {
            // Read the contents of the file
            $fileContents = file_get_contents($uploadFile);

            // Escape values to prevent SQL injection
            $bid = mysqli_real_escape_string($con, $bid);
            $price = mysqli_real_escape_string($con, $price);
            $fileContents = mysqli_real_escape_string($con, $newFileName);

            // Insert into the database
            $sql = "INSERT INTO payment (BOOK_ID, PRICE, RESIT_IMG) VALUES ('$bid', '$price', '$fileContents')";
            $result = mysqli_query($con, $sql);

            if ($result) {
                header("Location: psucess.php");
            } else {
                echo '<script>alert("Error uploading payment receipt to the database")</script>';
            }
        } else {
            echo '<script>alert("Error moving uploaded file to server")</script>';
        }
    }
}
?>

    <h2 class="payment">TOTAL PAYMENT: <a>RM <?php echo $email['PRICE'] ?>/-</a></h2>

    <div class="card">
      <form method="POST" enctype="multipart/form-data"> <!-- Change here -->
        <h1 class="card__title">Enter Payment Information</h1>

        <div class="card__col card__chip">
          <img src="images/qr.png" alt="qr" />
          <br>
        </div>

        <div class="card__col">
          <label class="card__label">Payment Receipt</label>
          <input
            type="file"
            class="card__input card__input--large"
            required="required"
            name="RESIT_IMG"
            accept=".jpg, .jpeg, .png, .pdf"
          />
        </div>

        <input type="submit" VALUE="PAY NOW" class="pay" name="pay">
        <button class="btn"><a href="cancelbooking.php">CANCEL</a></button>
      </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
    <script src="main.js"></script>
  </body>
</html>