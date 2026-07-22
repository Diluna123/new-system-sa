<?php
session_start();
require_once 'connection.php';

include "email_send/Exception.php";
include "email_send/SMTP.php";
include "email_send/PHPMailer.php";
require 'fpdf/fpdf.php';

include 'sms_modal.php';

use PHPMailer\PHPMailer\PHPMailer;

/* ===================== PDF CLASS ===================== */
class CustomPDF extends FPDF
{
    private $userData;

    public function setUserData($data)
    {
        $this->userData = $data;
    }

    function Header()
    {
        $this->SetFont('Arial', '', 10);
        $this->SetY(8);
        $this->Image('sansa.png', 170, 5, 30);

        $positionId = $this->userData["position_pid"] ?? 0;
        $designation = ($positionId == 1) ? "SPO" : (($positionId == 2) ? "TL" : "Staff");

        date_default_timezone_set('Asia/Colombo');
        $date = date('Y-m-d h:i A');

        $name = $this->userData["u_fname"] . " " . $this->userData["u_lname"];
        $code = $this->userData["code"] ?? 'N/A';
        $branch = 'Madampe';

        $this->Cell(30, 5, 'Designation:', 0, 0);
        $this->Cell(60, 5, $designation, 0, 1);
        $this->Cell(30, 5, 'Date:', 0, 0);
        $this->Cell(60, 5, $date, 0, 1);
        $this->Cell(30, 5, 'Name:', 0, 0);
        $this->Cell(60, 5, $name, 0, 1);
        $this->Cell(30, 5, 'Code:', 0, 0);
        $this->Cell(60, 5, $code, 0, 1);
        $this->Cell(30, 5, 'Branch:', 0, 0);
        $this->Cell(60, 5, $branch, 0, 1);

        $this->Ln(3);
    }
}

/* ===================== PDF GENERATION ===================== */
function generateMonthlyPDF($userData, $month)
{
    $user_id = $userData["u_id"];
    $name = $userData["u_fname"] . ' ' . $userData["u_lname"];

    $start_date = date("Y-m-01", strtotime($month));
    $end_date   = date("Y-m-t", strtotime($month));
    $filename   = "monthly_summary_user_{$user_id}_{$month}.pdf";

    $pdf = new CustomPDF();
    $pdf->setUserData($userData);
    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, "Monthly Sales Summary - $month", 0, 1, 'C');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 8, 'Proposal No', 1);
    $pdf->Cell(40, 8, 'Policy No', 1);
    $pdf->Cell(30, 8, 'Date', 1);
    $pdf->Cell(40, 8, 'MCFP', 1);
    $pdf->Cell(40, 8, 'FP', 1);
    $pdf->Ln();

    $result = Database::search("
        SELECT pro_num, pol_num, date, payments_pay_id, ammount
        FROM police_t
        WHERE users_u_id = '$user_id'
          AND status_s_id = 1
          AND date BETWEEN '$start_date' AND '$end_date'
        ORDER BY date ASC
    ");

    $totalMCFP = 0;
    $totalFP = 0;

    while ($row = $result->fetch_assoc()) {
        $isMCFP = in_array($row['payments_pay_id'], [1,2,4]);
        if ($isMCFP) $totalMCFP += $row['ammount'];
        else $totalFP += $row['ammount'];

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(40, 8, $row['pro_num'], 1);
        $pdf->Cell(40, 8, $row['pol_num'], 1);
        $pdf->Cell(30, 8, $row['date'], 1);
        $pdf->Cell(40, 8, $isMCFP ? number_format($row['ammount'],2) : '', 1);
        $pdf->Cell(40, 8, !$isMCFP ? number_format($row['ammount'],2) : '', 1);
        $pdf->Ln();
    }

    $pdf->Ln(3);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(150, 8, 'Total MCFP:', 0, 0, 'R');
    $pdf->Cell(40, 8, number_format($totalMCFP, 2), 0, 1, 'R');
    $pdf->Cell(150, 8, 'Total FP:', 0, 0, 'R');
    $pdf->Cell(40, 8, number_format($totalFP, 2), 0, 1, 'R');
    $pdf->Cell(150, 8, 'Grand Total:', 0, 0, 'R');
    $pdf->Cell(40, 8, number_format($totalMCFP + $totalFP, 2), 0, 1, 'R');

    $pdf->Output('F', $filename);
    return $filename;
}

/* ===================== EMAIL ===================== */
function sendEmailWithPDF($email, $name, $month, $pdfFile)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'affinitysoft.solutions@gmail.com';
        $mail->Password = 'yvotplnieooqifhx';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('affinitysoft.solutions@gmail.com', '<noreply>');
        $mail->addAddress($email, $name);
        $mail->addAttachment($pdfFile);

        $mail->isHTML(true);
        $mail->Subject = "Monthly Sales Report - $month";
        $mail->Body = "<p>Dear $name,</p><p>Your monthly report for <b>$month</b> is attached.</p>";

        $mail->send();
        unlink($pdfFile);
    } catch (Exception $e) {}
}

/* ===================== MONTH ===================== */
$month = date("Y-m", strtotime("first day of last month"));
$start_date = date("Y-m-01", strtotime($month));
$end_date   = date("Y-m-t", strtotime($month));

/* ===================== GET ALL ACTIVE USERS ===================== */
$users = Database::search("
    SELECT u_id, u_fname, u_lname, email, code, position_pid, con_num
    FROM users
    WHERE user_State_id = 1
");

/* ===================== PROCESS USERS ===================== */
while ($user = $users->fetch_assoc()) {

    $user_id = $user['u_id'];
    $name = $user['u_fname'];
    $email = $user['email'];
    $contact = $user['con_num'];

    $check = Database::search("
        SELECT 1 FROM summery_t 
        WHERE month = '$month' AND users_u_id = '$user_id'
    ");

    if ($check->num_rows == 0) {

        $summary = Database::search("
            SELECT 
                COUNT(pol_num) AS nope,
                COALESCE(SUM(CASE WHEN payments_pay_id IN (1,2,4) THEN ammount END),0) AS mcfp,
                COALESCE(SUM(CASE WHEN payments_pay_id IN (3,5) THEN ammount END),0) AS fp
            FROM police_t
            WHERE users_u_id = '$user_id'
              AND status_s_id = 1
              AND date BETWEEN '$start_date' AND '$end_date'
        ")->fetch_assoc();

        $nope = $summary['nope'] ?? 0;
        $mcfp = $summary['mcfp'] ?? 0;
        $fp   = $summary['fp'] ?? 0;
        $total = $mcfp + $fp;

        Database::iud("
            INSERT INTO summery_t (month, nope, mcfp, fp, total, users_u_id)
            VALUES ('$month', '$nope', '$mcfp', '$fp', '$total', '$user_id')
        ");
        echo "Inserted summary Successfully for user ID $user_id for month $month.\n";

        if ($contact) {
            $msg = ($nope == 0)
                ? "$name | Monthly Summary\nMonth: $month\nNo policies recorded.\nTotal: Rs. 0.00"
                : "$name | Monthly Summary\nMonth: $month\nPolicies: $nope\nTotal: Rs. $total";

            sendSingleMessage($contact, $msg);
        }
    }else{
        echo "Summary already exists for user ID $user_id for month $month.\n";
    }

    $pdf = generateMonthlyPDF($user, $month);
    sendEmailWithPDF($email, $name, $month, $pdf);
    echo "email sent to $email for month $month.\n";
}
