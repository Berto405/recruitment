<?php
session_start();

include ('../dbconn.php');
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['poolingExportBtn'])) {
        poolingExport($conn);
    } else if (isset($_POST['shortlistedExportBtn'])) {
        shortlistedExport($conn);
    } else if (isset($_POST['identifiedExportBtn'])) {
        identifiedExport($conn);
    } else if (isset($_POST['placedExportBtn'])) {
        placedExport($conn);
    } else if (isset($_POST['failedExportBtn'])) {
        failedExport($conn);
    } else if (isset($_POST['backoutExportBtn'])) {
        backoutExport($conn);
    } else if (isset($_POST['mrfListExportBtn'])) {
        mrfListExport($conn);
    }
}


function poolingExport($conn)
{
    $fileName = "Pooling_Applicants." . 'xlsx';
    $query =
        "SELECT job_applicants.*, mrfs.job_position, mrfs.location, user.first_name
        FROM ((job_applicants
        INNER JOIN mrfs ON job_applicants.job_id = mrfs.id)
        INNER JOIN user ON job_applicants.user_id = user.id)
        WHERE job_applicants.application_status = 'Pending' OR  job_applicants.application_status = 'Pooling' OR  job_applicants.application_status = 'Pooled' OR  job_applicants.application_status = 'Back to Pooling'
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        excel($conn, $fileName, $result);
    } else {
        $_SESSION['error_message'] = "No records found";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

function shortlistedExport($conn)
{
    $empName = $_SESSION['user_name'];
    $fileName = $empName . "_Shortlisted_Applicants." . 'xlsx';
    $currentlyLoggedIn = $_SESSION['user_id'];

    $query =
        "SELECT job_applicants.*, mrfs.job_position, mrfs.location, user.first_name, user.last_name
        FROM ((job_applicants
        INNER JOIN mrfs ON job_applicants.job_id = mrfs.id)
        INNER JOIN user ON job_applicants.user_id = user.id)
        WHERE job_applicants.application_status IN ('Passed', 'For Initial Interview', 'For Final Interview', 'Waiting for Feedback') AND job_applicants.employee_id = ?
        ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $currentlyLoggedIn);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        excel($conn, $fileName, $result);
    } else {
        $_SESSION['error_message'] = "No records found";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

}

function identifiedExport($conn)
{
    $empName = $_SESSION['user_name'];
    $fileName = $empName . "_Identified_Applicants." . 'xlsx';
    $currentlyLoggedIn = $_SESSION['user_id'];

    $query =
        "SELECT job_applicants.*, mrfs.job_position, mrfs.location, user.first_name, user.last_name
        FROM ((job_applicants
        INNER JOIN mrfs ON job_applicants.job_id = mrfs.id)
        INNER JOIN user ON job_applicants.user_id = user.id)
        WHERE job_applicants.application_status IN ('Hired', 'Ongoing Requirements', 'Onboarding', 'Waiting for Start Date', 'Placed with Ongoing Req.', 'Placed with Onboarding') AND job_applicants.employee_id = ?
        ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $currentlyLoggedIn);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        excel($conn, $fileName, $result);
    } else {
        $_SESSION['error_message'] = "No records found";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

function placedExport($conn)
{
    $fileName = "Placed_Applicants." . 'xlsx';

    $query =
        "SELECT job_applicants.*, mrfs.job_position, mrfs.location, user.first_name, user.last_name
        FROM ((job_applicants
        INNER JOIN mrfs ON job_applicants.job_id = mrfs.id)
        INNER JOIN user ON job_applicants.user_id = user.id)
        WHERE job_applicants.application_status IN ('Placed', 'Placed with Ongoing Req.', 'Placed with Onboarding')
        ";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        excel($conn, $fileName, $result);
    } else {
        $_SESSION['error_message'] = "No records found";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

function failedExport($conn)
{
    $fileName = "Failed_Applicants." . 'xlsx';

    $query =
        "SELECT job_applicants.*, mrfs.job_position, mrfs.location, user.first_name, user.last_name
        FROM ((job_applicants
        INNER JOIN mrfs ON job_applicants.job_id = mrfs.id)
        INNER JOIN user ON job_applicants.user_id = user.id)
        WHERE job_applicants.application_status = 'Failed'
        ";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        excel($conn, $fileName, $result);
    } else {
        $_SESSION['error_message'] = "No records found";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

function backoutExport($conn)
{
    $fileName = "Backout_Applicants." . 'xlsx';

    $query =
        "SELECT job_applicants.*, mrfs.job_position, mrfs.location, user.first_name, user.last_name
        FROM ((job_applicants
        INNER JOIN mrfs ON job_applicants.job_id = mrfs.id)
        INNER JOIN user ON job_applicants.user_id = user.id)
        WHERE job_applicants.application_status = 'Backout'
        ";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        excel($conn, $fileName, $result);
    } else {
        $_SESSION['error_message'] = "No records found";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

function excel($conn, $fileName, $result)
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $writer = new Xlsx($spreadsheet);

    $sheet->setCellValue('A1', 'Applicant Name');
    $sheet->setCellValue('B1', 'Job Position');
    $sheet->setCellValue('C1', 'Location of Deployment');
    $sheet->setCellValue('D1', 'Status');
    $sheet->setCellValue('E1', 'Remarks');
    $sheet->setCellValue('F1', 'Logs');

    // Center align headers
    $headerStyle = $sheet->getStyle('A1:F1');
    $headerStyle->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    //Set the excel header bg color to red
    $headerStyle->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('dc3545');
    //Set the excel header text color to white
    $headerStyle->getFont()
        ->getColor()
        ->setRGB('f8f9fa');
    //Set the excel header text to bold
    $headerStyle->getFont()->setBold(true);

    $rowCount = 2;
    foreach ($result as $data) {
        $applicantName = $data['first_name'] . ' ' . $data['last_name'];

        // Fetch logs for the current applicant
        $logsQeury = "SELECT * FROM applicant_logs WHERE applicant_id = ? ORDER BY created_at DESC";
        $logStmt = $conn->prepare($logsQeury);
        $logStmt->bind_param("i", $data['id']);
        $logStmt->execute();
        $logsResult = $logStmt->get_result();

        // Combine logs into a single string
        $logs = "";
        while ($log = $logsResult->fetch_assoc()) {
            $formattedCreatedAt = date("h:iA M d, Y", strtotime($log['created_at']));
            $logs .= $formattedCreatedAt . ' : ' . $log['log'] . "\n";
        }

        //Removes the <br> tag on value
        $remarksWithoutTag = strip_tags($data['remark']);
        //Replace comma with new line (\n)
        $remarks = str_replace(',', "\n", $remarksWithoutTag);

        $sheet->setCellValue('A' . $rowCount, $applicantName);
        $sheet->setCellValue('B' . $rowCount, $data['job_position']);
        $sheet->setCellValue('C' . $rowCount, $data['location']);
        $sheet->setCellValue('D' . $rowCount, $data['application_status']);
        $sheet->setCellValue('E' . $rowCount, $remarks);
        $sheet->setCellValue('F' . $rowCount, $logs);

        // Auto-size row
        $sheet->getStyle('A' . $rowCount . ':F' . $rowCount)
            ->getAlignment()
            ->setWrapText(true);

        // Center align content in cells
        $sheet->getStyle('A' . $rowCount . ':F' . $rowCount)
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        $rowCount++;
    }

    // Auto-size columns
    foreach (range('A', 'F') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
    $writer->save('php://output');
}


function mrfListExport($conn)
{
    $fileName = "MRF_List." . 'xlsx';

    $query = "SELECT * FROM mrfs";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $writer = new Xlsx($spreadsheet);

        $sheet->setCellValue('A1', 'Industry');
        $sheet->setCellValue('B1', 'MRF Status');
        $sheet->setCellValue('C1', 'Cancel/Closed Date');
        $sheet->setCellValue('D1', 'Request Date');
        $sheet->setCellValue('E1', 'Account/Client');
        $sheet->setCellValue('F1', 'Aging Days');
        $sheet->setCellValue('G1', 'MRF Number');
        $sheet->setCellValue('H1', 'new_request');
        $sheet->setCellValue('I1', 'HC');
        $sheet->setCellValue('J1', 'Position');
        $sheet->setCellValue('K1', 'Contract Type');
        $sheet->setCellValue('L1', 'Classification');
        $sheet->setCellValue('M1', 'Placed');
        $sheet->setCellValue('N1', 'Variance');
        $sheet->setCellValue('O1', 'Cancel');
        $sheet->setCellValue('P1', 'Remark');

        // Center align headers
        $headerStyle = $sheet->getStyle('A1:P1');
        $headerStyle->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        //Set the excel header bg color to red
        $headerStyle->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('dc3545');
        //Set the excel header text color to white
        $headerStyle->getFont()
            ->getColor()
            ->setRGB('f8f9fa');
        //Set the excel header text to bold
        $headerStyle->getFont()->setBold(true);

        $rowCount = 2;
        foreach ($result as $data) {
            $closed_date = $data['closed_date'];
            $timestamp_closed_date = strtotime($closed_date);
            $formatted_closed_date = date('M. d, Y', $timestamp_closed_date);

            $request_date = $data['request_date'];
            $timestamp_request_date = strtotime($request_date);
            $formatted_request_date = date('M. d, Y', $timestamp_request_date);

            $agingDays = $data['aging_days'];
            $suffix = $agingDays == 1 ? "day" : "days";
            $final_aging_days = $agingDays . ' ' . $suffix;

            $sheet->setCellValue('A' . $rowCount, $data['industry']);
            $sheet->setCellValue('B' . $rowCount, $data['mrf_status']);
            $sheet->setCellValue('C' . $rowCount, $formatted_closed_date);
            $sheet->setCellValue('D' . $rowCount, $formatted_request_date);
            $sheet->setCellValue('E' . $rowCount, $data['client']);
            $sheet->setCellValue('F' . $rowCount, $final_aging_days);
            $sheet->setCellValue('G' . $rowCount, $data['mrf_number']);
            $sheet->setCellValue('H' . $rowCount, $data['new_request']);
            $sheet->setCellValue('I' . $rowCount, $data['head_count']);
            $sheet->setCellValue('J' . $rowCount, $data['job_position']);
            $sheet->setCellValue('K' . $rowCount, $data['contract_type']);
            $sheet->setCellValue('L' . $rowCount, $data['classification']);
            $sheet->setCellValue('M' . $rowCount, $data['placed']);
            $sheet->setCellValue('N' . $rowCount, $data['variance']);
            $sheet->setCellValue('O' . $rowCount, $data['Cancel']);
            $sheet->setCellValue('P' . $rowCount, $data['Remark']);

            // Auto-size row
            $sheet->getStyle('A' . $rowCount . ':P' . $rowCount)
                ->getAlignment()
                ->setWrapText(true);

            // Center align content in cells
            $sheet->getStyle('A' . $rowCount . ':P' . $rowCount)
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);

            $rowCount++;
        }

        // Auto-size columns
        foreach (range('A', 'P') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
        $writer->save('php://output');

    } else {
        $_SESSION['error_message'] = "No records found";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>