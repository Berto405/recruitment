<?php
include ('src/user/backend/verify_phone_process.php');

$pageTitle = "Verify Phone Number";
include ('components/header.php');
?>

<?php
if (($row['phone_verified'] == 0 || $row['phone_verified'] == 1) && $row['otp'] == 0) {
    ?>

    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="border-0 shadow bg-white" style="width: 30em;">
            <div class="card border-0 bg-transparent card_login">

                <div class="rounded-circle bg-danger mx-2 mt-2  d-flex justify-content-center align-items-center shadow"
                    style="width: 50px; height: 50px;">
                    <i class="bi bi-exclamation-lg text-light" style="font-size: 24px;"></i>
                </div>

                <div class="card-body">
                    <h2 class="card-title">Verify Phone Number</h2>

                    <form action="" method="POST">


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
    <?php

} else if ($row['otp'] > 0) {
    ?>

        <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="border-0 shadow bg-white" style="width: 30em;">
                <div class="card border-0 bg-transparent card_login">
                    <div class="card-body">
                        <h5 class="card-title">
                            Please enter the one-time password sent to verify your phone number
                        </h5>
                        <div class="card-text">
                            <span>A code has been sent to</span>
                            <small>
                                <?php
                                $contact_number = $row['contact_number'];
                                $visible_digits = substr($contact_number, 0, 3); // Get the first three digits
                                $hidden_digits = substr($contact_number, 3, 4); // Get the next four digits
                                $masked_contact_number = str_repeat('*', 7) . $hidden_digits; // Replace the first seven digits with asterisks
                                echo $visible_digits . $masked_contact_number;
                                ?>
                            </small>
                        </div>

                        <form action="" method="POST">
                            <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                                <input class="m-2 text-center form-control rounded" type="text" name="firstNum" maxlength="1"
                                    required />
                                <input class="m-2 text-center form-control rounded" type="text" name="secondNum" maxlength="1"
                                    required />
                                <input class="m-2 text-center form-control rounded" type="text" name="thirdNum" maxlength="1"
                                    required />
                                <input class="m-2 text-center form-control rounded" type="text" name="fourthNum" maxlength="1"
                                    required />
                                <input class="m-2 text-center form-control rounded" type="text" name="fifthNum" maxlength="1"
                                    required />
                                <input class="m-2 text-center form-control rounded" type="text" name="sixthNum" maxlength="1"
                                    required />
                            </div>
                            <div class="mt-4 d-flex flex-row justify-content-center">
                                <button type="submi" class="btn btn-danger px-4 validate" name="validateBtn">
                                    Validate
                                </button>
                            </div>
                            <div class="text-center mt-2">
                                <small>
                                    *You'll need to wait 5 minutes before attempting to resend the code.
                                </small>
                            </div>
                        </form>
                    </div>



                </div>
            </div>
        </div>
    <?php
}
?>


<?php include ('components/footer.php'); ?>