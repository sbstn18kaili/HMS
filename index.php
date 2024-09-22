<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS Home page</title>
</head>
<body>
<?php
include("include/header.php");

?>
<div style="margin-top: 50px"></div>

<div class="container">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3 mx-1 shadow">
                <img src="img/info.png" alt="" style="width:100%; height:190px;">
                <h5 class="text-center">For more information.... </h5>
                <a href="#">
                    <button class="btn btn-success my-3" style="margin-left:30%;">More Info</button>
                </a>
            </div>
            <div class="col-md-3 mx-1 shadow">
                <img src="img/patient.jfif" alt="" style="width:100%; height:190px;">
                <h5 class="text-center">Create Account so that you get treatment. </h5>
                <a href="account.php">
                    <button class="btn btn-success my-3" style="margin-left:30%;">Create Account</button>
                </a>
                </div>
            <div class="col-md-3 mx-1 shadow">
                <img src="img/doctor.jfif" alt="" style="width:100%; height:190px;">

                <h5 class="text-center">We are looking for Doctors </h5>
                <a href="#">
                    <button class="btn btn-success my-3" style="margin-left:30%;">Apply Now!!</button>
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>  