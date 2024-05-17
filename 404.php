<?php
$pageTitle = "Page Not Found";

include ("components/header.php");
?>

<div class="fixed-bottom ">
    <img src="img/images/wave.svg" alt="">
</div>

<section
    class="d-flex justify-content-center align-items-center position-absolute top-50 start-50 translate-middle fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <h2 class="d-flex justify-content-center align-items-center gap-2 mb-4">
                        <span class="display-1 fw-bold">4</span>
                        <i class="bi bi-exclamation-circle-fill text-danger display-4"></i>
                        <span class="display-1 fw-bold bsb-flip-h">4</span>
                    </h2>
                    <h3 class="h2 mb-2">Oops! You're lost.</h3>
                    <p class="mb-5">The page you are looking for was not found.</p>
                    <a class="btn bsb-btn-5xl btn-danger rounded-pill px-5 fs-6 m-0" href="/recruitment/" role="button">
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<?php include ("components/footer.php"); ?>