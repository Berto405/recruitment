<?php
include ('verify_phone_process.php');


include ('components/header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Phone Number</title>

</head>

<body style="background-color: #F4F4F4; ">
    <div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
        <div class="border-0 shadow bg-white" style="width: 30em;">
            <div class="card border-0 bg-transparent card_login">

                <div class="rounded-circle bg-danger mx-2 mt-2  d-flex justify-content-center align-items-center shadow"
                    style="width: 50px; height: 50px;">
                    <i class="bi bi-exclamation-lg text-light" style="font-size: 24px;"></i>
                </div>

                <div class="card-body">
                    <h2 class="card-title">Verify Phone Number</h2>



                    <form action="verify_phone_process.php" method="POST">
                        <div class="col w-100 ">
                            <div class="mb-2">
                                <label for="phoneNumer" class="form-label mt-3">Phone Number</label>
                                <input type="text" class="form-control" value="<?php echo $row['contact_number'] ?>"
                                    name="phoneNumer" disabled>
                            </div>
                        </div>

                        <div class="container mb-2  mt-3">
                            <?php
                            if ($row['phone_verified'] == 0) {
                                ?>
                                <span class="badge text-bg-danger text-dark  bg-opacity-50 mb-2">
                                    Your phone number is not verified. Please verify.
                                </span>

                                <div class="row">
                                    <button
                                        class="btn btn-danger btn-fluid rounded-1 w-100 text-light  d-flex justify-content-center"
                                        type="submit" name="sentOtpBtn">
                                        Send OTP
                                    </button>
                                </div>


                                <?php
                            } else {
                                ?>
                                <span class="badge text-bg-success text-dark  bg-opacity-50">
                                    Your phone number is verified!
                                </span>
                                <?php
                            }
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>

        document.getElementById("sentOtpBtn").addEventListener("click", function (event) {
            event.preventDefault(); // Prevent the default form submission

            // Submit the form programmatically
            document.getElementById("phoneVerificationForm").submit();

            // Once the form is submitted, disable the button
            disableButton();
        });
        function disableButton() {
            var button = document.getElementById("sentOtpBtn");
            button.disabled = true; // Disable the button

            // Enable the button after 5 minutes
            setTimeout(function () {
                button.disabled = false; // Enable the button
            }, 5 * 60 * 1000); // 5 minutes in milliseconds
        }

    </script>
</body>

</html>

<?php include ('components/footer.php'); ?>