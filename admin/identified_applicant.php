<?php
include ('../admin/admin_header.php');
include ('../dbconn.php');

// Check if user is not logged in
if (!isset ($_SESSION['user_id']) || !isset ($_SESSION['user_role'])) {
    // Redirect users who are not logged in to the login page
    header("Location: ../login.php");
    exit();
}

// Check if user is not admin
if ($_SESSION['user_role'] !== 'admin') {
    // Redirect non-admin users to index.php
    header("Location: ../index.php");
    exit();
}
$query = "SELECT *
    FROM job_applicants
    INNER JOIN jobs ON job_applicants.job_id = jobs.id
    INNER JOIN user ON job_applicants.user_id = user.id
    WHERE job_applicants.application_status IN ('Hired', 'Ongoing Requirements', 'Onboarding', 'Waiting for Start Date', 'Placed')
    ORDER BY CASE WHEN jobs.priority = 'Urgent Hiring' THEN 0 ELSE 1 END
    ";

$result = mysqli_query($conn, $query);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identified Applicants</title>
    <style>
        #imagePreview {
            width: 1in;
            height: 1in;
            border: 1px solid #ccc;
            margin-top: 10px;
        }

        #imagePreview img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>

<body style="background-color: #F4F4F4; ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 col-lg-3 col-xl-2 bg-white  p-0 m-0 d-lg-block shadow " style="min-height: 91vh;">
                <?php include ("../admin/admin_sidebar.php"); ?>
            </div>
            <div class="col-md-10 col-lg-9 col-xl-10  mt-3">
                <h4 class=" mt-1 mb-5 ">Identified Applicants</h4>

                <div class="row">
                    <div class="col-md-6 col-lg-9">
                        <div class="float-start mb-2">
                            <a href="#" class="btn btn-transparent" id="allBtn" onclick="filterTable('All')">
                                All
                            </a>
                            <a href="#" class="btn btn-transparent" id="hiredBtn" onclick="filterTable('Hired')">
                                Hired
                            </a>
                            <a href="#" class="btn btn-transparent" id="ongoingRequirementsBtn"
                                onclick="filterTable('Ongoing Requirements')">
                                Ongoing Requirements
                            </a>
                            <a href="#" class="btn btn-transparent" id="onboardingBtn"
                                onclick="filterTable('Onboarding')">
                                Onboarding
                            </a>
                            <a href="#" class="btn btn-transparent" id="startDateBtn"
                                onclick="filterTable('Waiting for Start Date')">
                                Waiting for Start Date
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="float-end input-group mb-2">
                            <input id="searchInput" type="search" class="form-control" placeholder="Search"
                                aria-label="Search" name="search" oninput="search()">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                    </div>
                </div>


                <!-- Makes the table as component so that in can be reuse on Pooling, Shortlisted and Identified Applicants Sidebar -->
                <div class="table-responsive">
                    <?php include ('../components/applicants_table.php'); ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterTable(status) {
            var table, tr, td, i;
            table = document.getElementById("applicantTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all buttons and remove the 'active' class
            var buttons = document.getElementsByClassName("btn");
            for (i = 0; i < buttons.length; i++) {
                buttons[i].classList.remove("active");
            }

            // Add the 'active' class to the clicked button
            var activeBtn;
            if (status === "All") {
                activeBtn = document.getElementById("allBtn");
            } else if (status === "Hired") {
                activeBtn = document.getElementById("hiredBtn");
            } else if (status === "Ongoing Requirements") {
                activeBtn = document.getElementById("ongoingRequirementsBtn");
            } else if (status === "Onboarding") {
                activeBtn = document.getElementById("onboardingBtn");
            } else if (status === "Waiting for Start Date") {
                activeBtn = document.getElementById("startDateBtn");
            }
            activeBtn.classList.add("active");

            // Loop through all table rows, and show those that match the selected status or show all rows for "All" option
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[3]; // Modify this based on what column to sort (index 3 = Status column)
                if (td) {
                    if (status === "All" || td.textContent.trim() === status) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

    </script>
</body>

</html>

<?php include ('../footer.php'); ?>