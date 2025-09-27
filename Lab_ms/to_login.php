<!DOCTYPE html> 
<html> 
<head> 
    <title>Laboratory Management System - Technical Officer Login</title> 
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1"> 
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> 
</head> 
<style type="text/css"> 
    body { 
        background: rgba(245, 245, 245, 0.4); 
        background-image: url("https://thumbs.wbm.im/pw/small/de9b92536e9d1b505e1b67ab9e12cf90.jpg"); 
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
            <ul class="nav navbar-nav navbar-right"> 
                <li class="nav-item"> 
                    <a class="nav-link text-light" href="index.php">User Login</a> 
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
                <center><h3 class="login-header"><b><u>TECHNICAL OFFICER LOGIN</u></b></h3></center> 
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
                    <?php 
                        session_start(); 
                        if(isset($_POST['login'])){ 
                            $connection = mysqli_connect("localhost","root",""); 
                            $db = mysqli_select_db($connection,"lab"); 
                            $query = "SELECT * FROM Technical_Officer WHERE email = '$_POST[email]'"; 
                            $query_run = mysqli_query($connection,$query); 
                            while ($row = mysqli_fetch_assoc($query_run)) { 
                                if($row['email'] == $_POST['email']){ 
                                    if($row['password'] == $_POST['password']){ 
                                        $_SESSION['name'] = $row['name']; 
                                        $_SESSION['email'] = $row['email']; 
                                        $_SESSION['officer_id'] = $row['officer_id']; 
                                        header("Location: tech_officer/officer_dashboard.php"); 
                                    } 
                                    else{ 
                                        echo '<div class="alert alert-danger" role="alert">Wrong Password !!</div>'; 
                                    } 
                                } 
                            } 
                        } 
                    ?> 
                </div> 
            </div> 
        </div> 
    </div> 
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> 
</body> 
</html>
