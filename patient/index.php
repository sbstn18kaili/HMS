<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Patient Dashboard</title>
</head>
<body>

<?php
include("../include/header.php");
include("../include/connection.php");
?>

<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2" style="margin-left: -30px;">
                <?php include("sidenav.php"); ?>
            </div>

            <div class="col-md-10">
                <h5 class="my-3">Patient Dashboard</h5>

                <!-- Dashboard Boxes -->
                <div class="col-md-12">
                    <div class="row">
                        <!-- Profile Box -->
                        <div class="col-md-3 bg-info mx-2" style="height: 150px;">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5 class="text-white my-4">My Profile</h5>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="profile.php">
                                            <i class="fa fa-user-circle fa-3x my-4" style="color:white;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Book Appointment Box -->
                        <div class="col-md-3 bg-warning mx-2" style="height: 150px;">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5 class="text-white my-4">Book Appointment</h5>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="appointment.php">
                                            <i class="fa fa-calendar fa-3x my-4" style="color:white;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Invoice Box -->
                        <div class="col-md-3 bg-success mx-2" style="height: 150px;">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5 class="text-white my-4">My Invoice</h5>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="invoice.php">
                                            <i class="fas fa-file-invoice-dollar fa-3x my-4" style="color:white;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form to Send Report -->
                <?php
                if(isset($_POST['send'])){
                    $title = $_POST['title'];
                    $message = $_POST['message'];

                    if(empty($title)){
                        echo "<script>alert('Title is required')</script>";
                    } else if(empty($message)){
                        echo "<script>alert('Message is required')</script>";
                    } else {
                        $user = $_SESSION['patient'];

                        $stmt = $connect->prepare("INSERT INTO report(title,message,username,date_send) VALUES (?, ?, ?, NOW())");
                        $stmt->bind_param("sss", $title, $message, $user);

                        if($stmt->execute()){
                            echo "<script>alert('You have sent your report')</script>";
                        } else {
                            echo "<script>alert('Failed to send report')</script>";
                        }

                        $stmt->close();
                    }
                }
                ?>

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6 jumbotron bg-info my-5">
                            <h5 class="text-center my-2">Send a Report</h5>
                            <form method="post">
                                <label>Title</label>
                                <input type="text" name="title" autocomplete="off" class="form-control" placeholder="Enter Title of Report">

                                <label>Message</label>
                                <input type="text" name="message" autocomplete="off" class="form-control" placeholder="Enter message">

                                <input type="submit" name="send" value="Send Report" class="btn btn-success my-2">
                            </form>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
</body>
</html>
