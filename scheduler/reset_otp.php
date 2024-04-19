<?php
include ("../dbconn.php");

// Set the session time zone to Philippine time
$conn->query("SET time_zone = '+08:00'");

// SQL query to create the event
$query = "CREATE EVENT reset_otp
    ON SCHEDULE EVERY 1 MINUTE
    DO
    BEGIN
        UPDATE user_resumes
        SET otp = 0
        WHERE TIMESTAMPDIFF(MINUTE, otp_timestamp, NOW()) >= 5
        AND otp > 1;
    END";

// Execute the query directly
if ($conn->query($query) === TRUE) {
    echo "Event created successfully";
} else {
    echo "Error creating event: " . $conn->error;
}

// Close the connection
$conn->close();
?>