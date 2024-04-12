<?php
session_start();

include ('../dbconn.php');
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['poolingExportBtn'])) {

    $fileName = "Sample." . 'xlsx';
    $logsQeury =
        "SELECT job_applicants.*, mrfs.job_position, mrfs.location, user.first_name, user.last_name
        FROM ((job_applicants
        INNER JOIN mrfs ON job_applicants.job_id = mrfs.id)
        INNER JOIN user ON job_applicants.user_id = user.id)
        WHERE job_applicants.application_status = 'Pending' OR  job_applicants.application_status = 'Pooling' OR  job_applicants.application_status = 'Pooled' OR  job_applicants.application_status = 'Back to Pooling'
    ";

    $stmt = $conn->prepare($logsQeury);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
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

        $rowCount = 2;
        foreach ($result as $data) {
            $applicantName = $data['first_name'] . ' ' . $data['last_name'];
            // $remarks = $data['remark'];
            // $remarks = str_replace('<br>', "\n", $remarks);

            $sheet->setCellValue('A' . $rowCount, $applicantName);
            $sheet->setCellValue('B' . $rowCount, $data['job_position']);
            $sheet->setCellValue('C' . $rowCount, $data['location']);
            $sheet->setCellValue('D' . $rowCount, $data['application_status']);
            //$sheet->setCellValue('E' . $rowCount, $remarks);
            //$sheet->setCellValue('F' . $rowCount, $logs);

            // Center align content in cells
            $sheet->getStyle('A' . $rowCount . ':F' . $rowCount)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $rowCount++;
        }
        // Auto-size columns
        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
        $writer->save('php://output');
    } else {
        $_SESSION['error_message'] = "No record found";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>