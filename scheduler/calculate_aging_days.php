<?php
include ("../dbconn.php");

// Set the session time zone to Philippine time
$conn->query("SET time_zone = '+08:00'");

// SQL query to create the event
$query = "CREATE EVENT calculate_aging_days
    ON SCHEDULE EVERY 1 DAY
    DO
    BEGIN
        -- Update the aging_days column for records where mrf_status is not 'Close'
        UPDATE mrfs 
        SET aging_days = FLOOR(DATEDIFF(NOW(), request_date))
        WHERE mrf_status != 'Close';
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