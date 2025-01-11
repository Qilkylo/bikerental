<! –– Code author : Muhammad Aqqil Haziq ––>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIKE RENTAL</title>
    <!-- <link  rel="stylesheet" href=""> -->
    <script type="text/javascript">
        function preventBack() {
            window.history.forward(); 
        }
          
        setTimeout("preventBack()", 0);
          
        window.onunload = function () { null };
    </script>

</head>
<body class="body">
<style>
* {
    margin: 0;
    padding: 0;
}

body {
    background-color: #ABE7FF;
    background-position: center;
    background-size: cover;
}

div.main {
    width: 400px;
    margin: 100px auto 0 auto;
}

.btnn {
    width: 240px;
    height: 40px;
    background: #FFB2D8;
    border: none;
    margin-top: 30px;
    margin-left: 30px;
    font-size: 18px;
    border-radius: 10px;
    cursor: pointer;
    color: #000;
    transition: 0.4s ease;
}

.btnn:hover {
    background: #ED81DB;
    color: white; /* Set font color to white on hover */
}

.btnn a {
    text-decoration: bold;
    color: white; /* Set font color to white */
    font-weight: bold;
}

h2 {
    text-align: center;
    padding: 20px;
    font-family: sans-serif;
}

div.register {
    background-color: #fff; /* Set background color to white */
    width: 100%;
    font-size: 18px;
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.3);
    color: #000;
}

form#register {
    margin: 40px;
    background-color: #fff; /* Set background color to white */
}

label {
    font-family: sans-serif;
    font-size: 18px;
    font-style: italic;
}

input#name,
input#dfield,
input#datefield {
    width: 300px;
    border: 1px solid #ddd;
    border-radius: 3px;
    outline: 0;
    padding: 7px;
    background-color: #fff;
    box-shadow: inset 1px 1px 5px rgba(0, 0, 0, 0.3);
}

.hai {
    width: 100%;
    height: 0px;
}

.main {
    width: 100%;
    background: #fff;
    background-position: center;
    background-size: cover;
}

.navbar {
    width: 1200px;
    height: 75px;
    margin: auto;
}

.icon {
    width: 200px;
    float: left;
    height: 70px;
}

.logo {
    color: #0E79C8;
    font-size: 26px;
    font-family: 'Tahoma';
    padding-left: 0px;
    float: left;
    padding-top: 35px;
}

.menu {
    width: 400px;
    float: left;
    height: 70px;
    color: black; /* Set font color to black */
}


ul {
    float: left;
    display: flex;
    justify-content: center;
    align-items: center;
    color: black;
}

ul li {
    list-style: none;
    margin-left: 80px;
    margin-top: 35px;
    font-size: 14px;
    color: black;
}

ul li a {
    text-decoration: none;
    color: black; /* Set font color to black */
    font-family: Arial;
    font-weight: bold;
    transition: 0.4s ease-in-out;
}

ul li a:hover {
    color: white;
}


.nn {
    width: 100px;
    background: #FFB2D8;
    border: none;
    height: 40px;
    font-size: 18px;
    border-radius: 10px;
    cursor: pointer;
    color: white;
    transition: 0.4s ease;
}

.nn a {
    text-decoration: none;
    color: black;
    font-weight: bold;
}

.circle {
    border-radius: 48%;
    width: 65px;
}

.phello {
    width: 200px;
    margin-left: -50px;
    padding: 0px;
}


</style>


<?php 

    require_once('connection.php');
    session_start();
 
    $bike_id=$_GET['id'];
    
    $sql="select * from bikes where BIKE_ID='$bike_id'";
    $cname = mysqli_query($con,$sql);
    $email = mysqli_fetch_assoc($cname);
    
    $value = $_SESSION['email'];
    $sql="select * from users where EMAIL='$value'";
    $name = mysqli_query($con,$sql);
    $rows=mysqli_fetch_assoc($name);
    $uemail=$rows['EMAIL'];
    $bikeprice=$email['PRICE'];
    if(isset($_POST['book'])){
       
        $bdate=date('Y-m-d',strtotime($_POST['date']));;
        $dur=mysqli_real_escape_string($con,$_POST['dur']);
        $phno=mysqli_real_escape_string($con,$_POST['ph']);
         
        if(empty($bdate)|| empty($dur)|| empty($phno)){
            echo '<script>alert("please fill in all the details")</script>';

        }
        else{
            
            $price=($dur*$bikeprice);
            $sql="insert into booking (BIKE_ID,EMAIL,BOOK_DATE,DURATION,PHONE_NUMBER,PRICE) values($bike_id,'$uemail','$bdate','$dur','$phno',$price)";
            $result = mysqli_query($con,$sql);
            
            if($result){
                
                $_SESSION['email'] =$uemail;
                header("Location: payment.php");
            }
            else{
                echo '<script>alert("please check the connection")</script>';
            }
        
        }
    }
    
    ?>



    
       <div class="hai">
            <div class="navbar">
                <div class="icon">
                    <h2 class="logo">BIKE RENTAL</h2>
                </div>
                <div class="menu" >
                    <ul>
                        <li><a href="menu.php">HOME</a></li>
                    <li><a href="aboutus2.html">ABOUT</a></li>
                    
                    <li><a href="contact2.html">CONTACT</a></li>
                    <li><a href="feedback.html">FEEDBACK</a></li>
                    <li><button class="nn"><a href="logout.php">LOGOUT</a></button></li>
                    

                    <li><p class="phello">HELLO! &nbsp;<a id="pname"><?php echo $rows['NAME']?></a></p></li>

                    <li><a id="stat" href="bookinstatus.php">BOOKING STATUS</a></li>
                
                    </ul>
                </div>
            </div>
       </div>
                
                
         <div class="main"> 
        
        <div class="register">
            <br><h2>BOOKING</h2>
        <form id="register" method="POST"  >
            <h2>Bike Name : <?php echo "".$email['BIKE_NAME']?></h2>

            <label>BOOKING DATE : </label>
            <br>
            <input type="date" name="date" id="datefield" min='1899-01-01' max='2000-13-13'  placeholder="ENTER THE DATE FOR BOOKING" required>
            <br><br>

            <label>DURATION : </label>
            <br>
            <input type ="number" name="dur" min="1" max="30" 
            id="name" placeholder="Enter Rent Period (in days)" required>
            <br><br>

            <label>PHONE NUMBER : </label>
            <br>
            <input type="tel" name="ph" maxlength="10"
            id="name" placeholder="Enter Your Phone Number" required>
            <br><br>
            
            <input type="submit"  class="btnn" value="BOOK" name="book" >
            
        </form>
        </div>
    </div>
    
    <script>
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        if (dd < 10) {
             dd = '0' + dd
        }
        if (mm < 10) {
              mm = '0' + mm
        }

        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById("datefield").setAttribute("min", today);
        document.getElementById("datefield").setAttribute("max", today);


    </script>
    <script>
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        if (dd < 10) {
             dd = '0' + dd
        }
        if (mm < 10) {
              mm = '0' + mm
        }

        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById("dfield").setAttribute("min", today);
        


    </script>
    
    
    
    
</body>
</html>