<?php
session_start();
include("include/connection.php");

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $error = array();

    if(empty($username)){
        $error['login'] = "Enter Username";
    }else if(empty($password)){
        $error['login'] = "Enter Password";
    }

    if(count($error) == 0){
        $q = "SELECT * FROM doctors WHERE username='$username'";
        $qq = mysqli_query($connect, $q);

        if(mysqli_num_rows($qq) > 0){
            $row = mysqli_fetch_array($qq);
            if(password_verify($password, $row['password'])){
                if($row['status'] == "pending"){
                    $error['login'] = "Please Wait for the admin to confirm";
                } else if($row['status'] == "Rejected"){
                    $error['login'] = "Try again later";
                } else {
                    $_SESSION['doctor'] = $username;
                    echo "<script>alert('Login Successful')</script>";
                    header("Location: doctor/index.php");
                    exit;
                }
            } else {
                $error['login'] = "Invalid Username or Password";
            }
        } else {
            $error['login'] = "Invalid Username or Password";
        }
    }
}

if(isset($error['login'])){
    $l = $error['login'];
    $show = "<h5 class='text-center alert alert-danger'>$l</h5>";
}else{
    $show = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctor Login Page</title>
</head>
<body style="background-image: url(img/hospital.jfif); background-size:cover; background-repeat: no-repeat;">

<?php include("include/header.php"); ?>

<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 jumbotron my-3">
                <h5 class="text-center my-2">Doctors Login</h5>
                    <div>
                        <?php echo $show; ?>
                    </div>
                <form method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" autocomplete="off" placeholder="Enter Username">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" autocomplete="off">
                    </div>
                    <input type="submit" name="login" class="btn btn-success" value="Login">

                    <p>I don't have an account <a href="apply.php">Apply Now</a></p>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>

</body>
</html>
