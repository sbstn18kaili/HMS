<?php
session_start();
include("../include/connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Profile</title>
</head>
<body>

    <?php include("../include/header.php"); ?>

    <?php
    $ad = $_SESSION['admin'];

    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("s", $ad);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    
    $username = $row['username'];
    $profiles = $row['profile'];
    ?>

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left:-30px;">
                    <?php include("sidenav.php"); ?>
                </div>
                <div class="col-md-10">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <h4><?php echo htmlspecialchars($username); ?> Profile</h4>

                                <?php
                                if(isset($_POST['update'])){
                                    $profile = $_FILES['profile']['name'];

                                    if(!empty($profile)){
                                        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                                        $ext = pathinfo($profile, PATHINFO_EXTENSION);

                                        if(in_array($ext, $allowed_types)){
                                            $query = "UPDATE admin SET profile=? WHERE username=?";
                                            $stmt = $connect->prepare($query);
                                            $stmt->bind_param("ss", $profile, $ad);
                                            $result = $stmt->execute();

                                            if($result){
                                                move_uploaded_file($_FILES['profile']['tmp_name'], "img/$profile");
                                                echo "<h5 class='text-center alert alert-success'>Profile updated successfully</h5>";
                                            } else {
                                                echo "<h5 class='text-center alert alert-danger'>Failed to update profile</h5>";
                                            }
                                        } else {
                                            echo "<h5 class='text-center alert alert-danger'>Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.</h5>";
                                        }
                                    }
                                }
                                ?>

                                <form method="post" enctype="multipart/form-data">
                                    <img src='img/<?php echo htmlspecialchars($profiles); ?>' class='col-md-12' style='height:250px;'>
                                    <br><br>
                                    <div class="form-group">
                                        <label>UPDATE PROFILE</label>
                                        <input type="file" name="profile" class="form-control">
                                    </div>
                                    <br>
                                    <input type="submit" name="update" value="UPDATE" class="btn btn-success">
                                </form>
                            </div>

                            <div class="col-md-6">
                                <?php
                                if(isset($_POST['change'])){
                                    $new_username = trim($_POST['username']);
                                    
                                    if(!empty($new_username)){
                                        $query = "UPDATE admin SET username=? WHERE username=?";
                                        $stmt = $connect->prepare($query);
                                        $stmt->bind_param("ss", $new_username, $ad);

                                        if($stmt->execute()){
                                            $_SESSION['admin'] = $new_username;
                                            echo "<h5 class='text-center alert alert-success'>Username updated successfully</h5>";
                                        } else {
                                            echo "<h5 class='text-center alert alert-danger'>Failed to update username</h5>";
                                        }
                                    }
                                }
                                ?>

                                <form method="post">
                                    <label>Change Username</label>
                                    <input type="text" name="username" class="form-control" autocomplete="off"><br>
                                    <input type="submit" name="change" class="btn btn-success" value="Change">
                                </form>
                                <br>

                                <?php
                                if(isset($_POST['update_pass'])){
                                    $old_pass = $_POST['old_pass'];
                                    $new_pass = $_POST['new_pass'];
                                    $con_pass = $_POST['con_pass'];

                                    $error = array();

                                    $query = "SELECT password FROM admin WHERE username=?";
                                    $stmt = $connect->prepare($query);
                                    $stmt->bind_param("s", $ad);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $row = $res->fetch_assoc();

                                    if(empty($old_pass)){
                                        $error['p'] = "Enter Old Password";
                                    } else if(empty($new_pass)){
                                        $error['p'] = "Enter New Password";
                                    } else if(empty($con_pass)){
                                        $error['p'] = "Confirm Password";
                                    } else if(!password_verify($old_pass, $row['password'])){
                                        $error['p'] = "Invalid Old Password";
                                    } else if($new_pass != $con_pass){
                                        $error['p'] = "Passwords do not match";
                                    }

                                    if(count($error) == 0){
                                        $new_pass_hashed = password_hash($new_pass, PASSWORD_DEFAULT);
                                        $query = "UPDATE admin SET password=? WHERE username=?";
                                        $stmt = $connect->prepare($query);
                                        $stmt->bind_param("ss", $new_pass_hashed, $ad);

                                        if($stmt->execute()){
                                            echo "<h5 class='text-center alert alert-success'>Password updated successfully</h5>";
                                        } else {
                                            echo "<h5 class='text-center alert alert-danger'>Failed to update password</h5>";
                                        }
                                    } else {
                                        foreach($error as $err){
                                            echo "<h5 class='text-center alert alert-danger'>$err</h5>";
                                        }
                                    }
                                }
                                ?>

                                <form method="post">
                                    <h5 class="text-center my-4">Change Password</h5>

                                    <div class="form-group">
                                        <label>Old Password</label>
                                        <input type="password" name="old_pass" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" name="new_pass" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="con_pass" class="form-control">
                                    </div>

                                    <input type="submit" name="update_pass" value="Update Password" class="btn btn-success">
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
