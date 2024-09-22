<?php
session_start();
include("../include/connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Administrators</title>
</head>
<body>

<?php include("../include/header.php"); ?>

<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2" style="margin-left: -30px;">
                <?php include("sidenav.php"); ?>
            </div>
            <div class="col-md-10">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-center">All Admin</h5>

                            <?php
                            $ad = $_SESSION['admin'];
                            $query = "SELECT * FROM admin WHERE username != ?";
                            $stmt = $connect->prepare($query);
                            $stmt->bind_param("s", $ad);
                            $stmt->execute();
                            $res = $stmt->get_result();

                            $output = "
                                <table class='table table-bordered'>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th style='width:10%;'>Action</th>
                                </tr>
                            ";

                            if ($res->num_rows < 1) {
                                $output .= "<tr><td colspan='3' class='text-center'>No New Admin</td></tr>";
                            } else {
                                while ($row = $res->fetch_assoc()) {
                                    $id = $row['id'];
                                    $username = htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8');
                                    
                                    $output .= "
                                        <tr>
                                            <td>$id</td>
                                            <td>$username</td>
                                            <td>
                                                <a href='admin.php?id=$id' onclick='return confirm(\"Are you sure you want to remove this admin?\");'><button id='$id' class='btn btn-danger remove'>Remove</button></a>
                                            </td>
                                        </tr>
                                    ";
                                }
                            }

                            $output .= "</table>";
                            echo $output;

                            if (isset($_GET['id'])) {
                                $id = intval($_GET['id']);
                                $query = "DELETE FROM admin WHERE id = ?";
                                $stmt = $connect->prepare($query);
                                $stmt->bind_param("i", $id);
                                $stmt->execute();

                                // Redirect after deletion
                                header("Location: admin.php");
                                exit();
                            }
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            if (isset($_POST['add'])) {
                                $username = trim($_POST['username']);
                                $password = $_POST['password'];
                                $image = $_FILES['img']['name'];
                                $image_tmp = $_FILES['img']['tmp_name'];
                                $error = array();

                                // Validate inputs
                                if (empty($username)) {
                                    $error['u'] = "Enter Admin Username";
                                } else if (empty($password)) {
                                    $error['u'] = "Enter Admin Password";
                                } else if (empty($image)) {
                                    $error['u'] = "Add Admin Picture";
                                } else if ($_FILES['img']['size'] > 500000) {
                                    $error['u'] = "File size should be less than 500KB";
                                } else {
                                    $allowed = array('jpg', 'jpeg', 'png', 'gif');
                                    $ext = pathinfo($image, PATHINFO_EXTENSION);
                                    if (!in_array($ext, $allowed)) {
                                        $error['u'] = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
                                    }
                                }

                                if (count($error) == 0) {
                                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                                    $q = "INSERT INTO admin(username, password, profile) VALUES (?, ?, ?)";
                                    $stmt = $connect->prepare($q);
                                    $stmt->bind_param("sss", $username, $hashedPassword, $image);

                                    if ($stmt->execute()) {
                                        move_uploaded_file($image_tmp, "img/$image");
                                        echo "<h5 class='text-center alert alert-success'>Admin added successfully</h5>";
                                    } else {
                                        echo "<h5 class='text-center alert alert-danger'>Failed to add admin</h5>";
                                    }
                                }

                                $show = isset($error['u']) ? "<h5 class='text-center alert alert-danger'>{$error['u']}</h5>" : "";
                            }
                            ?>

                            <h5 class="text-center">Add Admin</h5>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div><?php echo $show ?? ''; ?></div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" class="form-control" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                                <div class="form-group">
                                    <label for="img">Add Admin Picture</label>
                                    <input type="file" name="img" class="form-control">
                                </div>
                                <input type="submit" name="add" value="Add New Admin" class="btn btn-success">
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
