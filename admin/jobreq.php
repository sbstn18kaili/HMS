<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Job Request</title>
    <!-- Add other necessary meta tags, CSS links, etc. -->
</head>
<body>

<?php
    include("../include/header.php");
?>

<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2" style="margin-left: -30px;">
                <?php
                    include("sidenav.php");
                ?>
            </div>
            <div class="col-md-10">
                <h5 class="text-center my">Job Request</h5>

                <div id="show"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        show();

        function show(){
            $.ajax({
                url: "ajax_jobreq.php",
                method: "POST",
                success: function(data){
                    $("#show").html(data);
                }
            });
        }

        // Corrected the click event handler
        $(document).on('click', '.approve', function() {

            var id = $(this).attr("id");

            
            $.ajax({
                url:"ajax_approve.php",
                method:"POST",
                data:{id:id},
                success:function(data){
                    show();
                }
            });
        });

        $(document).on('click', '.reject', function() {

            var id = $(this).attr("id");


        $.ajax({
            url:"ajax_reject.php",
            method:"POST",
            data:{id:id},
            success:function(data){
                show();
                }
            });
        });
    });
</script>
    
</body>
</html>
