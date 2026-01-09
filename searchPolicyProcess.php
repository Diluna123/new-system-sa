<?php
session_start();
include "connection.php";
$policyNumber = $_POST['policyNumber'] ?? '';
$userId = $_SESSION['user']['u_id'];

$query = "SELECT * FROM `police_t` JOIN `customers` ON `police_t`.`customers_id`=`customers`.`id` JOIN `plans` ON `police_t`.`plans_p_id`=`plans`.`p_id` JOIN `payments` ON `police_t`.`payments_pay_id`=`payments`.`pay_id` JOIN `users` ON `police_t`.`users_u_id`=`users`.`u_id` WHERE `pol_num` LIKE '%$policyNumber%' AND `users_u_id`='$userId'";

$result = Database::search($query);
$count = $result->num_rows;

if ($count == 1) {

    $data = $result->fetch_assoc();

?>
    <!-- PERSONAL INFORMATION -->
    <div class="col-12 mb-4">
        <div class="card bg-dark border-secondary shadow-sm">
            <div class="card-header border-secondary">
                <h6 class="mb-0 text-info">
                    <i class="bi bi-person-badge me-2"></i> Personal Information
                </h6>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="name" placeholder="Name" value="<?php echo $data['fname'] . ' ' . $data['lname']; ?>
" readonly>
                            <label for="name">Full Name</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="nic" value="<?php echo $data['nic']; ?>" placeholder="NIC" readonly>
                            <label for="nic">NIC Number</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="contact" value="<?php echo $data['contact']; ?>" placeholder="Contact" readonly>
                            <label for="contact">Contact</label>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="age" value="<?php echo $data['age']; ?>" placeholder="Age" readonly>
                            <label for="age">Age</label>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="dob" value="<?php echo $data['dob']; ?>" placeholder="DOB" readonly>
                            <label for="dob">Date of Birth</label>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="location" value="<?php echo $data['location']; ?>" placeholder="Location" readonly>
                            <label for="location">Location</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="address" value="<?php echo $data['addres']; ?>" placeholder="Address" readonly>
                            <label for="address">Address</label>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- POLICY & PAYMENT INFORMATION -->
    <div class="col-12">
        <div class="card bg-dark border-secondary shadow-sm">
            <div class="card-header border-secondary">
                <h6 class="mb-0 text-warning">
                    <i class="bi bi-file-earmark-text me-2"></i> Policy & Payment Information
                </h6>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="plan" value="<?php echo $data['plane']; ?>" placeholder="Plan" readonly>
                            <label for="plan">Plan</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="paymentType" value="<?php echo $data['payment_ty']; ?>" placeholder="Payment Type" readonly>
                            <label for="paymentType">Payment Type</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="amount" value="<?php echo $data['ammount']; ?>" placeholder="Amount" readonly>
                            <label for="amount">Amount (LKR)</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="period" value="<?php echo $data['time_p']; ?>" placeholder="Time Period" readonly>
                            <label for="period">Time Period</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="user" value="<?php echo $data['u_fname'].' ('.$data['code'].')'; ?>" placeholder="User" readonly>
                            <label for="user">User</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="date" value="<?php echo $data['date']; ?>" placeholder="Date" readonly>
                            <label for="date">Date</label>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>










<?php



} else {
    echo "No matching policy found. or multiple policies found.";
}





?>