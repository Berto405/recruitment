<?php
include('../header.php');
include('../dbconn.php');
?>


<div class="flex-grow-1">
    <h1>Welcome,
        <?php echo $_SESSION['user_name']; ?> user
    </h1>
</div>


<?php include('../footer.php'); ?>