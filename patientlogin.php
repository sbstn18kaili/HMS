<?php
session_start();

include("include/connection.php");

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username)){
        echo "<script>alert('Enter Username')</script>";
    }else if(empty($password)){
        echo "<script>alert('Enter Password')</script>";
    }else{
        $query = "SELECT * FROM patient WHERE username='$username' AND password='$password'";

        $res = mysqli_query($connect,$query);

        if(mysqli_num_rows($res)==1){

            header("Location: patient/index.php");

            $_SESSION['patient'] = $username;
        }else{

        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Patient login page</title>
</head>
<body style="background-image: url(img/hospital.jfif); backgorund-repeat: no-repeat; background-size: cover;">

<?php
include("include/header.php");

?>

<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 my-5 jumbotron">
                <h5 class="text-center my-3">Patient Login</h5>

                <form method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text"  name="username" class="form-control" autocomplete="off" placeholder="Enter username">
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" autocomplete="off" placeholder="Enter password">
                    </div>

                    <input type="submit" name="login" class="btn btn-info my-3" value="Login">

                    <p>I don't have an account <a href="account.php">Click here.</a></p>

                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>
    
</body>
</html>