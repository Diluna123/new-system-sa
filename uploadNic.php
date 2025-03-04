<?php
include 'connection.php';

$cid = $_POST["cid"];

// Allowed file types (PDF and common images)
$allowed = array("application/pdf", "image/png", "image/jpeg", "image/jpg", "image/gif");

if (isset($_FILES["nicp"])) {
    $pImg = $_FILES["nicp"];
    $file_type = $pImg["type"];

    if (in_array($file_type, $allowed)) {
        // Determine file extension
        $extension = pathinfo($pImg["name"], PATHINFO_EXTENSION);
        $new_name = "pdfs/" . uniqid() . "." . $extension;

        // Move the uploaded file
        if (move_uploaded_file($pImg["tmp_name"], $new_name)) {
            $resU = Database::search("SELECT * FROM `pdf_loc` WHERE `customers_id` = '$cid' ");
            $numsp = $resU->num_rows;

            if ($numsp > 0) {
                Database::iud("UPDATE `pdf_loc` SET `location` = '$new_name' WHERE `customers_id` = '$cid'");
            } else {
                Database::iud("INSERT INTO `pdf_loc` (`location`, `customers_id`) VALUES ('$new_name', '$cid')");
            }
            echo "success";
        } else {
            echo "File upload failed.";
        }
    } else {
        echo "Invalid file type. Only PDF and images are allowed.";
    }
} else {
    echo "Please select a file.";
}
?>
