<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <?php
  include '../connection.php';
  session_start();
  ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sanasa Easy Affiliate Program Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      margin: 0;
      background: linear-gradient(135deg, #e0f2f7, #bbdefb);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .registration-container {
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      display: flex;
      max-width: 900px;
      width: 100%;
      flex-direction: row;
      overflow: hidden;
      animation: fadeIn 0.8s ease-out;
    }

    .left-section,
    .right-section {
      padding: 40px;
      width: 50%;
    }

    .left-section {
      background-color: #007bff;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      animation: slideInLeft 1s ease-out;
    }

    .left-section h2 {
      font-size: 2.5em;
      margin-bottom: 20px;
      font-weight: 600;
    }

    .right-section {
      background: white;
      animation: slideInRight 1s ease-out;
    }

    .form-group {
      position: relative;
      margin-bottom: 30px;
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 15px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 1em;
      background-color: white;
      outline: none;
    }

    .form-group label {
      position: absolute;
      top: 15px;
      left: 15px;
      color: #777;
      font-size: 1em;
      pointer-events: none;
      transition: all 0.3s ease;
    }

    .form-group input:focus+label,
    .form-group input:not(:placeholder-shown)+label,
    .form-group select:focus+label,
    .form-group select:valid+label {
      top: -10px;
      left: 10px;
      font-size: 0.8em;
      color: #007bff;
      background-color: white;
      padding: 0 5px;
      border-radius: 2px;
    }

    .form-step {
      display: none;
    }

    .form-step.active {
      display: block;
    }

    button {
      background-color: #007bff;
      color: white;
      padding: 15px 30px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 1.1em;
      width: 100%;
      transition: background-color 0.3s ease, transform 0.2s ease-in-out;
    }

    button:hover {
      background-color: #0056b3;
      transform: scale(1.05);
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: scale(0.95);
      }

      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    @keyframes slideInLeft {
      from {
        opacity: 0;
        transform: translateX(-100px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes slideInRight {
      from {
        opacity: 0;
        transform: translateX(100px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @media (max-width: 768px) {
      .registration-container {
        flex-direction: column;
      }

      .left-section,
      .right-section {
        width: 100%;
        padding: 30px 20px;
      }
    }

    .progress-bar-container {
      width: 100%;
    }

    .step-labels {
      font-weight: 600;
      font-size: 1em;
      margin-bottom: 8px;
      color: #555;
      display: flex;
      justify-content: space-between;
    }

    .step-label {
      width: 50%;
      text-align: center;
    }

    .progress {
      height: 8px;
      background-color: #e0e0e0;
      border-radius: 5px;
      overflow: hidden;
    }

    .progress-bar {
      background-color: #007bff;
      transition: width 0.4s ease;
    }

    #loadingOverlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      z-index: 9999;
      align-items: center;
      justify-content: center;
    }
  </style>
</head>

<body>
  <!-- Loading Spinner -->
  <div id="loadingOverlay">
    <div class="spinner-border text-light" role="status" style="width: 4rem; height: 4rem;">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

  <div id="registrationForm" class="registration-container">
    <div class="left-section">
      <h2>Join the Sanasa Life Affiliate Program</h2>
      <p>Unlock exciting opportunities and start earning by partnering with Sanasa. Our easy-to-use platform makes affiliate marketing simple and rewarding.</p>
    </div>
    <div class="right-section">
      <div class="progress-bar-container mb-4">
        <div class="step-labels">
          <div class="step-label" id="label-step1">Step 1</div>
          <div class="step-label" id="label-step2">Step 2</div>
        </div>
        <div class="progress">
          <div class="progress-bar" id="progressBar" style="width: 50%;"></div>
        </div>
      </div>

      <!-- Step 1 -->
      <div id="step1" class="form-step active">
        <h2>Step 1: Basic Info</h2>
        <div class="form-group">
          <input type="text" id="afnic" name="nic" required placeholder=" " />
          <label for="afnic">NIC</label>
        </div>
        <div class="form-group">
          <input type="password" id="afpassword" name="password" required placeholder=" " />
          <label for="afpassword">Password</label>
        </div>
        <div class="form-group">
          <input type="password" id="afconfirmPassword" name="confirmPassword" required placeholder=" " />
          <label for="afconfirmPassword">Confirm Password</label>
        </div>
        <button type="button" onclick="goToStep2()">Next</button>
      </div>

      <!-- Step 2 -->
      <div id="step2" class="form-step">
        <h2>Step 2: Payment Info</h2>
        <div class="form-group">
          <select name="bankName" id="bankName" required>
            <option value="" disabled selected hidden></option>
            <?php
            $bankD = Database::search("SELECT * FROM `banks`");
            while ($bankR = $bankD->fetch_assoc()) {
              echo '<option value="' . $bankR["idBanks"] . '">' . $bankR["bank_name"] . '</option>';
            }
            ?>
          </select>
          <label for="bankName">Bank Name</label>
        </div>
        <div class="form-group">
          <input type="text" id="branch" name="branch" required placeholder=" " />
          <label for="branch">Branch</label>
        </div>
        <div class="form-group">
          <input type="text" id="accountHolder" name="accountHolder" required placeholder=" " />
          <label for="accountHolder">Account Holder Name</label>
        </div>
        <div class="form-group">
          <input type="text" id="accountNumber" name="accountNumber" required placeholder=" " />
          <label for="accountNumber">Account Number</label>
        </div>
        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" id="agree" onchange="checkAgreement();" required>
          <label class="form-check-label" for="agree">
            I agree to the <a href="termsAndConditions.php">terms and conditions</a>.
          </label>
        </div>
        <button type="button" class="mb-3" onclick="goToStep1()">Back</button>
        <button onclick="afRegister();" disabled id="registerBtnAf" style="background-color: #ccc; cursor: not-allowed;">Register</button>
        <div class="mt-2">
          <small>Already have an account? <a href="login.php">Login</a></small>
        </div>
      </div>
    </div>
  </div>

  
  <script src="script.js"></script>
  <script>
    function goToStep2() {
      const password = document.getElementById('afpassword').value;
      const confirmPassword = document.getElementById('afconfirmPassword').value;

      if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return;
      }

      document.getElementById('step1').classList.remove('active');
      document.getElementById('step2').classList.add('active');
      document.getElementById('progressBar').style.width = '100%';
      document.getElementById('label-step1').style.opacity = '0.6';
      document.getElementById('label-step2').style.opacity = '1';
    }

    function goToStep1() {
      document.getElementById('step2').classList.remove('active');
      document.getElementById('step1').classList.add('active');
      document.getElementById('progressBar').style.width = '50%';
      document.getElementById('label-step1').style.opacity = '1';
      document.getElementById('label-step2').style.opacity = '0.6';
    }

    document.getElementById('registrationForm').addEventListener('submit', function(e) {
      const accountNumber = document.getElementById('accountNumber').value;
      const agree = document.getElementById('agree');

      if (!/^\d{6,20}$/.test(accountNumber)) {
        alert("Please enter a valid account number (6-20 digits).");
        e.preventDefault();
        return;
      }

      if (!agree.checked) {
        alert("You must agree to the terms and conditions.");
        e.preventDefault();
        return;
      }

      document.getElementById('loadingOverlay').style.display = 'flex';
    });

    function checkAgreement(){
      var rbtn = document.getElementById("registerBtnAf");
      var agree = document.getElementById("agree").checked;
      if(agree){
        rbtn.style.backgroundColor = "#007bff";
        rbtn.style.cursor = "pointer";
        rbtn.disabled = false;
      }else{
        rbtn.style.backgroundColor = "#ccc";
        rbtn.style.cursor = "not-allowed";
        rbtn.disabled = true;
      }

    }


  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>