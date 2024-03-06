<?php
include('../header.php');
include('../dbconn.php');
?>

<h1>Welcome,
    <?php echo $_SESSION['user_name']; ?> admin
</h1>

<?php include('../footer.php'); ?>