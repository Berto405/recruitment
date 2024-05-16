<?php
include ('resend_verify_email_process.php');
$pageTitle = "Resend Email Verification";

include ('components/header.php');
?>

<section class="py-3 py-md-5 mt-5">
    <div class="container ">
        <div class="row justify-content-center ">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <div class="card border border-light-subtle rounded-3 shadow-sm">
                    <div class="card-body p-3 p-md-4 p-xl-5">
                        <div class="text-center mb-3">
                            <img src="img/images/topserveLogo.jpg" alt="Topserve Logo" width="150" height="50">
                        </div>
                        <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Resend Email Verification</h2>
                        <form action="" method="POST">
                            <div class="row gy-2 overflow-hidden">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="email" placeholder="Email"
                                            name="email" required>
                                        <label for="email" class="form-label">Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid my-3">
                                        <button class="btn btn-danger btn-lg" name="resendEmailBtn" type="submit">
                                            Submit
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include ('components/footer.php'); ?>