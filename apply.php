<?php
include("include/connection.php");

if(isset($_POST['apply'])){

    $firstname = $_POST['fname'];
    $surname = $_POST['sname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $password = $_POST['pass'];
    $confirm_password = $_POST['con_pass'];

    $error = array();

    if(empty($firstname)){
        $error['apply'] = "Enter Firstname";
    }else if(empty($surname)){
        $error['apply'] = "Enter Surname";
    }else if(empty($username)){
        $error['apply'] = "Enter Username";
    }
    else if(empty($email)){
        $error['apply'] = "Enter Email Address";
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error['apply'] = "Invalid Email Format";
    }
    else if(empty($gender)){
        $error['apply'] = "Choose Gender";
    }
    else if(empty($phone)){
        $error['apply'] = "Enter Phone";
    }
    else if(empty($country)){
        $error['apply'] = "Select Country";
    }
    else if(empty($password)){
        $error['apply'] = "Enter Password";
    }
    else if($confirm_password != $password){
        $error['apply'] = "Password Mismatch";
    }
    
    if(count($error) == 0){
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO doctors(firstname, surname, username, email, gender, phone, country, password, salary, data_reg, status, profile) 
                  VALUES ('$firstname', '$surname', '$username', '$email', '$gender', '$phone', '$country', '$hashed_password', '0', NOW(), 'pending', 'doctor.jpg')";

        $result = mysqli_query($connect,$query);

        if($result){
            echo "<script>alert('You have successfully Applied')</script>";
            header("Location: doctorlogin.php");
            exit;
        }else{
            echo "<script>alert('Failed')</script>";
        }
    }
}

if(isset($error['apply'])){
    $s = $error['apply'];
    $show = "<h5 class='text-center alert alert-danger'>$s</h5>";
}else{
    $show = "";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Apply Now</title>
</head>
<body style="background-image: url(img/hospital.jfif); background-size:cover; background-repeat: no-repeat;">

<?php include("include/header.php"); ?>

<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 my-3 jumbotron">
                <h5 class="text-center">Apply Now!!!</h5>
                    <div>
                        <?php echo $show; ?>
                    </div>
                <form method="post">
                    <div class="form-group">
                        <label>Firstname</label>
                        <input type="text" name="fname" class="form-control" autocomplete="off" placeholder="Enter FirstName" value="<?php if(isset($_POST['fname'])) echo $_POST['fname']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Surname</label>
                        <input type="text" name="sname" class="form-control" autocomplete="off" placeholder="Enter Surname" value="<?php if(isset($_POST['sname'])) echo $_POST['sname']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" autocomplete="off" placeholder="Enter Username" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" autocomplete="off" placeholder="Enter Email Address" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Select Gender</label>
                        <select name="gender" class="form-control">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" autocomplete="off" placeholder="Enter Phone number" value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Select Country</label>
                        <select name="country" class="form-control">
                            <option value="">Select country</option>
                            <option value="Russia">Russia</option>
                            <option value="USA">USA</option>
                            <option value="Canada">Canada</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="pass" class="form-control" autocomplete="off" placeholder="Enter password">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="con_pass" class="form-control" autocomplete="off" placeholder="Please Confirm password">
                    </div>

                    <input type="submit" name="apply" value="Apply Now" class="btn btn-success">
                    <p>I already have an account <a href="doctorlogin.php">Click Here</a></p>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>
    
</body>
</html>
