<?php
include("../check_session.php");
include('../header.php');
include('../dbconn.php');
?>

<h1>Welcome,
    <?php echo $_SESSION['user_name']; ?> admin
</h1>

<form action="../logout.php" method="POST">
    <button type="submit">Logout</button>
</form>

<?php include('../footer.php'); ?>