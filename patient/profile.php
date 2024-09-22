<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Patient Profile</title>
</head>
<body>

<?php
include("../include/header.php");
include("../include/connection.php");
?>

<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2" style="margin-left:-30px;">
                <?php
                    include("sidenav.php");

                    $patient = $_SESSION['patient'];
                    $stmt = $connect->prepare("SELECT * FROM patient WHERE username = ?");
                    $stmt->bind_param("s", $patient);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $row = $res->fetch_assoc();
                ?>
            </div>
            <div class="col-md-10">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                                if(isset($_POST['upload'])){
                                    $img = $_FILES['img']['name'];
                                    $img_tmp = $_FILES['img']['tmp_name'];

                                    if(!empty($img)){
                                        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
                                        $ext = pathinfo($img, PATHINFO_EXTENSION);

                                        if(in_array($ext, $allowed_ext)){
                                            $query = "UPDATE patient SET profile=? WHERE username=?";
                                            $stmt = $connect->prepare($query);
                                            $stmt->bind_param("ss", $img, $patient);
                                            
                                            if($stmt->execute()){
                                                move_uploaded_file($img_tmp,"img/$img");
                                                echo "<script>alert('Profile updated successfully')</script>";
                                            } else {
                                                echo "<script>alert('Failed to update profile')</script>";
                                            }
                                        } else {
                                            echo "<script>alert('Invalid image file type')</script>";
                                        }
                                    }
                                }
                            ?>

                            <h5>My Profile</h5>
                            <form method="post" enctype="multipart/form-data">
                                <?php echo "<img src='img/".$row['profile']."' class='col-md-12' style='height:250px;'>"; ?>
                                <input type="file" name="img" class="form-control my-2">
                                <input type="submit" name="upload" class="btn btn-info" value="Update Profile">
                            </form>

                            <table class="table table-bordered">
                                <tr><th colspan="2" class="text-center">My Details</th></tr>
                                <tr><td>Firstname</td><td><?php echo htmlspecialchars($row['firstname']); ?></td></tr>
                                <tr><td>Surname</td><td><?php echo htmlspecialchars($row['surname']); ?></td></tr>
                                <tr><td>Username</td><td><?php echo htmlspecialchars($row['username']); ?></td></tr>
                                <tr><td>Email</td><td><?php echo htmlspecialchars($row['email']); ?></td></tr>
                                <tr><td>Phone Number</td><td><?php echo htmlspecialchars($row['phone']); ?></td></tr>
                                <tr><td>Gender</td><td><?php echo htmlspecialchars($row['gender']); ?></td></tr>
                                <tr><td>Country</td><td><?php echo htmlspecialchars($row['country']); ?></td></tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5 class="text-center">Change Username</h5>
                            <?php
                                if(isset($_POST['update'])){
                                    $username = $_POST['username'];
                                    if(!empty($username)){
                                        $query = "UPDATE patient SET username=? WHERE username=?";
                                        $stmt = $connect->prepare($query);
                                        $stmt->bind_param("ss", $username, $patient);

                                        if($stmt->execute()){
                                            $_SESSION['patient'] = $username;
                                            echo "<script>alert('Username updated successfully')</script>";
                                        } else {
                                            echo "<script>alert('Failed to update username')</script>";
                                        }
                                    } else {
                                        echo "<script>alert('Username cannot be empty')</script>";
                                    }
                                }
                            ?>

                            <form method="post">
                                <label>Enter Username</label>
                                <input type="text" name="username" class="form-control" autocomplete="off" placeholder="Enter username">
                                <input type="submit" name="update" class="btn btn-info my-2" value="Update Username">
                            </form>

                            <h5 class="my-4 text-center">Change Password</h5>
                            <?php
                                if(isset($_POST['change'])){
                                    $old = $_POST['old_pass'];
                                    $new = $_POST['new_pass'];
                                    $con = $_POST['con_pass'];

                                    $q = "SELECT * FROM patient WHERE username=?";
                                    $stmt = $connect->prepare($q);
                                    $stmt->bind_param("s", $patient);
                                    $stmt->execute();
                                    $re = $stmt->get_result();
                                    $row = $re->fetch_assoc();

                                    if(empty($old)){
                                        echo"<script>alert('Enter old password')</script>";
                                    } else if(empty($new)){
                                        echo"<script>alert('Enter new password')</script>";
                                    } else if($con != $new){
                                        echo"<script>alert('Password mismatch')</script>";
                                    } else if(!password_verify($old, $row['password'])){
                                        echo"<script>alert('Incorrect old password')</script>";
                                    } else {
                                        $new_hashed = password_hash($new, PASSWORD_DEFAULT);
                                        $query = "UPDATE patient SET password=? WHERE username=?";
                                        $stmt = $connect->prepare($query);
                                        $stmt->bind_param("ss", $new_hashed, $patient);

                                        if($stmt->execute()){
                                            echo "<script>alert('Password changed successfully')</script>";
                                        } else {
                                            echo "<script>alert('Failed to change password')</script>";
                                        }
                                    }
                                }
                            ?>

                            <form method="post">
                                <label>Old Password</label>
                                <input type="password" name="old_pass" class="form-control" autocomplete="off" placeholder="Enter old password">
                                
                                <label>New Password</label>
                                <input type="password" name="new_pass" class="form-control" autocomplete="off" placeholder="Enter new password">
                                    
                                <label>Confirm Password</label>
                                <input type="password" name="con_pass" class="form-control" autocomplete="off" placeholder="Confirm password">

                                <input type="submit" name="change" value="Change Password" class="btn btn-info">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
