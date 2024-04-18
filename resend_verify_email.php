<?php
include ('resend_verify_email_process.php');


include ('components/header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resend Email Verification</title>

</head>

<body style="background-color: #F4F4F4; ">
    <div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
        <div class="border-0 shadow bg-white" style="width: 30em;">
            <div class="card border-0 bg-transparent card_login">
                <div class="text-center mt-4">
                    <h2>Resend Email Verification</h2>
                </div>
                <div class="card-body">
                    <form action="resend_verify_email_process.php" method="POST">
                        <div class="col w-100 ">
                            <div class="mb-2">
                                <label for="email" class="form-label mt-3">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Email" name="email"
                                    required>
                            </div>
                        </div>
                        <div class="mb-2 d-flex justify-content-center mt-3">
                            <button class="btn btn-danger btn-fluid rounded-1 w-100 text-light" type="submit"
                                name="resendEmailBtn">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<?php include ('components/footer.php'); ?>