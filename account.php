<?php
include("include/connection.php");

if(isset($_POST['create'])){
    
    $fname = $_POST['fname'];
    $sname = $_POST['sname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $country = $_POST['country'];
    $password = $_POST['password'];
    $con_pass = $_POST['con_pass'];

    $error = array();

    if(empty($fname)){
        $error['ac'] = "Enter Firstname";
    }else if(empty($sname)){
        $error['ac'] = "Enter Surname";
    }else if(empty($username)){
        $error['ac'] = "Enter username";
    }else if(empty($email)){
        $error['ac'] = "Enter Email";
    }else if(empty($phone)){
        $error['ac'] = "Enter Phone number";
    }else if(empty($gender)){
        $error['ac'] = "Select Your Gender";
    }else if(empty($country)){
        $error['ac'] = "Select Your Country";
    }else if(empty($password)){
        $error['ac'] = "Enter Password";
    }else if($con_pass != $password){
        $error['ac'] = "Password Mismatch";
    }

    if(count($error)==0){
        $query = "INSERT INTO patient (firstname, surname, username, email, phone, gender, country, password, date_reg, profile) VALUES('$fname','$sname','$username','$email','$phone','$gender','$country','$password',NOW(),'patient.jpg')";

        $res = mysqli_query($connect,$query);

        if($res){
            header("Location:patientlogin.php");
        }else{
            echo "<script>alert('failed')</script>";
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create account</title>
</head>
<body style="background-image: url(img/hospital.jfif); backgorund-repeat: no-repeat; background-size: cover;">
    
<?php
include("include/header.php");

?>

<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 my-2 jumbotron">
                <h5 class="text-center text-info my-2">Create Account</h5>

                <form method="post">
                    <div class="form-group">
                        <label>Firstname</label>
                        <input type="text" name="fname" class="form-control" autocomplete="off" placeholder="Enter firstname">
                    </div>

                    <div class="form-group">
                        <label>Surname</label>
                        <input type="text" name="sname" class="form-control" autocomplete="off" placeholder="Enter surname">
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" autocomplete="off" placeholder="Enter username">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" autocomplete="off" placeholder="Enter email">
                    </div>

                    <div class="form-group">
                        <label>Phone No</label>
                        <input type="number" name="phone" class="form-control" autocomplete="off" placeholder="Enter Phone number">
                    </div>

                    <div class="form-group">
                        <label>Gender</label>
                        <select name="gender" class="form-control">
                            <option value="">Select Your Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Country</label>
                        <select name="country" class="form-control">
                            <option value="">Select Your country</option>
                            <option value="USA">USA</option>
                            <option value="Brazil">Brazil</option>
                            <option value="Taiwan">Taiwan</option>
                            <option value="Russia">Russia</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" autocomplete="off" placeholder="Enter Password">
                    </div>

                    <div class="form-group">
                        <label>Confirm password</label>
                        <input type="password" name="con_pass" class="form-control" autocomplete="off" placeholder="Confirm password">
                    </div>

                    <input type="submit" name="create" value="create account" class="btn btn-info">
                    <p>I already have an account <a href="patientlogin.php">Click Here.</a></p>

                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>

</body>
</html>