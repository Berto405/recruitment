<style>
    .accordion .nav-link:hover {
        background-color: rgba(220, 53, 69, 0.25);
        color: #dc3545;
    }
</style>
<div class="accordion p-1" id="accordionExample">
    <ul class="nav flex-column mt-5">
        <li>
            <a href="../admin/home.php"
                class="nav-link p-2 ps-4 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/home.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/home.php/') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                <i class="bi bi-house-fill me-2"></i>Dashboard
            </a>
        </li>
        <li>
            <a href="#"
                class="nav-link  bg-opacity-25 p-2 ps-4 text-danger <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/pooling_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/shortlisted_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/identified_applicant.php') ? 'bg-danger' : ''; ?>"
                data-bs-toggle="collapse" data-bs-target="#manageApplicantCollapse" aria-expanded="true">
                <i class="bi bi-person-vcard-fill me-2"></i>Manage Applicants<i
                    class="bi bi-chevron-down me-2 float-end"></i>
            </a>
        </li>
        <div class="collapse <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/pooling_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/shortlisted_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/identified_applicant.php') ? 'show' : ''; ?>"
            id="manageApplicantCollapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal m-0 mb-2 p-0">
                <li class="my-1  bg-container text-white">
                    <a href="../admin/pooling_applicant.php"
                        class="nav-link p-2 ps-4 ps-5 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/pooling_applicant.php') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                        <i class="bi bi-people-fill me-2"></i>Pooling
                    </a>
                </li>
                <li class="my-1 menu_">
                    <a href="../admin/shortlisted_applicant.php"
                        class="nav-link p-2 ps-4 ps-5 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/shortlisted_applicant.php') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                        <i class="bi bi-file-plus-fill me-2"></i>Shortlisted
                    </a>
                </li>
                <li class="my-1 ">
                    <a href="../admin/identified_applicant.php"
                        class="nav-link p-2 ps-4 ps-5 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/identified_applicant.php') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                        <i class="bi bi-file-earmark-check-fill me-2"></i>Identified
                    </a>
                </li>
            </ul>
        </div>

        <li>
            <a href="#"
                class="nav-link  bg-opacity-25 p-2 ps-4 text-danger <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/add_job.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/jobs_list.php') ? 'bg-danger' : ''; ?>"
                data-bs-toggle="collapse" data-bs-target="#manageJobsCollapse" aria-expanded="true">
                <i class="bi bi-file-text-fill me-2"></i>Manage Jobs<i class="bi bi-chevron-down me-2 float-end"></i>
            </a>
        </li>
        <div class="collapse <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/add_job.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/jobs_list.php') ? 'show' : ''; ?>"
            id="manageJobsCollapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal m-0 mb-2 p-0">
                <li class="my-1  bg-container text-white">
                    <a href="../admin/add_job.php"
                        class="nav-link p-2 ps-4 ps-5 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/add_job.php') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                        <i class="bi bi-plus-square-fill me-2"></i>Add Jobs
                    </a>
                </li>
                <li class="my-1 menu_">
                    <a href="../admin/jobs_list.php"
                        class="nav-link p-2 ps-4 ps-5 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/jobs_list.php') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                        <i class="bi bi-briefcase-fill me-2"></i>Jobs List
                    </a>
                </li>
            </ul>
        </div>

        <li>
            <a href="../admin/applicants.php"
                class="nav-link p-2 ps-4 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/applicants.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/applicants.php/') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                <i class="bi bi-card-checklist me-2"></i>Applicants
            </a>
        </li>
        <li>
            <a href="../admin/interview_calendar.php"
                class="nav-link p-2 ps-4 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/interview_calendar.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/interview_calendar.php/') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                <i class="bi bi-calendar-fill me-2"></i>Interview Calendar
            </a>
        </li>
        <?php
        if ($_SESSION['user_role'] == 'Super Admin') {
            ?>
            <li>
                <a href="../admin/manage_user.php"
                    class="nav-link p-2 ps-4 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/manage_user.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/manage_user.php/') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                    <i class="bi bi-person-fill-gear me-2"></i>User Management
                </a>
            </li>
            <?php
        }
        ?>

    </ul>
</div>