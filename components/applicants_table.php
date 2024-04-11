<!-- DataTable CDN -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
<!-- DataTable JS - CDN Link -->
<script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>


<tbody style="height: 250px;">
    <?php
    while ($row = mysqli_fetch_assoc($result)) {

        //For showing the users resume
        $resumeQuery = "SELECT *
                FROM user_resumes
                LEFT JOIN educational_attainment ON user_resumes.user_id = educational_attainment.user_id
                LEFT JOIN employment_background ON user_resumes.user_id = employment_background.user_id
                LEFT JOIN lectures_and_seminars_attended ON user_resumes.user_id = lectures_and_seminars_attended.user_id
                LEFT JOIN character_references ON user_resumes.user_id = character_references.user_id
                WHERE user_resumes.user_id = ?
            ";
        $resumeStmt = $conn->prepare($resumeQuery);
        $resumeStmt->bind_param("i", $row["user_id"]);
        $resumeStmt->execute();
        $resumeResult = $resumeStmt->get_result();
        $resumeRow = $resumeResult->fetch_assoc();

        ?>
        <tr>
            <!-- Checkbox -->
            <td class="text-center">
                <div class="form-check d-flex justify-content-center ">
                    <input class="form-check-input  border border-1 border-dark" type="checkbox" name="checkbox_value[]"
                        value="<?php echo $row['id']; ?>">
                </div>
            </td>

            <!-- Applicant's Name -->
            <td>
                <?php echo $row['first_name'] . ' ' . $row['first_name']; ?>
            </td>

            <!-- Job Position -->
            <td>
                <?php
                if ($row['application_status'] == 'Pooling') {
                    // Show the button if job_id is 0
                    ?>
                    <button type="button" class="btn btn-primary badge" data-bs-toggle="modal"
                        data-bs-target="#viewMRFModal<?php echo $row['id']; ?>">
                        View MRF List
                    </button>
                    <?php
                } else {
                    // Otherwise, display the job name with appropriate icon based on priority
                    if ($row['priority'] == 'Urgent Hiring') {
                        ?>
                        <i class="bi bi-exclamation-circle-fill text-danger"></i>
                        <?php
                    }
                    echo $row['job_name'];
                }
                ?>
            </td>

            <!-- MRF List Modal -->
            <div class="modal fade" tabindex="-1" role="dialog" id="viewMRFModal<?php echo $row['id']; ?>"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content rounded-4 shadow">
                        <div class="modal-header p-5 pb-4 border-bottom-0">
                            <h1 class="fw-bold mb-0 fs-2">Jobs/MRFs List</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body p-5 pt-0">
                            <form action="" method="POST" class="">
                                <input type="hidden" name="applicant_id" value="<?php echo $row['id']; ?>">
                                <div class="form-floating mb-3">
                                    <select class="form-select" name="jobSelect" id="jobSelect" required>
                                        <option selected disabled>Choose...</option>
                                        <?php
                                        $jobListQuery = "SELECT id, job_name FROM jobs ORDER BY CASE WHEN jobs.priority = 'Urgent Hiring' THEN 0 ELSE 1 END";
                                        $stmt = $conn->prepare($jobListQuery);
                                        $stmt->execute();
                                        $jobListResult = $stmt->get_result();

                                        while ($jobListRow = $jobListResult->fetch_assoc()) {
                                            ?>
                                            <option value="<?php echo $jobListRow['id']; ?>">
                                                <?php echo $jobListRow['job_name']; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <label for="priority" class="form-label fw-bold">Job/MRF</label>
                                </div>

                                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-danger" name="assignJobBtn"
                                    type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Location -->
            <td>
                <?php
                if ($row['application_status'] !== 'Pooling') {
                    echo $row['location'];
                }
                ?>
            </td>

            <!-- Application Status -->
            <td>
                <?php
                $status = $row['application_status'];

                switch ($status) {
                    case 'Pending':
                        ?>
                        <span class=" badge badge border border-secondary text-secondary ">
                            <i class="bi bi-clock-history me-1"></i>Pending
                        </span>
                        <?php
                        break;
                    case 'Pooling':
                        ?>
                        <span class=" badge badge border border-primary text-primary ">
                            <i class="bi bi-file-earmark-break me-1"></i>Pooling
                        </span>
                        <?php
                        break;
                    case 'Pooled':
                        ?>
                        <span class=" badge badge border border-info text-info ">
                            <i class="bi bi-file-earmark-break me-1"></i>Pooled
                        </span>
                        <?php
                        break;
                    case 'Passed':
                        ?>
                        <span class=" badge badge border border-secondary text-secondary ">
                            <i class="bi bi-check-square-fill me-1"></i>Passed
                        </span>
                        <?php
                        break;
                    case 'For Initial Interview':
                        ?>
                        <span class=" badge badge border border-info text-info ">
                            <i class="bi bi-calendar-check-fill me-1"></i>For Initial Interview
                        </span>
                        <?php
                        break;
                    case 'For Final Interview':
                        ?>
                        <span class=" badge badge border border-dark text-dark ">
                            <i class="bi bi-calendar-check-fill me-1"></i>For Final Interview
                        </span>
                        <?php
                        break;
                    case 'Waiting for Feedback':
                        ?>
                        <span class=" badge badge border border-primary text-primary ">
                            <i class="bi bi-clock-fill me-1"></i>Waiting for Feedback
                        </span>
                        <?php
                        break;
                    case 'Hired':
                        ?>
                        <span class=" badge badge border border-secondary text-secondary ">
                            <i class="bi bi-check-square-fill me-1"></i>Hired
                        </span>
                        <?php
                        break;
                    case 'Back to Pooling':
                        ?>
                        <span class=" badge badge border border-dark text-dark ">
                            <i class="bi bi-exclamation-diamond-fill me-1"></i>Back to Pooling
                        </span>
                        <?php
                        break;
                    case 'Failed':
                        ?>
                        <span class=" badge badge border border-danger text-danger ">
                            <i class="bi bi-x-square-fill me-1"></i>Failed
                        </span>
                        <?php
                        break;
                    case 'Ongoing Requirements':
                        ?>
                        <span class=" badge badge border border-warning text-warning ">
                            <i class="bi bi-arrow-clockwise me-1"></i>Ongoing Requirements
                        </span>
                        <?php
                        break;
                    case 'Onboarding':
                        ?>
                        <span class=" badge badge border border-info text-info ">
                            <i class="bi bi-hand-thumbs-up-fill me-1"></i>Onboarding
                        </span>
                        <?php
                        break;
                    case 'Waiting for Start Date':
                        ?>
                        <span class=" badge badge border border-primary text-primary ">
                            <i class="bi bi-clock-fill me-1"></i>Waiting for Start Date
                        </span>
                        <?php
                        break;
                    case 'Placed':
                        ?>
                        <span class=" badge badge border border-success text-success ">
                            <i class="bi bi-check-square-fill me-1"></i>Placed
                        </span>
                        <?php
                        break;
                    case 'Placed with Ongoing Req.':
                        ?>
                        <span class=" badge badge border border-success text-success ">
                            <i class="bi bi-arrow-clockwise me-1"></i>Placed with Ongoing Req.
                        </span>
                        <?php
                        break;
                    case 'Placed with Onboarding':
                        ?>
                        <span class=" badge badge border border-success text-success ">
                            <i class="bi bi-hand-thumbs-up-fill me-1"></i>Placed with Onboarding
                        </span>
                        <?php
                        break;
                    case 'Backout':
                        ?>
                        <span class=" badge badge border border-danger text-danger ">
                            <i class="bi bi-back me-1"></i>Backout
                        </span>
                        <?php
                        break;
                    default:
                        ?>
                        <span class=" badge badge border border-secondary text-secondary ">
                            <i class="bi bi-clock-history me-1"></i>Unknown Status
                        </span>
                        <?php
                        break;
                }
                ?>
            </td>

            <!-- Automated Resume -->
            <td>
                <button type="button" class="btn btn-success badge " data-bs-toggle="modal"
                    data-bs-target="#viewResumeModal<?php echo $row['id']; ?>">
                    View Resume
                </button>
            </td>

            <!-- Remarks -->
            <td>
                <button type="button" class="btn btn-primary badge " data-bs-toggle="modal"
                    data-bs-target="#viewRemarksModal<?php echo $row['id']; ?>">
                    View Remarks
                </button>
            </td>

            <!-- Logs -->
            <td>
                <button type="button" class="btn btn-primary badge " data-bs-toggle="modal"
                    data-bs-target="#viewLogsModal<?php echo $row['id']; ?>">
                    View Logs
                </button>
            </td>

            <!-- Actions -->
            <td>
                <div class="dropdown">
                    <a href="#" class="link-danger text-decoration-none dropdown-toggle text-dark" id="dropdownUser2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-list"></i>
                    </a>
                    <form action="../admin/applicant_process.php" method="post">
                        <input type="hidden" name="applicant_id" value="<?php echo $row['id']; ?>">
                        <?php
                        //Actions for Pooling Applicants Sidebar
                        if ($row['application_status'] == 'Pending' || $row['application_status'] == 'Pooling' || $row['application_status'] == 'Pooled' || $row['application_status'] == 'Back to Pooling') {
                            ?>

                            <ul class="dropdown-menu text-center shadow" aria-labelledby="dropdownUser2">
                                <li class="mb-1">

                                    <button type="submit" name="passBtn" class="dropdown-item text-success mb-1">
                                        <i class="bi bi-check-square"></i> Passed
                                    </button>

                                </li>
                                <li class="mb-1">
                                    <button type="button" class="dropdown-item text-danger mb-1" data-bs-toggle="modal"
                                        data-bs-target="#failModal<?php echo $row['id'] ?>">
                                        <i class="bi bi-x-square"></i> Failed
                                    </button>
                                </li>
                                <li class="mb-1">
                                    <button type="submit" name="poolBtn" class="dropdown-item text-primary mb-1">
                                        <i class="bi bi-file-earmark-break"></i> Pooling
                                    </button>
                                </li>
                            </ul>

                            <?php

                        } //Actions for Shortlisted Applicants Sidebar
                        else if ($row['application_status'] == 'Passed' || $row['application_status'] == 'For Initial Interview' || $row['application_status'] == 'For Final Interview' || $row['application_status'] == 'Waiting for Feedback') {
                            ?>

                                <ul class="dropdown-menu text-center shadow" aria-labelledby="dropdownUser2">
                                    <li class="mb-1">
                                        <button type="button" class="dropdown-item text-info mb-1" data-bs-toggle="modal"
                                            data-bs-target="#initialInterviewModal<?php echo $row['id'] ?>">
                                            <i class="bi bi-calendar-check me-1"></i> For Initial Interview
                                        </button>
                                    </li>
                                    <li class="mb-1">
                                        <button type="button" class="dropdown-item text-dark mb-1" data-bs-toggle="modal"
                                            data-bs-target="#finalInterviewModal<?php echo $row['id'] ?>">
                                            <i class="bi bi-calendar-check me-1"></i> For Final Interview
                                        </button>
                                    </li>
                                    <li class="mb-1">
                                        <button type="submit" name="feedbackBtn" class="dropdown-item text-primary mb-1">
                                            <i class="bi bi-clock me-1"></i> Waiting for Feedback
                                        </button>
                                    </li>
                                    <li class="mb-1">
                                        <button type="submit" name="hiredBtn" class="dropdown-item text-success mb-1">
                                            <i class="bi bi-check-square me-1"></i> Hired
                                        </button>
                                    </li>
                                    <li class="mb-1">
                                        <button type="button" class="dropdown-item text-warning mb-1" data-bs-toggle="modal"
                                            data-bs-target="#backToPoolingModal<?php echo $row['id'] ?>">
                                            <i class="bi bi-exclamation-diamond-fill me-1"></i> Back to Pooling
                                        </button>
                                    </li>
                                    <li class="mb-1">
                                        <button type="button" class="dropdown-item text-danger mb-1" data-bs-toggle="modal"
                                            data-bs-target="#failModal<?php echo $row['id'] ?>">
                                            <i class="bi bi-x-square"></i> Failed
                                        </button>
                                    </li>
                                </ul>
                            <?php
                            //For Identified Appplicants Sidebar
                        } else if ($row['application_status'] == 'Hired' || $row['application_status'] == 'Ongoing Requirements' || $row['application_status'] == 'Onboarding' || $row['application_status'] == 'Waiting for Start Date' || $row['application_status'] == 'Placed with Ongoing Req.' || $row['application_status'] == 'Placed with Onboarding') {
                            ?>

                                    <ul class="dropdown-menu text-center shadow" aria-labelledby="dropdownUser2">
                                        <li class="mb-1">
                                            <button type="submit" name="ongoingBtn" class="dropdown-item text-warning mb-1">
                                                <i class="bi bi-arrow-clockwise me-1"></i>Ongoing Requirements
                                            </button>
                                        </li>
                                        <li class="mb-1">
                                            <button type="submit" name="onbaordingBtn" class="dropdown-item text-info mb-1">
                                                <i class="bi bi-hand-thumbs-up me-1"></i> Onboarding
                                            </button>
                                        </li>
                                        <li class="mb-1">
                                            <button type="submit" name="startDateBtn" class="dropdown-item text-primary mb-1">
                                                <i class="bi bi-clock me-1"></i> Waiting for Start Date
                                            </button>
                                        </li>
                                        <li class="mb-1">
                                            <button type="submit" name="placedBtn" class="dropdown-item text-success mb-1">
                                                <i class="bi bi-check-square me-1"></i> Placed
                                            </button>
                                        </li>
                                        <li class="mb-1">
                                            <button type="submit" name="placedWithOngoingBtn" class="dropdown-item text-success mb-1">
                                                <i class="bi bi-arrow-clockwise me-1"></i> Placed with Ongoing Req.
                                            </button>
                                        </li>
                                        <li class="mb-1">
                                            <button type="submit" name="placedWithOnboardingBtn"
                                                class="dropdown-item text-success mb-1">
                                                <i class="bi bi-hand-thumbs-up me-1"></i> Placed with Onboarding
                                            </button>
                                        </li>
                                        <li class="mb-1">
                                            <button type="button" class="dropdown-item text-danger mb-1" data-bs-toggle="modal"
                                                data-bs-target="#failModal<?php echo $row['id'] ?>">
                                                <i class="bi bi-x-square"></i> Failed
                                            </button>
                                        </li>
                                        <li class="mb-1">
                                            <button type="submit" name="backoutBtn" class="dropdown-item text-danger mb-1">
                                                <i class="bi bi-back me-1"></i> Backout
                                            </button>
                                        </li>
                                    </ul>
                            <?php
                        } else if ($row['application_status'] == 'Placed') {

                        } else if ($row['application_status'] == 'Failed') {

                        }
                        ?>
                    </form>
                </div>

            </td>
        </tr>


        <!-- Fail Remark Modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="failModal<?php echo $row['id']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-4 shadow">
                    <div class="modal-header p-5 pb-4 border-bottom-0">
                        <h4 class="modal-title fw-bold" id="exampleModalLabel">
                            Remark
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-5 pt-0">
                        <form action="../admin/applicant_process.php" method="POST" class="">
                            <input type="hidden" name="applicant_id" value="<?php echo $row['id']; ?>">
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="hidden" class="form-control" name="applicant_id"
                                            value="<?php echo $row['id'] ?>">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" placeholder="remark" name="remark"
                                                required>
                                            <label class=" form-label fw-bold">Remark</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-danger" name="failBtn" type="submit">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Pooling Remark Modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="backToPoolingModal<?php echo $row['id']; ?>"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-4 shadow">
                    <div class="modal-header p-5 pb-4 border-bottom-0">
                        <h4 class="modal-title fw-bold" id="exampleModalLabel">
                            Remark
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-5 pt-0">
                        <form action="../admin/applicant_process.php" method="POST" class="">
                            <input type="hidden" name="applicant_id" value="<?php echo $row['id']; ?>">
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="hidden" class="form-control" name="applicant_id"
                                            value="<?php echo $row['id'] ?>">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" placeholder="remark" name="remark"
                                                required>
                                            <label class=" form-label fw-bold">Remark</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-danger" name="backToPoolingBtn"
                                type="submit">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Log Modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="viewLogsModal<?php echo $row['id']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="min-width: 90vh;">
                <div class="modal-content rounded-4 shadow">
                    <div class="modal-header p-5 pb-4 border-bottom-0">
                        <h4 class="modal-title fw-bold" id="exampleModalLabel">
                            Logs
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-5 pt-0">
                        <div class="mb-3">
                            <div class="row mb-3">
                                <div class="col">
                                    <ul class="list-group list-group-flush">
                                        <?php
                                        $logQuery = "SELECT * FROM applicant_logs WHERE applicant_id = ?";
                                        $logStmt = $conn->prepare($logQuery);
                                        $logStmt->bind_param("i", $row['id']);
                                        $logStmt->execute();
                                        $logResult = $logStmt->get_result();

                                        while ($logRow = $logResult->fetch_assoc()) {
                                            ?>
                                            <li class="list-group-item">
                                                <p>
                                                    <i class="bi bi-exclamation-square-fill text-danger"></i>
                                                    <?php echo $logRow['log']; ?>
                                                </p>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Remark Modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="viewRemarksModal<?php echo $row['id']; ?>"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-4 shadow">
                    <div class="modal-header p-5 pb-4 border-bottom-0">
                        <h4 class="modal-title fw-bold" id="exampleModalLabel">
                            Remarks
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-5 pt-0">
                        <div class="mb-3">
                            <div class="row mb-3">
                                <div class="col">
                                    <ul class="list-group list-group-flush ">
                                        <?php
                                        $remarks = explode(', ', $row['remark']);

                                        foreach ($remarks as $remark) {
                                            ?>
                                            <li class="list-group-item ">
                                                <i class="bi bi-exclamation-square-fill text-danger"></i>
                                                <?php echo $remark; ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule Initial Interview Modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="initialInterviewModal<?php echo $row['id']; ?>"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-4 shadow">
                    <div class="modal-header p-5 pb-4 border-bottom-0">
                        <h4 class="modal-title fw-bold" id="exampleModalLabel">
                            Schedule Initial Interview
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-5 pt-0">
                        <form action="../admin/applicant_process.php" method="POST" class="">
                            <input type="hidden" name="applicant_id" value="<?php echo $row['id']; ?>">
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="hidden" class="form-control" name="applicant_id"
                                            value="<?php echo $row['id'] ?>">
                                        <input type="datetime-local" class="form-control" name="interview_date" id="">
                                    </div>
                                </div>
                            </div>

                            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-danger" name="initial_interviewBtn"
                                type="submit">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule Final Interview Modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="finalInterviewModal<?php echo $row['id']; ?>"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-4 shadow">
                    <div class="modal-header p-5 pb-4 border-bottom-0">
                        <h4 class="modal-title fw-bold" id="exampleModalLabel">
                            Schedule Final Interview
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-5 pt-0">
                        <form action="../admin/applicant_process.php" method="POST" class="">
                            <input type="hidden" name="applicant_id" value="<?php echo $row['id']; ?>">
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="hidden" class="form-control" name="applicant_id"
                                            value="<?php echo $row['id'] ?>">
                                        <input type="datetime-local" class="form-control" name="interview_date" id="">
                                    </div>
                                </div>
                            </div>

                            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-danger" name="final_interviewBtn"
                                type="submit">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Applicant's Resume Modal -->
        <div class="modal fade" id="viewResumeModal<?php echo $row['id'] ?>" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header  p-5 pb-4 border-bottom-0">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <?php echo $row['first_name'] . ' ' . $row['last_name']; ?>'s Resume
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="my_resume_process.php" method="post" enctype="multipart/form-data">
                            <hr style="border-width: 3px;">
                            <h4 class="fw-bold text-center">Personal Information</h4>
                            <hr style="border-width: 3px;">
                            <div class="row">
                                <div class="col-sm-12 col-lg-2">
                                    <div class="row ">
                                        <div class="col-auto" id="imagePreviewContainer">
                                            <div class="row justify-content-center">
                                                <div class="col-auto">
                                                    <img id="imagePreview"
                                                        src="/recruitment/img/applicant/<?php echo $resumeRow['picture']; ?>"
                                                        alt="No Image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-12 col-lg-10 order-last">
                                    <div class="container-fluid mt-5">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-4">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control rounded-3 fw-bold"
                                                        placeholder="Juan" name="lName"
                                                        value="<?php echo !empty($resumeRow['last_name']) ? $resumeRow['last_name'] : ''; ?>"
                                                        required disabled>
                                                    <label for="floatingInput" class="fw-bold">Last
                                                        Name</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control rounded-3 fw-bold"
                                                        placeholder="Juan" name="fName"
                                                        value="<?php echo !empty($resumeRow['first_name']) ? $resumeRow['first_name'] : ''; ?>"
                                                        required disabled>
                                                    <label for="floatingInput" class="fw-bold">FIrst
                                                        Name</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control rounded-3 fw-bold"
                                                        placeholder="Juan" name="mName"
                                                        value="<?php echo !empty($resumeRow['middle_name']) ? $resumeRow['middle_name'] : ''; ?>"
                                                        required disabled>
                                                    <label for="floatingInput" class="fw-bold">Middle Name</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- For Addresses -->
                            <div class="row mt-3">

                                <div class="col-sm-12 col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="emailAddress"
                                            value="<?php echo !empty($resumeRow['email']) ? $resumeRow['email'] : ''; ?>"
                                            required disabled>
                                        <label for="floatingInput" class="fw-bold">Email
                                            Address</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="presentAddress"
                                            value="<?php echo !empty($resumeRow['present_address']) ? $resumeRow['present_address'] : ''; ?>"
                                            required disabled>
                                        <label for="floatingInput" class="fw-bold">Present
                                            Address</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="permanentAddress"
                                            value="<?php echo !empty($resumeRow['permanent_address']) ? $resumeRow['permanent_address'] : ''; ?>"
                                            required disabled>
                                        <label for="floatingInput" class="fw-bold">Permanent
                                            Address</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">

                                <div class="col-sm-12 col-md-4 col-lg mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="height"
                                            value="<?php echo !empty($resumeRow['height']) ? $resumeRow['height'] : ''; ?>"
                                            required disabled>
                                        <label for="floatingInput" class="fw-bold">Height</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="weight"
                                            value="<?php echo !empty($resumeRow['weight']) ? $resumeRow['weight'] : ''; ?>"
                                            required disabled>
                                        <label for="floatingInput" class="fw-bold">Weight</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="nationality"
                                            value="<?php echo !empty($resumeRow['nationality']) ? $resumeRow['nationality'] : ''; ?>"
                                            required disabled>
                                        <label for="floatingInput" class="fw-bold">Nationality</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="religion"
                                            value="<?php echo !empty($resumeRow['religion']) ? $resumeRow['religion'] : ''; ?>"
                                            required disabled>
                                        <label for="floatingInput" class="fw-bold">Religion</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg">
                                    <div class="form-group">
                                        <label for="birthDate" class="fw-bold">Birth
                                            Date:</label>
                                        <input class="form-control fw-bold" type="date" id="birthDate" name="birthDate"
                                            value="<?php echo !empty($resumeRow['birthdate']) ? $resumeRow['birthdate'] : ''; ?>"
                                            disabled>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg">
                                    <div class="form-group">
                                        <label for="genderSelect" class="fw-bold">Gender:</label>
                                        <select class="form-control fw-bold" id="genderSelect" name="gender" required
                                            disabled>
                                            <option <?php echo (empty($resumeRow['gender']) ? 'selected' : ''); ?> disabled>
                                                Choose...</option>
                                            <option value="Male" <?php echo (!empty($resumeRow['gender']) && $resumeRow['gender'] == 'Male') ? 'selected' : ''; ?>>
                                                Male</option>
                                            <option value="Female" <?php echo (!empty($resumeRow['gender']) && $resumeRow['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                        </select>
                                    </div>

                                </div>

                            </div>

                            <div class="row mt-2">

                                <div class="col-sm-12 col-md-4 col-lg mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="sssNumber"
                                            value="<?php echo !empty($resumeRow['sss_number']) ? $resumeRow['sss_number'] : ''; ?>"
                                            required disabled>
                                        <label for="floatingInput" class="fw-bold">SSS
                                            Number</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="philhealthNumber"
                                            value="<?php echo !empty($resumeRow['philhealth_number']) ? $resumeRow['philhealth_number'] : ''; ?>"
                                            required disabled>
                                        <label for="floatingInput" class="fw-bold">PhilHealth
                                            Number</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="pagibigNumber"
                                            value="<?php echo !empty($resumeRow['pagibig_number']) ? $resumeRow['pagibig_number'] : ''; ?>"
                                            required disabled>
                                        <label for="floatingInput" class="fw-bold">Pagibig
                                            Number</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="tinNumber"
                                            value="<?php echo !empty($resumeRow['tin_number']) ? $resumeRow['tin_number'] : ''; ?>"
                                            required disabled>
                                        <label for="floatingInput" class="fw-bold">TIN
                                            Number</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="contactNumber"
                                            value="<?php echo !empty($resumeRow['contact_number']) ? $resumeRow['contact_number'] : ''; ?>"
                                            required disabled>
                                        <label for="floatingInput" class="fw-bold">Contact
                                            Number</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg">
                                    <div class="form-group">
                                        <label for="civilStatusSelect" class="fw-bold ">Civil
                                            Status:</label>
                                        <select class="form-control fw-bold " id="civilStatusSelect" name="civilStatus"
                                            required disabled>
                                            <option <?php echo (empty($resumeRow['civil_status']) ? 'selected' : ''); ?>
                                                disabled>
                                                Choose...</option>
                                            <option value="Single" <?php echo (!empty($resumeRow['civil_status']) && $resumeRow['civil_status'] == 'Single') ? 'selected' : ''; ?>>Single
                                            </option>
                                            <option value="Married" <?php echo (!empty($resumeRow['civil_status']) && $resumeRow['civil_status'] == 'Married') ? 'selected' : ''; ?>>Married
                                            </option>
                                            <option value="Widowed" <?php echo (!empty($resumeRow['civil_status']) && $resumeRow['civil_status'] == 'Widowed') ? 'selected' : ''; ?>>Widowed
                                            </option>
                                            <option value="Separated" <?php echo (!empty($resumeRow['civil_status']) && $resumeRow['civil_status'] == 'Separated') ? 'selected' : ''; ?>>Separated
                                            </option>
                                        </select>
                                    </div>

                                </div>

                            </div>

                            <hr style="border-width: 3px;">
                            <h4 class="fw-bold text-center">Educational Attainment</h4>
                            <hr style="border-width: 3px;">

                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-8">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 mt-2">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                                    name="college"
                                                    value="<?php echo !empty($resumeRow['college']) ? $resumeRow['college'] : ''; ?>"
                                                    disabled>
                                                <label for="floatingInput" class="fw-bold">College</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 mt-2">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                                    name="degree"
                                                    value="<?php echo !empty($resumeRow['college_degree']) ? $resumeRow['college_degree'] : ''; ?>"
                                                    disabled>
                                                <label for="floatingInput" class="fw-bold">Degree</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="fromDate" class="fw-bold">From:</label>
                                                <input class="form-control fw-bold" type="date" id="fromDate"
                                                    name="eduCollegeFromDate"
                                                    value="<?php echo !empty($resumeRow['college_from']) ? $resumeRow['college_from'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 mt-2">
                                            <div class="form-group">
                                                <label for="toDate" class="fw-bold">To:</label>
                                                <input class="form-control fw-bold" type="date" id="toDate"
                                                    name="eduCollegeToDate"
                                                    value="<?php echo !empty($resumeRow['college_to']) ? $resumeRow['college_to'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <hr style="border-width: 2px;">

                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-8">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 mt-2">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                                    name="vocational"
                                                    value="<?php echo !empty($resumeRow['vocational']) ? $resumeRow['vocational'] : ''; ?>"
                                                    disabled>
                                                <label for="floatingInput" class="fw-bold">Vocational</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 mt-2">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                                    name="diploma"
                                                    value="<?php echo !empty($resumeRow['vocational_diploma']) ? $resumeRow['vocational_diploma'] : ''; ?>"
                                                    disabled>
                                                <label for="floatingInput" class="fw-bold">Diploma</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="fromDate" class="fw-bold">From:</label>
                                                <input class="form-control fw-bold" type="date" id="fromDate"
                                                    name="eduVocationalFromDate"
                                                    value="<?php echo !empty($resumeRow['vocational_from']) ? $resumeRow['vocational_from'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 mt-2">
                                            <div class="form-group">
                                                <label for="toDate" class="fw-bold">To:</label>
                                                <input class="form-control fw-bold" type="date" id="toDate"
                                                    name="eduVocationalToDate"
                                                    value="<?php echo !empty($resumeRow['vocational_to']) ? $resumeRow['vocational_to'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <hr style="border-width: 2px;">

                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-8">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 mt-2">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                                    name="highSchool"
                                                    value="<?php echo !empty($resumeRow['high_school']) ? $resumeRow['high_school'] : ''; ?>"
                                                    disabled>
                                                <label for="floatingInput" class="fw-bold">High
                                                    School</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 mt-2">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                                    name="highSchoolLevel"
                                                    value="<?php echo !empty($resumeRow['high_school_level']) ? $resumeRow['high_school_level'] : ''; ?>"
                                                    disabled>
                                                <label for="floatingInput" class="fw-bold">Level</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="fromDate" class="fw-bold">From:</label>
                                                <input class="form-control fw-bold" type="date" id="fromDate"
                                                    name="eduHighSchoolFromDate"
                                                    value="<?php echo !empty($resumeRow['high_school_from']) ? $resumeRow['high_school_from'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 mt-2">
                                            <div class="form-group">
                                                <label for="toDate" class="fw-bold">To:</label>
                                                <input class="form-control fw-bold" type="date" id="toDate"
                                                    name="eduHighSchoolToDate"
                                                    value="<?php echo !empty($resumeRow['high_school_to']) ? $resumeRow['high_school_to'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <hr style="border-width: 2px;">

                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-8">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 mt-2">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                                    name="elementary"
                                                    value="<?php echo !empty($resumeRow['elementary']) ? $resumeRow['elementary'] : ''; ?>"
                                                    disabled>
                                                <label for="floatingInput" class="fw-bold">Elementary</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 mt-2">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                                    name="elementaryLevel"
                                                    value="<?php echo !empty($resumeRow['elementary_level']) ? $resumeRow['elementary_level'] : ''; ?>"
                                                    disabled>
                                                <label for="floatingInput" class="fw-bold">Level</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="fromDate" class="fw-bold">From:</label>
                                                <input class="form-control fw-bold" type="date" id="fromDate"
                                                    name="eduElementaryFromDate"
                                                    value="<?php echo !empty($resumeRow['	elementary_from']) ? $resumeRow['	elementary_from'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 mt-2">
                                            <div class="form-group">
                                                <label for="toDate" class="fw-bold">To:</label>
                                                <input class="form-control fw-bold" type="date" id="toDate"
                                                    name="eduElementaryToDate"
                                                    value="<?php echo !empty($resumeRow['elementary_to']) ? $resumeRow['elementary_to'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <hr style="border-width: 3px;">
                            <h4 class="fw-bold text-center">Employment Background</h4>
                            <hr style="border-width: 3px;">

                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 mt-2">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                                    name="company1"
                                                    value="<?php echo !empty($resumeRow['company_one']) ? $resumeRow['company_one'] : ''; ?>"
                                                    disabled>
                                                <label for="floatingInput" class="fw-bold">Company
                                                    1</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 mt-2">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                                    name="position1"
                                                    value="<?php echo !empty($resumeRow['company_one_position']) ? $resumeRow['company_one_position'] : ''; ?>"
                                                    disabled>
                                                <label for="floatingInput" class="fw-bold">Position</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="fromDate" class="fw-bold">From:</label>
                                                <input class="form-control fw-bold" type="date" id="fromDate"
                                                    name="empBgFromDate1"
                                                    value="<?php echo !empty($resumeRow['company_one_from']) ? $resumeRow['company_one_from'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 mt-2">
                                            <div class="form-group">
                                                <label for="toDate" class="fw-bold">To:</label>
                                                <input class="form-control fw-bold" type="date" id="toDate"
                                                    name="empBgToDate1"
                                                    value="<?php echo !empty($resumeRow['company_one_to']) ? $resumeRow['company_one_to'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 mt-3">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                                    name="status1"
                                                    value="<?php echo !empty($resumeRow['company_one_status']) ? $resumeRow['company_one_status'] : ''; ?>"
                                                    disabled>
                                                <label for="floatingInput" class="fw-bold">Status</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="responsibilities1"
                                            value="<?php echo !empty($resumeRow['company_one_responsibilities']) ? $resumeRow['company_one_responsibilities'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Responsibilities</label>
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-sm-12 col-md-9 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="reason1"
                                            value="<?php echo !empty($resumeRow['company_one_reason_for_leaving']) ? $resumeRow['company_one_reason_for_leaving'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Reason for
                                            Leaving</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-3 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="lastSalary1"
                                            value="<?php echo !empty($resumeRow['company_one_last_salary']) ? $resumeRow['company_one_last_salary'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Last
                                            Salary</label>
                                    </div>
                                </div>
                            </div>

                            <hr style="border-width: 2px;">


                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 mt-2">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                                    name="company2"
                                                    value="<?php echo !empty($resumeRow['company_two']) ? $resumeRow['company_two'] : ''; ?>"
                                                    disabled>
                                                <label for="floatingInput" class="fw-bold">Company
                                                    2</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 mt-2">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                                    name="position2"
                                                    value="<?php echo !empty($resumeRow['company_two_position']) ? $resumeRow['company_two_position'] : ''; ?>"
                                                    disabled>
                                                <label for="floatingInput" class="fw-bold">Position</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="fromDate" class="fw-bold">From:</label>
                                                <input class="form-control fw-bold" type="date" id="fromDate"
                                                    name="empBgFromDate2"
                                                    value="<?php echo !empty($resumeRow['company_two_from']) ? $resumeRow['company_two_from'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 mt-2">
                                            <div class="form-group">
                                                <label for="toDate" class="fw-bold">To:</label>
                                                <input class="form-control fw-bold" type="date" id="toDate"
                                                    name="empBgToDate2"
                                                    value="<?php echo !empty($resumeRow['company_two_to']) ? $resumeRow['company_two_to'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 mt-3">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                                    name="status2"
                                                    value="<?php echo !empty($resumeRow['company_two_status']) ? $resumeRow['company_two_status'] : ''; ?>"
                                                    disabled>
                                                <label for="floatingInput" class="fw-bold">Status</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="responsibilities2"
                                            value="<?php echo !empty($resumeRow['company_two_responsibilities']) ? $resumeRow['company_two_responsibilities'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Responsibilities</label>
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-sm-12 col-md-9 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="reason2"
                                            value="<?php echo !empty($resumeRow['company_two_reason_for_leaving']) ? $resumeRow['company_two_reason_for_leaving'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Reason for
                                            Leaving</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-3 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="lastSalary2"
                                            value="<?php echo !empty($resumeRow['company_two_last_salary']) ? $resumeRow['company_two_last_salary'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Last
                                            Salary</label>
                                    </div>
                                </div>
                            </div>

                            <hr style="border-width: 2px;">

                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 mt-2">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                                    name="company3"
                                                    value="<?php echo !empty($resumeRow['company_three']) ? $resumeRow['company_three'] : ''; ?>"
                                                    disabled>
                                                <label for="floatingInput" class="fw-bold">Company
                                                    3</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 mt-2">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                                    name="position3"
                                                    value="<?php echo !empty($resumeRow['company_three_position']) ? $resumeRow['company_three_position'] : ''; ?>"
                                                    disabled>
                                                <label for="floatingInput" class="fw-bold">Position</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="fromDate" class="fw-bold">From:</label>
                                                <input class="form-control fw-bold" type="date" id="fromDate"
                                                    name="empBgFromDate3"
                                                    value="<?php echo !empty($resumeRow['company_three_from']) ? $resumeRow['company_three_from'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 mt-2">
                                            <div class="form-group">
                                                <label for="toDate" class="fw-bold">To:</label>
                                                <input class="form-control fw-bold" type="date" id="toDate"
                                                    name="empBgToDate3"
                                                    value="<?php echo !empty($resumeRow['company_three_to']) ? $resumeRow['company_three_to'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 mt-3">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                                    name="status3"
                                                    value="<?php echo !empty($resumeRow['company_three_status']) ? $resumeRow['company_three_status'] : ''; ?>"
                                                    disabled>
                                                <label for="floatingInput" class="fw-bold">Status</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="responsibilities3"
                                            value="<?php echo !empty($resumeRow['company_three_responsibilities']) ? $resumeRow['company_three_responsibilities'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Responsibilities</label>
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-sm-12 col-md-9 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="reason3"
                                            value="<?php echo !empty($resumeRow['company_three_reason_for_leaving']) ? $resumeRow['company_three_reason_for_leaving'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Reason for
                                            Leaving</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-3 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="lastSalary3"
                                            value="<?php echo !empty($resumeRow['company_three_last_salary']) ? $resumeRow['company_three_last_salary'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Last
                                            Salary</label>
                                    </div>
                                </div>
                            </div>

                            <hr style="border-width: 3px;">
                            <h4 class="fw-bold text-center">Recent Employment</h4>
                            <hr style="border-width: 3px;">


                            <div class="row">

                                <div class="col-sm-12 col-md-4 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="recentEmpContactPerson"
                                            value="<?php echo !empty($resumeRow['recent_employment_contact_person']) ? $resumeRow['recent_employment_contact_person'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Contact
                                            Person</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="recentEmpPosition"
                                            value="<?php echo !empty($resumeRow['recent_employment_position']) ? $resumeRow['recent_employment_position'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Position</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="recentEmpContactNum"
                                            value="<?php echo !empty($resumeRow['recent_employment_contact_number']) ? $resumeRow['recent_employment_contact_number'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Contact
                                            Number</label>
                                    </div>
                                </div>

                            </div>

                            <hr style="border-width: 3px;">
                            <h4 class="fw-bold text-center">Lectures and Seminars Attended</h4>
                            <hr style="border-width: 3px;">

                            <div class="row">

                                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="seminarTitle1"
                                            value="<?php echo !empty($resumeRow['title_one']) ? $resumeRow['title_one'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Title
                                            1</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="seminarVenue1"
                                            value="<?php echo !empty($resumeRow['title_one_venue']) ? $resumeRow['title_one_venue'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Venue</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="fromDate" class="fw-bold">From:</label>
                                        <input class="form-control fw-bold" type="date" id="fromDate"
                                            name="seminarFromDate1"
                                            value="<?php echo !empty($resumeRow['title_one_from']) ? $resumeRow['title_one_from'] : ''; ?>"
                                            disabled>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                    <div class="form-group">
                                        <label for="toDate" class="fw-bold">To:</label>
                                        <input class="form-control fw-bold" type="date" id="toDate" name="seminarToDate1"
                                            value="<?php echo !empty($resumeRow['title_one_to']) ? $resumeRow['title_one_to'] : ''; ?>"
                                            disabled>
                                    </div>
                                </div>


                            </div>

                            <hr style="border-width: 2px;">

                            <div class="row">

                                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="seminarTitle2"
                                            value="<?php echo !empty($resumeRow['title_two']) ? $resumeRow['title_two'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Title
                                            2</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="seminarVenue2"
                                            value="<?php echo !empty($resumeRow['title_two_venue']) ? $resumeRow['title_two_venue'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Venue</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="fromDate" class="fw-bold">From:</label>
                                        <input class="form-control fw-bold" type="date" id="fromDate"
                                            name="seminarFromDate2"
                                            value="<?php echo !empty($resumeRow['title_two_from']) ? $resumeRow['title_two_from'] : ''; ?>"
                                            disabled>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                    <div class="form-group">
                                        <label for="toDate" class="fw-bold">To:</label>
                                        <input class="form-control fw-bold" type="date" id="toDate" name="seminarToDate2"
                                            value="<?php echo !empty($resumeRow['title_two_to']) ? $resumeRow['title_two_to'] : ''; ?>"
                                            disabled>
                                    </div>
                                </div>


                            </div>

                            <hr style="border-width: 2px;">

                            <div class="row">

                                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="seminarTitle3"
                                            value="<?php echo !empty($resumeRow['title_three']) ? $resumeRow['title_three'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Title
                                            3</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="seminarVenue3"
                                            value="<?php echo !empty($resumeRow['title_three_venue']) ? $resumeRow['title_three_venue'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Venue</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="fromDate" class="fw-bold">From:</label>
                                        <input class="form-control fw-bold" type="date" id="fromDate"
                                            name="seminarFromDate3"
                                            value="<?php echo !empty($resumeRow['title_three_from']) ? $resumeRow['title_three_from'] : ''; ?>"
                                            disabled>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                    <div class="form-group">
                                        <label for="toDate" class="fw-bold">To:</label>
                                        <input class="form-control fw-bold" type="date" id="toDate" name="seminarToDate3"
                                            value="<?php echo !empty($resumeRow['title_three_to']) ? $resumeRow['title_three_to'] : ''; ?>"
                                            disabled>
                                    </div>
                                </div>

                            </div>

                            <hr style="border-width: 3px;">
                            <h4 class="fw-bold text-center">Character References</h4>
                            <hr style="border-width: 3px;">

                            <div class="row">

                                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="charRefName1"
                                            value="<?php echo !empty($resumeRow['name_one']) ? $resumeRow['name_one'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Name
                                            1</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="charRefPosition1"
                                            value="<?php echo !empty($resumeRow['name_one_position']) ? $resumeRow['name_one_position'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Position</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="charRefCompany1"
                                            value="<?php echo !empty($resumeRow['name_one_company']) ? $resumeRow['name_one_company'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Company</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="charRefContactNum1"
                                            value="<?php echo !empty($resumeRow['name_one_contact_number']) ? $resumeRow['name_one_contact_number'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Contact
                                            Number</label>
                                    </div>
                                </div>
                            </div>

                            <hr style="border-width: 2px;">

                            <div class="row">

                                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="charRefName2"
                                            value="<?php echo !empty($resumeRow['name_two']) ? $resumeRow['name_two'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Name
                                            2</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="charRefPosition2"
                                            value="<?php echo !empty($resumeRow['name_two_position']) ? $resumeRow['name_two_position'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Position</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="charRefCompany2"
                                            value="<?php echo !empty($resumeRow['name_two_company']) ? $resumeRow['name_two_company'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Company</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12"
                                            name="charRefContactNum2"
                                            value="<?php echo !empty($resumeRow['name_three_contact_number']) ? $resumeRow['name_three_contact_number'] : ''; ?>"
                                            disabled>
                                        <label for="floatingInput" class="fw-bold">Contact
                                            Number</label>
                                    </div>
                                </div>
                            </div>

                            <hr style="border-width: 3px;">
                            <h5 class="fw-bold text-center">How did you know about ___________?
                            </h5>
                            <hr style="border-width: 3px;">



                            <div class="row">

                                <div class="col-sm-12 col-lg-4">
                                    <ul class="list-group list-group-flush ">
                                        <?php
                                        $references = explode(', ', $resumeRow['reference']);

                                        foreach ($references as $reference) {
                                            ?>
                                            <li class="list-group-item fw-bold ">
                                                <i class="bi bi-check-square-fill text-success"></i>
                                                <?php echo $reference; ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>

                            <hr style="border-width: 3px;">
                            <h4 class="fw-bold text-center">Additional Information</h4>
                            <hr style="border-width: 3px;">

                            <div class="row">
                                <div class="col">
                                    <p>
                                        1. Do you have any relative/s working for___________? if
                                        yes, please state name/s:
                                    </p>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-3 fw-bold" id="addInfoFirstQuestion"
                                            placeholder="12" name="addInfoFirstQuestion"
                                            value="<?php echo !empty($resumeRow['additional_info_q1']) ? $resumeRow['additional_info_q1'] : ''; ?>"
                                            required disabled>
                                        <label for="addInfoFirstQuestion" class="fw-bold">
                                            Answer:
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <p>
                                        2. Do you have any relative/s working for a company who
                                        is in direct competition
                                        with___________? If yes, please state the name/s and
                                        company:
                                    </p>
                                    <div class="form-floating mb-3">

                                        <input type="text" class="form-control rounded-3 fw-bold" id="addInfoSecondQuestion"
                                            placeholder="12" name="addInfoSecondQuestion"
                                            value="<?php echo !empty($resumeRow['additional_info_q2']) ? $resumeRow['additional_info_q2'] : ''; ?>"
                                            required disabled>
                                        <label for="addInfoSecondQuestion" class="fw-bold">
                                            Answer:
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <hr style="border-width: 3px;">
                            <h4 class="fw-bold text-center">Declaration</h4>
                            <hr style="border-width: 3px;">


                            <div class="row">
                                <div class="col">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                            name="declaration" value="agreed" checked disabled>
                                        <label class="form-check-label" for="inlineCheckbox1" style="text-align: justify;">
                                            I hereby certify that the above information as
                                            provided by me is all true and correct. If employment is obtained under this
                                            application I
                                            will
                                            abide by all rules, regulations and policies of the company. I further
                                            understand that any
                                            false
                                            statement on this subject application is in itself sufficient ground for
                                            termination/cancellation of the subject application and/or employment
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <hr style="border-width: 3px;">
                            <h4 class="fw-bold text-center">AUTHORITY TO PROCESS and DISCLOSURE OF INFORMATION</h4>
                            <hr style="border-width: 3px;">


                            <div class="row">
                                <div class="col" style="text-align: justify;">
                                    <p>
                                        I hereby agree/authorize and consent ______________ to process and update of all my
                                        personal
                                        and
                                        sensitive information relative to my application or employment. This authorization
                                        is given in
                                        compliance o Republic Act 10173 or the Data Privacy Act of 2012.
                                    </p>
                                    <p>
                                        I also hereby authorize and consent ______________ to disclose my personal and
                                        sensitve
                                        information
                                        relative to my application or employment to its clients. This authorization is given
                                        in
                                        compliance
                                        of Republic Act 10173 or the Data Privacy Act of 2012.
                                    </p>
                                    <div class="float-end">
                                        <label for="applicantSignature" class="fw-bold">Upload your e-Signature:</label>
                                        <input type="file" id="applicantSignature" name="applicantSignature"
                                            value="<?php echo !empty($resumeRow['authorization']) ? $resumeRow['authorization'] : ''; ?>"
                                            class="form-control mt-2" disabled>
                                    </div>

                                </div>
                            </div>

                            <hr style="border-width: 3px;">

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    ?>

</tbody>

<script>
    $('#applicantTable').DataTable({
        "columnDefs": [
            { "orderable": false, "targets": [0] } // Disabling sorting for the first column (index 0)
        ],
        language: {
            "search": "_INPUT_",
            "searchPlaceholder": "Search"
        }

    });
</script>