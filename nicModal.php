<?php

include 'connection.php';

$cid = $_GET['cid'];


$nic = Database::search("SELECT * FROM `pdf_loc` WHERE `customers_id` = '$cid' ");
if ($nic->num_rows == 0) {
    ?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nicModalLabel">NIC PDF Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 class="text-center ">No PDF Found</h5>
            </div>
        </div>
    </div>

    
    
    <?php
} else {
    $nicData = $nic->fetch_assoc();
    $cdata = Database::search("SELECT * FROM `customers` WHERE `id` = '$cid' ")->fetch_assoc();
    
?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="nicModalLabel"><?php echo $cdata['fname']; ?> <?php echo $cdata['lname']; ?> <label for="" class="text-secondary">#<?php echo $cdata['nic']; ?></label></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="nicPreviewFrame" src="<?php echo $nicData['location']; ?>" width="100%" height="500px"></iframe>
            </div>
        </div>
    </div>


<?php


}


?>




<?php

?>