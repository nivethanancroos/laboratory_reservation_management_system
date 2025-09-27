<!DOCTYPE html> 
<html> 
<head> 
    <title>Laboratory Management System - Student Login</title> 
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1"> 
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> 
</head> 
<?php 
                        session_start(); 
                        if(isset($_POST['login'])){ 
                            $connection = mysqli_connect("localhost","root",""); 
                            $db = mysqli_select_db($connection,"lab"); 
                            $query = "SELECT * FROM Student WHERE email = '$_POST[email]'"; 
                            $query_run = mysqli_query($connection,$query); 
                            while ($row = mysqli_fetch_assoc($query_run)) { 
                                if($row['email'] == $_POST['email']){ 
                                    if($row['password'] == $_POST['password']){ 
                                        $_SESSION['name'] = $row['name']; 
                                        $_SESSION['email'] = $row['email']; 
                                        $_SESSION['student_id'] = $row['student_id']; 
                                        header("Location: student/student_dashboard.php"); 
                                    } 
                                    else{ 
                                        echo '<div class="alert alert-danger" role="alert">Wrong Password !!</div>'; 
                                    } 
                                } 
                            } 
                        } 
                    ?>
<style type="text/css"> 
    body { 
        background: rgba(132, 148, 58, 0.4); 
        background-image: url("https://thumbs.wbm.im/pw/small/de9b92536e9d1b505e1b67ab9e12cf90.jpg"); 
        background-repeat: no-repeat; /* Prevents repetition */
        background-position: center; /* Centers the image */
        background-attachment: fixed; /* Keeps the background static while scrolling */
        background-size: cover; /* Ensures the image covers the entire background */
    } 

.navbar-brand img {
    height: 40px; /* Adjust image height */
    margin-right: 10px; /* Space between image and text */
}
.navbar {
    background: linear-gradient(90deg, #00440a, #2a5298); /* 90-degree gradient from blue to light blue */
    border-bottom: 2px solid rgba(255, 255, 255, 0.2); /* Semi-transparent white border */
    padding: 10px 20px; /* Padding for the navbar */
}
/* Form container styling */
.form-container {
    background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Soft shadow for depth */
    padding: 30px; /* Padding inside the form container */
    transition: box-shadow 0.3s ease; /* Smooth transition on hover */
}

/* Hover effect for form container */
.form-container:hover {
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); /* Enhanced shadow on hover */
}
Form{
    width: 100%;
    background: linear-gradient(to bottom, darkgreen, white);
    padding : 50px;
    border-radius : 20px;
    margin-top : 150px;
}
.login-header {
            color: white; /* Change this to the desired color */
            text-align: center;
            font-size: 24px; /* Adjust the font size if needed */
        }

</style> 
<body> 
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> 
        <div class="container-fluid"> 
            <div class="navbar-header"> 
                <a class="navbar-brand" href="index.php"><img src="laboratory_reservation_management_system.png"></a> 
            </div> 
            <ul class="nav navbar-nav navbar-right "> 
                <li class="nav-item "> 
                    <a class="nav-link text-light" href="index.php" >User Login</a> 
                </li> 
                <li class="nav-item"> 
                    <a class="nav-link text-light" href="to_login.php">Technical Officer Login</a> 
                </li> 
                <li class="nav-item"> 
                    <a class="nav-link text-light" href="signup.php">Signup</a> 
                </li> 
            </ul> 
        </div> 
    </nav> 
    <div class="container">
        <div class="row justify-content-center"> 
            <div class="col-md-6"> 
                <div class=" p-4 mt-4"> 
                    <center><h3 class="login-header"><b><u>STUDENT LOGIN</u></b></h3></center> 
                    <form action="" method="post" class="mt-4"> 
                        <div class="form-group"> 
                            <label for="email">Email ID:</label> 
                            <input type="text" name="email" class="form-control" required> 
                        </div> 
                        <div class="form-group"> 
                            <label for="password">Password:</label> 
                            <input type="password" name="password" class="form-control" required> 
                        </div> 
                        <button type="submit" name="login" class="btn btn-primary btn-block">Login</button> 
                        <p class="mt-2 text-center">Don't have an account? <a href="signup.php">Signup now!</a></p>   
                    </form> 
                    
                </div> 
            </div> 
        </div> 
    </div> 
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> 
</body> 
</html>
