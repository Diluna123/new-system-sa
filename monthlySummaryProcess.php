<?php
session_start();
require_once 'connection.php';
include "email_send/Exception.php";
include "email_send/SMTP.php";
include "email_send/PHPMailer.php"; // For PHPMailer + Composer
require 'fpdf/fpdf.php';


// send sms functions




/**
 * @param string     $number      The mobile number where you want to send message.
 * @param string     $message     The message you want to send.
 * @param int|string $device      The ID of a device you want to use to send this message.
 * @param int        $schedule    Set it to timestamp when you want to send this message.
 * @param bool       $isMMS       Set it to true if you want to send MMS message instead of SMS.
 * @param string     $attachments Comma separated list of image links you want to attach to the message. Only works for MMS messages.
 * @param bool       $prioritize  Set it to true if you want to prioritize this message.
 *
 * @return array     Returns The array containing information about the message.
 * @throws Exception If there is an error while sending a message.
 */

include 'sms_modal.php';


use PHPMailer\PHPMailer\PHPMailer;

// Custom PDF class
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
        $lineHeight = 5;
        $labelWidth = 25;
        $valueWidth = 60;
        $this->Image('sansa.png', 170, 5, 30);

        // Use passed user data
        $positionId = $this->userData["position_pid"] ?? 0;
        $designation = ($positionId == 1) ? "SPO" : (($positionId == 2) ? "TL" : "Staff");

        date_default_timezone_set('Asia/Colombo');
        $date = date('Y-m-d') . " " . date('h:i A');

        $name = $this->userData["u_fname"] . " " . $this->userData["u_lname"];
        $code = $this->userData["code"] ?? 'N/A';
        $branch = 'Madampe';

        $this->Cell($labelWidth, $lineHeight, 'Designation:', 0, 0);
        $this->Cell($valueWidth, $lineHeight, $designation, 0, 1);
        $this->Cell($labelWidth, $lineHeight, 'Date:', 0, 0);
        $this->Cell($valueWidth, $lineHeight, $date, 0, 1);
        $this->Cell($labelWidth, $lineHeight, 'Name:', 0, 0);
        $this->Cell($valueWidth, $lineHeight, $name, 0, 1);
        $this->Cell($labelWidth, $lineHeight, 'Code:', 0, 0);
        $this->Cell($valueWidth, $lineHeight, $code, 0, 1);
        $this->Cell($labelWidth, $lineHeight, 'Branch:', 0, 0);
        $this->Cell($valueWidth, $lineHeight, $branch, 0, 1);

        $this->Ln(3);
    }
}

// Function to generate PDF
function generateMonthlyPDF($userData, $month)

{
    $user_id = $userData["u_id"];
    $name = $userData["u_fname"] . ' ' . $userData["u_lname"];

    $start_date = date("Y-m-01", strtotime($month));
    $end_date = date("Y-m-t", strtotime($month));
    $filename = "monthly_summary_user_{$user_id}_{$month}.pdf";

    // Create the custom PDF
    $pdf = new CustomPDF();
    $pdf->setUserData($userData); // ⬅️ this sets the data used in Header()
    $pdf->AddPage();;
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, "Monthly Sales Summary for $name", 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, "Month: $month", 0, 1);

    // Table headers
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 8, 'Proposal No', 1);
    $pdf->Cell(40, 8, 'Policy No', 1);
    $pdf->Cell(30, 8, 'Date', 1);
    $pdf->Cell(40, 8, 'MCFP Amount', 1);
    $pdf->Cell(40, 8, 'FP Amount', 1);
    $pdf->Ln();

    // Fetch data
    $result = Database::search("
    SELECT pro_num, pol_num, date, payments_pay_id, ammount 
    FROM police_t 
    WHERE users_u_id = '$user_id' 
        AND date BETWEEN '$start_date' AND '$end_date'
        AND status_s_id = 1
    ORDER BY date ASC
");

    $totalMCFP = 0;
    $totalFP = 0;

    while ($row = $result->fetch_assoc()) {
        $isMCFP = in_array($row['payments_pay_id'], [1, 2, 4]);
        $amount = number_format($row['ammount'], 2);

        $mcfp = $isMCFP ? "Rs. $amount" : '';
        $fp = !$isMCFP ? "Rs. $amount" : '';

        if ($isMCFP) {
            $totalMCFP += $row['ammount'];
        } else {
            $totalFP += $row['ammount'];
        }

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(40, 8, $row['pro_num'], 1);
        $pdf->Cell(40, 8, $row['pol_num'], 1);
        $pdf->Cell(30, 8, $row['date'], 1);
        $pdf->Cell(40, 8, $mcfp, 1);
        $pdf->Cell(40, 8, $fp, 1);
        $pdf->Ln();
    }

    // Totals
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Ln(3);
    $pdf->Cell(150, 8, 'Total MCFP:', 0, 0, 'R');
    $pdf->Cell(40, 8, 'Rs. ' . number_format($totalMCFP, 2), 0, 1, 'R');
    $pdf->Cell(150, 8, 'Total FP:', 0, 0, 'R');
    $pdf->Cell(40, 8, 'Rs. ' . number_format($totalFP, 2), 0, 1, 'R');
    $pdf->Cell(150, 8, 'Grand Total:', 0, 0, 'R');
    $pdf->Cell(40, 8, 'Rs. ' . number_format($totalMCFP + $totalFP, 2), 0, 1, 'R');

    $pdf->Output('F', $filename);
    return $filename;
}

// Function to send email with PDF attachment
function sendEmailWithPDF($email, $name, $month, $pdfFile)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'dilunasithija111@gmail.com';
        $mail->Password = 'egwpikpqbqywmgor';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('dilunasithija111@gmail.com', 'Sales Report');
        $mail->addAddress($email, $name);
        $mail->addAttachment($pdfFile);

        $mail->isHTML(true);
        $mail->Subject = "Monthly Sales Report - $month";
        $mail->Body = "
            <h3>Hi $name,</h3>
            <p>Please find your monthly sales report attached for <strong>$month</strong>.</p>
            <p>It includes detailed policy data and total amounts.</p>
            <br><p>Regards,<br>Sales Team</p>
        ";

        $mail->send();
        echo "✅ Email sent to $email<br>";

        unlink($pdfFile);
    } catch (Exception $e) {
        echo "❌ Email failed to $email: {$mail->ErrorInfo}<br>";
    }
}

// Step 1: Get last month's date range
$month = date("Y-m", strtotime("first day of last month"));
$start_date = date("Y-m-01", strtotime($month));
$end_date = date("Y-m-t", strtotime($month));

// Step 2: Get users who had sales last month
$users = Database::search("
    SELECT DISTINCT u.u_id, u.u_fname, u.u_lname, u.email, u.code, u.position_pid, u.con_num
    FROM police_t p
    JOIN users u ON u.u_id = p.users_u_id
    WHERE p.date BETWEEN '$start_date' AND '$end_date'
");

while ($user = $users->fetch_assoc()) {
    $user_id = $user['u_id'];
    $name = $user['u_fname'];
    $email = $user['email'];
    $contact = $user['con_num'];

    // Check if summary for this user exists
    $check = Database::search("SELECT * FROM summery_t WHERE month = '$month' AND users_u_id = '$user_id'");
    if ($check->num_rows == 0) {
        // Generate summary
        $summary = Database::search("
            SELECT COUNT(*) AS nope,
                SUM(CASE WHEN payments_pay_id IN ('1', '2', '4') THEN ammount ELSE 0 END) AS mcfp,
                SUM(CASE WHEN payments_pay_id IN ('3', '5') THEN ammount ELSE 0 END) AS fp
            FROM police_t
            WHERE users_u_id = '$user_id' 
                AND date BETWEEN '$start_date' AND '$end_date'
                AND status_s_id = 1
        ");
        $data = $summary->fetch_assoc();

        // Insert summary into the database
        $nope = $data['nope'];
        $mcfp = $data['mcfp'] ?: 0;
        $fp = $data['fp'] ?: 0;
        $total = $mcfp + $fp;

        Database::iud("INSERT INTO summery_t (month, nope, mcfp, fp, total, users_u_id) 
                       VALUES ('$month', '$nope', '$mcfp', '$fp', '$total', '$user_id')");

        if ($contact != null) {
            $message = $name . " | Monthly Summary Updated!\n" .
                "Month: $month\n" .
                "No. of Policies: $nope\n" .
                "MCFP: Rs. $mcfp\n" .
                "FP: Rs. $fp\n" .
                "Total: Rs. $total";



            sendSingleMessage($contact, $message);
        }
        echo "✅ Inserted summary for user $user_id ($month)<br>";
    } else {
        echo "⚠️ Summary already exists for user $user_id ($month)<br>";
    }

    // Generate PDF and send email
    $pdfFile = generateMonthlyPDF($user, $month);
    sendEmailWithPDF($email, $name, $month, $pdfFile);
}
