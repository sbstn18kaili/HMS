<?php
session_start();
include("../include/connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctor's Profile</title>
</head>
<body>

<?php include("../include/header.php"); ?>

<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2" style="margin-left:-30px;">
                <?php include("sidenav.php"); ?>
            </div>
            <div class="col-md-10">
                <div class="container-fluid">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                $doc = $_SESSION['doctor'];
                                $query = "SELECT * FROM doctors WHERE username=?";
                                $stmt = $connect->prepare($query);
                                $stmt->bind_param("s", $doc);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                $row = $res->fetch_assoc();

                                if (isset($_POST['upload'])) {
                                    $img = $_FILES['img']['name'];
                                    $tmp_name = $_FILES['img']['tmp_name'];
                                    $error = array();

                                    if (empty($img)) {
                                        $error['img'] = "Please choose a file";
                                    } else {
                                        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                                        $ext = pathinfo($img, PATHINFO_EXTENSION);

                                        if (!in_array($ext, $allowed)) {
                                            $error['img'] = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
                                        } else {
                                            $query = "UPDATE doctors SET profile=? WHERE username=?";
                                            $stmt = $connect->prepare($query);
                                            $stmt->bind_param("ss", $img, $doc);

                                            if ($stmt->execute()) {
                                                move_uploaded_file($tmp_name, "img/$img");
                                                echo "<h5 class='text-center alert alert-success'>Profile updated successfully</h5>";
                                            } else {
                                                echo "<h5 class='text-center alert alert-danger'>Failed to update profile</h5>";
                                            }
                                        }
                                    }

                                    if (isset($error['img'])) {
                                        echo "<h5 class='text-center alert alert-danger'>{$error['img']}</h5>";
                                    }
                                }
                                ?>

                                <form method="post" enctype="multipart/form-data">
                                    <?php
                                    echo "<img src='img/" . htmlspecialchars($row['profile'], ENT_QUOTES, 'UTF-8') . "' style='height:250px;' class='col-md-12 my-3'>";
                                    ?>
                                    <input type="file" name="img" class="form-control my-1">
                                    <input type="submit" name="upload" class="btn btn-success" value="Update Profile">
                                </form>

                                <div class="my-5">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th colspan="2" class="text-center">Details</th>
                                        </tr>
                                        <tr>
                                            <td>Firstname</td>
                                            <td><?php echo htmlspecialchars($row['firstname'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Surname</td>
                                            <td><?php echo htmlspecialchars($row['surname'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Username</td>
                                            <td><?php echo htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td><?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Phone No</td>
                                            <td><?php echo htmlspecialchars($row['phone'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Gender</td>
                                            <td><?php echo htmlspecialchars($row['gender'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Country</td>
                                            <td><?php echo htmlspecialchars($row['country'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Salary</td>
                                            <td><?php echo "$" . htmlspecialchars($row['salary'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <h5 class="text-center my-2">Change Username</h5>

                                <?php
                                if (isset($_POST['change_username'])) {
                                    $username = trim($_POST['username']);
                                    $error = array();

                                    if (empty($username)) {
                                        $error['username'] = "Enter a username";
                                    } else {
                                        $query = "UPDATE doctors SET username=? WHERE username=?";
                                        $stmt = $connect->prepare($query);
                                        $stmt->bind_param("ss", $username, $doc);

                                        if ($stmt->execute()) {
                                            $_SESSION['doctor'] = $username;
                                            echo "<h5 class='text-center alert alert-success'>Username updated successfully</h5>";
                                        } else {
                                            echo "<h5 class='text-center alert alert-danger'>Failed to update username</h5>";
                                        }
                                    }

                                    if (isset($error['username'])) {
                                        echo "<h5 class='text-center alert alert-danger'>{$error['username']}</h5>";
                                    }
                                }
                                ?>

                                <form method="post">
                                    <label>Change Username</label>
                                    <input type="text" name="username" class="form-control" autocomplete="off" placeholder="Enter username"><br>
                                    <input type="submit" name="change_username" class="btn btn-success" value="Change Username">
                                </form><br><br>

                                <h5 class="text-center my-2">Change Password</h5>

                                <?php
                                if (isset($_POST['change_pass'])) {
                                    $old = $_POST['old_pass'];
                                    $new = $_POST['new_pass'];
                                    $con = $_POST['con_pass'];
                                    $error = array();

                                    $ol = "SELECT * FROM doctors WHERE username=?";
                                    $stmt = $connect->prepare($ol);
                                    $stmt->bind_param("s", $doc);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $row = $res->fetch_assoc();

                                    if (!password_verify($old, $row['password'])) {
                                        $error['old_pass'] = "Incorrect old password";
                                    } else if (empty($new)) {
                                        $error['new_pass'] = "Enter a new password";
                                    } else if ($con != $new) {
                                        $error['con_pass'] = "Passwords do not match";
                                    } else {
                                        $new_hashed = password_hash($new, PASSWORD_DEFAULT);
                                        $query = "UPDATE doctors SET password=? WHERE username=?";
                                        $stmt = $connect->prepare($query);
                                        $stmt->bind_param("ss", $new_hashed, $doc);

                                        if ($stmt->execute()) {
                                            echo "<h5 class='text-center alert alert-success'>Password updated successfully</h5>";
                                        } else {
                                            echo "<h5 class='text-center alert alert-danger'>Failed to update password</h5>";
                                        }
                                    }

                                    foreach ($error as $err) {
                                        echo "<h5 class='text-center alert alert-danger'>$err</h5>";
                                    }
                                }
                                ?>

                                <form method="post">
                                    <div class="form-group">
                                        <label>Old Password</label>
                                        <input type="password" name="old_pass" class="form-control" autocomplete="off" placeholder="Enter old Password">
                                    </div>
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" name="new_pass" class="form-control" autocomplete="off" placeholder="Enter new Password">
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="con_pass" class="form-control" autocomplete="off" placeholder="Please Confirm Password">
                                    </div>

                                    <input type="submit" name="change_pass" class="btn btn-info" value="Change Password">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
