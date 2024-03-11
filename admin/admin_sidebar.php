<div class=" p-1">
    <ul class="nav flex-column   " style="font-size:16px;">
        <li>
            <a href="../admin/home.php"
                class="nav-link p-2 ps-4 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/home.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/home.php/') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                <i class=" bi bi-house-fill me-2"></i>Dashboard
            </a>
        </li>
        <li>
            <a href="../admin/add_job.php"
                class="nav-link p-2 ps-4 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/add_job.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/add_job.php/') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                <i class="bi bi-briefcase-fill me-2"></i>Add Jobs
            </a>
        </li>
        <li>
            <a href="../admin/applicants.php"
                class="nav-link p-2 ps-4 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/applicants.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/applicants.php/') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                <i class="bi bi-card-checklist me-2"></i>Applicants
            </a>
        </li>
        <li>
            <a href="../admin/manage_user.php"
                class="nav-link p-2 ps-4 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/manage_user.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/manage_user.php/') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                <i class="bi bi-people-fill me-2"></i>User Management
            </a>
        </li>
    </ul>
</div>