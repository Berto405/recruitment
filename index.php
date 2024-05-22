<?php
$request = $_SERVER['REQUEST_URI'];

$queryString = parse_url($request, PHP_URL_QUERY);
parse_str($queryString, $queryParams);

$location = isset($queryParams['loc']) ? $queryParams['loc'] : null;
$industry = isset($queryParams['industry']) ? $queryParams['industry'] : null;
$type = isset($queryParams['type']) ? $queryParams['type'] : null;

switch ($request) {
    //---------------------------------------------------------------------------------------------------------------
    //SHARED 
    case '/recruitment/login':
        require __DIR__ . "/src/shared/frontend/login.php";
        break;
    case '/recruitment/register':
        require __DIR__ . "/src/shared/frontend/register.php";
        break;
    case '/recruitment/resend_verify_email':
        require __DIR__ . "/src/shared/frontend/resend_verify_email.php";
        break;
    case '/recruitment/home':
        require __DIR__ . "/src/shared/frontend/home.php";
        break;
    case '/recruitment/profile':
        require __DIR__ . "/src/shared/frontend/profile.php";
        break;

    //---------------------------------------------------------------------------------------------------------------
    //USER
    case '/recruitment/my_jobs':
        require __DIR__ . "/src/user/frontend/my_jobs.php";
        break;
    case '/recruitment/my_resume':
        require __DIR__ . "/src/user/frontend/my_resume.php";
        break;
    case '/recruitment/submit_application':
        require __DIR__ . "/src/user/frontend/submit_application.php";
        break;
    case '/recruitment/verify_phone':
        require __DIR__ . "/src/user/frontend/verify_phone.php";
        break;

    //---------------------------------------------------------------------------------------------------------------
    //ADMIN 
    case '/recruitment/admin/dashboard':
        require __DIR__ . "/src/admin/frontend/dashboard.php";
        break;
    case '/recruitment/admin/pooling_applicant':
        require __DIR__ . "/src/admin/frontend/pooling_applicant.php";
        break;
    case '/recruitment/admin/shortlisted_applicant':
        require __DIR__ . "/src/admin/frontend/shortlisted_applicant.php";
        break;
    case '/recruitment/admin/identified_applicant':
        require __DIR__ . "/src/admin/frontend/identified_applicant.php";
        break;
    case '/recruitment/admin/placed_applicant':
        require __DIR__ . "/src/admin/frontend/placed_applicant.php";
        break;
    case '/recruitment/admin/failed_applicant':
        require __DIR__ . "/src/admin/frontend/failed_applicant.php";
        break;
    case '/recruitment/admin/backout_applicant':
        require __DIR__ . "/src/admin/frontend/backout_applicant.php";
        break;
    case '/recruitment/admin/mrf_list':
        require __DIR__ . "/src/admin/frontend/mrf_list.php";
        break;
    case '/recruitment/admin/interview_calendar':
        require __DIR__ . "/src/admin/frontend/interview_calendar.php";
        break;
    case '/recruitment/admin/manage_user':
        require __DIR__ . "/src/admin/frontend/manage_user.php";
        break;
    default:
        if ($location || $industry || $type) {
            require __DIR__ . "/src/shared/frontend/home.php";
        } else {
            http_response_code(404);
            require __DIR__ . "/src/shared/frontend/404.php";
        }
        break;
}
?>