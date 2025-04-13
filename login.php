<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SANASA EASY | Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="icon" type="image/png" href="sansalogo.png" />

  <style>
    body {
      background-color: rgb(27, 27, 27);
    }

    .login-container {
      max-width: 400px;
      margin: 50px auto;
      padding: 20px;
      background: rgb(27, 27, 27);
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Splash Styles */
    #splash {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 100vw;
      background-color: #121212;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      animation: fadeOut 1s ease forwards;
      animation-delay: 3.5s;
    }

    #splash img {
      width: 100px;
      height: auto;
      margin-bottom: 20px;
      animation: bounceIn 1s ease;
    }

    #splash h1 {
      color: #ffc107;
      font-size: 1.2rem;
      white-space: nowrap;
      overflow: hidden;
      border-right: 2px solid #ffc107;
      width: 0;
      animation: typing 2.5s steps(40, end) forwards, blink 0.75s step-end infinite;
    }

    @keyframes bounceIn {
      0% {
        transform: scale(0.3);
        opacity: 0;
      }

      50% {
        transform: scale(1.05);
        opacity: 1;
      }

      70% {
        transform: scale(0.9);
      }

      100% {
        transform: scale(1);
      }
    }

    @keyframes typing {
      from {
        width: 0;
      }

      to {
        width: 22.7ch;
      }
    }

    @keyframes blink {
      50% {
        border-color: transparent;
      }
    }

    @keyframes fadeOut {
      to {
        opacity: 0;
        visibility: hidden;
      }
    }
  </style>
</head>

<body>
  <!-- Splash Screen -->
  <div id="splash">
    <img src="sansalogo.png" alt="Logo" />
    <h1>Policy Management System</h1>
  </div>

  <div class="container">
    <div class="login-container">
      <div>
        <h4 class="text-center text-light">Sansa Easy</h4>
        <small class="text-secondary text-center fw-light"> @version 2.0.5</small>

      </div>
      <?php

                    $email = "";
                    $psw = "";

                    if (isset($_COOKIE["email"])) {
                        $email = $_COOKIE["email"];
                    }
                    if (isset($_COOKIE["password"])) {
                        $psw = $_COOKIE["password"];
                    }


                    ?>



      <div class="mb-3">
        <label for="email" class="form-label text-light">Email address</label>
        <input type="email" class="form-control" id="email" placeholder="Enter email" value="<?php echo $email; ?>" />
      </div>
      <div class="mb-3">
        <label for="password" class="form-label text-light">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Enter password"  value="<?php echo $psw; ?>" />
      </div>
      <div class="row mt-1">
        <div class="col-6">

          <input type="checkbox" id="rpw" class="form-label mt-1" <?php if(isset($_COOKIE["password"])){echo 'checked';} ?>>
          <label for="rpw" class="form-label " >Remember me</label>

        </div>
        
      </div>
      <button class="btn btn-warning w-100" onclick="signin();">Login</button>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="dashboard.js"></script>
</body>

</html>