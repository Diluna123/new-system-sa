<?php


include 'connection.php';



$clid = $_POST['clid'];
$sOrD = $_POST['sOrD'];


if ($sOrD == 1) {

    $data = Database::search("SELECT * FROM `c_leads` WHERE `clid` = '$clid'");
    $cdata = $data->fetch_assoc();

?>



    <div class="row">
        <input type="text" class="form-control form-control-sm d-none" id="clid" value="<?php echo $clid; ?>">
        <div class="col-6">
            <div class="mb-2">
                <label for="recipient-name" class="col-form-label">First Name :</label>
                <input type="text" class="form-control form-control-sm" id="firstName" value="<?php echo $cdata['cname'];?>">
            </div>

        </div>
        <div class="col-6">
            <div class="mb-2">
                <label for="recipient-name" class="col-form-label">Last Name :</label>
                <input type="text" class="form-control form-control-sm" id="lastName" value="">
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="mb-2">
                <label for="recipient-name" class="col-form-label">Contact Number :</label>
                <input type="tel" class="form-control form-control-sm" id="contactNumber" value="<?php echo $cdata['contact_cl'];?>">
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="mb-2">
                <label for="recipient-name" class="col-form-label">Ap. Date :</label>
                <input type="date" class="form-control form-control-sm" id="appointmentDate">
            </div>
        </div>
        <div class="col-6">
            <div class="mb-2">
                <label for="recipient-name" class="col-form-label">Ap. Time :</label>
                <input type="time" class="form-control form-control-sm" id="appointmentTime">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="mb-2">
                <label for="recipient-name" class="col-form-label">Ap.Location :</label>
                <input type="text" class="form-control form-control-sm" id="apLocation" >
            </div>

        </div>

    </div>

    <div class="mb-2">
        <label for="message-text" class="col-form-label">Note :</label>
        <textarea class="form-control" id="note-text"></textarea>
    </div>


<?php






   

} else {

    Database::iud("UPDATE `c_leads` SET `status_s_id` = '3' WHERE `c_leads`.`clid` = $clid ");
    echo "deleted";

}








?>