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

define("SERVER", "https://app.sms8.io");
define("API_KEY", "ccf0b8370300b908ebd8baa6eb56f3f9f168b504");

define("USE_SPECIFIED", 0);
define("USE_ALL_DEVICES", 1);
define("USE_ALL_SIMS", 2);

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
function sendSingleMessage($number, $message, $device = 0, $schedule = null, $isMMS = false, $attachments = null, $prioritize = false)
{
    $url = SERVER . "/services/send.php";
    $postData = array(
        'number' => $number,
        'message' => $message,
        'schedule' => $schedule,
        'key' => API_KEY,
        'devices' => $device,
        'type' => $isMMS ? "mms" : "sms",
        'attachments' => $attachments,
        'prioritize' => $prioritize ? 1 : 0
    );
    return sendRequest($url, $postData)["messages"][0];
}

/**
 * @param array  $messages        The array containing numbers and messages.
 * @param int    $option          Set this to USE_SPECIFIED if you want to use devices and SIMs specified in devices argument.
 *                                Set this to USE_ALL_DEVICES if you want to use all available devices and their default SIM to send messages.
 *                                Set this to USE_ALL_SIMS if you want to use all available devices and all their SIMs to send messages.
 * @param array  $devices         The array of ID of devices you want to use to send these messages.
 * @param int    $schedule        Set it to timestamp when you want to send these messages.
 * @param bool   $useRandomDevice Set it to true if you want to send messages using only one random device from selected devices.
 *
 * @return array     Returns The array containing messages.
 *                   For example :-
 *                   [
 *                      0 => [
 *                              "ID" => "1",
 *                              "number" => "+11234567890",
 *                              "message" => "This is a test message.",
 *                              "deviceID" => "1",
 *                              "simSlot" => "0",
 *                              "userID" => "1",
 *                              "status" => "Pending",
 *                              "type" => "sms",
 *                              "attachments" => null,
 *                              "sentDate" => "2018-10-20T00:00:00+02:00",
 *                              "deliveredDate" => null
 *                              "groupID" => ")V5LxqyBMEbQrl9*J$5bb4c03e8a07b7.62193871"
 *                           ]
 *                   ]
 * @throws Exception If there is an error while sending messages.
 */
function sendMessages($messages, $option = USE_SPECIFIED, $devices = [], $schedule = null, $useRandomDevice = false)
{
    $url = SERVER . "/services/send.php";
    $postData = [
        'messages' => json_encode($messages),
        'schedule' => $schedule,
        'key' => API_KEY,
        'devices' => json_encode($devices),
        'option' => $option,
        'useRandomDevice' => $useRandomDevice
    ];
    return sendRequest($url, $postData)["messages"];
}

/**
 * @param int    $listID      The ID of the contacts list where you want to send this message.
 * @param string $message     The message you want to send.
 * @param int    $option      Set this to USE_SPECIFIED if you want to use devices and SIMs specified in devices argument.
 *                            Set this to USE_ALL_DEVICES if you want to use all available devices and their default SIM to send messages.
 *                            Set this to USE_ALL_SIMS if you want to use all available devices and all their SIMs to send messages.
 * @param array  $devices     The array of ID of devices you want to use to send the message.
 * @param int    $schedule    Set it to timestamp when you want to send this message.
 * @param bool   $isMMS       Set it to true if you want to send MMS message instead of SMS.
 * @param string $attachments Comma separated list of image links you want to attach to the message. Only works for MMS messages.
 *
 * @return array     Returns The array containing messages.
 * @throws Exception If there is an error while sending messages.
 */
function sendMessageToContactsList($listID, $message, $option = USE_SPECIFIED, $devices = [], $schedule = null, $isMMS = false, $attachments = null)
{
    $url = SERVER . "/services/send.php";
    $postData = [
        'listID' => $listID,
        'message' => $message,
        'schedule' => $schedule,
        'key' => API_KEY,
        'devices' => json_encode($devices),
        'option' => $option,
        'type' => $isMMS ? "mms" : "sms",
        'attachments' => $attachments
    ];
    return sendRequest($url, $postData)["messages"];
}

/**
 * @param int $id The ID of a message you want to retrieve.
 *
 * @return array     The array containing a message.
 * @throws Exception If there is an error while getting a message.
 */
function getMessageByID($id)
{
    $url = SERVER . "/services/read-messages.php";
    $postData = [
        'key' => API_KEY,
        'id' => $id
    ];
    return sendRequest($url, $postData)["messages"][0];
}

/**
 * @param string $groupID The group ID of messages you want to retrieve.
 *
 * @return array     The array containing messages.
 * @throws Exception If there is an error while getting messages.
 */
function getMessagesByGroupID($groupID)
{
    $url = SERVER . "/services/read-messages.php";
    $postData = [
        'key' => API_KEY,
        'groupId' => $groupID
    ];
    return sendRequest($url, $postData)["messages"];
}

/**
 * @param string $status         The status of messages you want to retrieve.
 * @param int    $deviceID       The deviceID of the device which messages you want to retrieve.
 * @param int    $simSlot        Sim slot of the device which messages you want to retrieve. Similar to array index. 1st slot is 0 and 2nd is 1.
 * @param int    $startTimestamp Search for messages sent or received after this time.
 * @param int    $endTimestamp   Search for messages sent or received before this time.
 *
 * @return array     The array containing messages.
 * @throws Exception If there is an error while getting messages.
 */
function getMessagesByStatus($status, $deviceID = null, $simSlot = null, $startTimestamp = null, $endTimestamp = null)
{
    $url = SERVER . "/services/read-messages.php";
    $postData = [
        'key' => API_KEY,
        'status' => $status,
        'deviceID' => $deviceID,
        'simSlot' => $simSlot,
        'startTimestamp' => $startTimestamp,
        'endTimestamp' => $endTimestamp
    ];
    return sendRequest($url, $postData)["messages"];
}

/**
 * @param int $id The ID of a message you want to resend.
 *
 * @return array     The array containing a message.
 * @throws Exception If there is an error while resending a message.
 */
function resendMessageByID($id)
{
    $url = SERVER . "/services/resend.php";
    $postData = [
        'key' => API_KEY,
        'id' => $id
    ];
    return sendRequest($url, $postData)["messages"][0];
}

/**
 * @param string $groupID The group ID of messages you want to resend.
 * @param string $status  The status of messages you want to resend.
 *
 * @return array     The array containing messages.
 * @throws Exception If there is an error while resending messages.
 */
function resendMessagesByGroupID($groupID, $status = null)
{
    $url = SERVER . "/services/resend.php";
    $postData = [
        'key' => API_KEY,
        'groupId' => $groupID,
        'status' => $status
    ];
    return sendRequest($url, $postData)["messages"];
}

/**
 * @param string $status         The status of messages you want to resend.
 * @param int    $deviceID       The deviceID of the device which messages you want to resend.
 * @param int    $simSlot        Sim slot of the device which messages you want to resend. Similar to array index. 1st slot is 0 and 2nd is 1.
 * @param int    $startTimestamp Resend messages sent or received after this time.
 * @param int    $endTimestamp   Resend messages sent or received before this time.
 *
 * @return array     The array containing messages.
 * @throws Exception If there is an error while resending messages.
 */
function resendMessagesByStatus($status, $deviceID = null, $simSlot = null, $startTimestamp = null, $endTimestamp = null)
{
    $url = SERVER . "/services/resend.php";
    $postData = [
        'key' => API_KEY,
        'status' => $status,
        'deviceID' => $deviceID,
        'simSlot' => $simSlot,
        'startTimestamp' => $startTimestamp,
        'endTimestamp' => $endTimestamp
    ];
    return sendRequest($url, $postData)["messages"];
}

/**
 * @param int    $listID      The ID of the contacts list where you want to add this contact.
 * @param string $number      The mobile number of the contact.
 * @param string $name        The name of the contact.
 * @param bool   $resubscribe Set it to true if you want to resubscribe this contact if it already exists.
 *
 * @return array     The array containing a newly added contact.
 * @throws Exception If there is an error while adding a new contact.
 */
function addContact($listID, $number, $name = null, $resubscribe = false)
{
    $url = SERVER . "/services/manage-contacts.php";
    $postData = [
        'key' => API_KEY,
        'listID' => $listID,
        'number' => $number,
        'name' => $name,
        'resubscribe' => $resubscribe
    ];
    return sendRequest($url, $postData)["contact"];
}

/**
 * @param int    $listID The ID of the contacts list from which you want to unsubscribe this contact.
 * @param string $number The mobile number of the contact.
 *
 * @return array     The array containing the unsubscribed contact.
 * @throws Exception If there is an error while setting subscription to false.
 */
function unsubscribeContact($listID, $number)
{
    $url = SERVER . "/services/manage-contacts.php";
    $postData = [
        'key' => API_KEY,
        'listID' => $listID,
        'number' => $number,
        'unsubscribe' => true
    ];
    return sendRequest($url, $postData)["contact"];
}

/**
 * @return string    The amount of message credits left.
 * @throws Exception If there is an error while getting message credits.
 */
function getBalance()
{
    $url = SERVER . "/services/send.php";
    $postData = [
        'key' => API_KEY
    ];
    $credits = sendRequest($url, $postData)["credits"];
    return is_null($credits) ? "Unlimited" : $credits;
}

/**
 * @param string $request   USSD request you want to execute. e.g. *150#
 * @param int $device       The ID of a device you want to use to send this message.
 * @param int|null $simSlot Sim you want to use for this USSD request. Similar to array index. 1st slot is 0 and 2nd is 1.
 *
 * @return array     The array containing details about USSD request that was sent.
 * @throws Exception If there is an error while sending a USSD request.
 */
function sendUssdRequest($request, $device, $simSlot = null)
{
    $url = SERVER . "/services/send-ussd-request.php";
    $postData = [
        'key' => API_KEY,
        'request' => $request,
        'device' => $device,
        'sim' => $simSlot
    ];
    return sendRequest($url, $postData)["request"];
}

/**
 * @param int $id The ID of a USSD request you want to retrieve.
 *
 * @return array     The array containing details about USSD request you requested.
 * @throws Exception If there is an error while getting a USSD request.
 */
function getUssdRequestByID($id)
{
    $url = SERVER . "/services/read-ussd-requests.php";
    $postData = [
        'key' => API_KEY,
        'id' => $id
    ];
    return sendRequest($url, $postData)["requests"][0];
}

/**
 * @param string   $request        The request text you want to look for.
 * @param int      $deviceID       The deviceID of the device which USSD requests you want to retrieve.
 * @param int      $simSlot        Sim slot of the device which USSD requests you want to retrieve. Similar to array index. 1st slot is 0 and 2nd is 1.
 * @param int|null $startTimestamp Search for USSD requests sent after this time.
 * @param int|null $endTimestamp   Search for USSD requests sent before this time.
 *
 * @return array     The array containing USSD requests.
 * @throws Exception If there is an error while getting USSD requests.
 */
function getUssdRequests($request, $deviceID = null, $simSlot = null, $startTimestamp = null, $endTimestamp = null)
{
    $url = SERVER . "/services/read-ussd-requests.php";
    $postData = [
        'key' => API_KEY,
        'request' => $request,
        'deviceID' => $deviceID,
        'simSlot' => $simSlot,
        'startTimestamp' => $startTimestamp,
        'endTimestamp' => $endTimestamp
    ];
    return sendRequest($url, $postData)["requests"];
}

/**
 * @return array     The array containing all enabled devices
 * @throws Exception If there is an error while getting devices.
 */
function getDevices()
{
    $url = SERVER . "/services/get-devices.php";
    $postData = [
        'key' => API_KEY
    ];
    return sendRequest($url, $postData)["devices"];
}

function sendRequest($url, $postData)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }
    curl_close($ch);
    if ($httpCode == 200) {
        $json = json_decode($response, true);
        if ($json == false) {
            if (empty($response)) {
                throw new Exception("Missing data in request. Please provide all the required information to send messages.");
            } else {
                throw new Exception($response);
            }
        } else {
            if ($json["success"]) {
                return $json["data"];
            } else {
                throw new Exception($json["error"]["message"]);
            }
        }
    } else {
        throw new Exception("HTTP Error Code : {$httpCode}");
    }
}



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
