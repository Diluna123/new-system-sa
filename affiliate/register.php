<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sanasa Easy Affiliate Program Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet" />
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
      overflow: hidden;
      display: flex;
      width: 100%;
      max-width: 900px;
      flex-direction: row;
      transition: opacity 0.4s ease-out, transform 0.4s ease-out;
      opacity: 0;
      transform: scale(0.95);
      animation: fadeIn 0.8s forwards;
    }

    .left-section {
      background-color: #007bff;
      color: white;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    .left-section h2 {
      font-size: 2.5em;
      margin-bottom: 20px;
      font-weight: 600;
      animation: slideInLeft 1s ease-out;
    }

    .left-section p {
      font-size: 1.1em;
      line-height: 1.6;
      opacity: 0.8;
      animation: slideInLeft 1s ease-out 0.5s;
    }

    .right-section {
      padding: 40px;
      animation: slideInRight 1s ease-out;
    }

    .right-section h2 {
      color: #333;
      margin-bottom: 30px;
      font-size: 2em;
      font-weight: 600;
      text-align: left;
    }

    .form-group {
      position: relative;
      margin-bottom: 30px;
      transition: transform 0.3s ease;
    }

    .form-group input,
    .form-group textarea {
      width: calc(100% - 20px);
      padding: 15px;
      border: 1px solid #ddd;
      border-radius: 6px;
      box-sizing: border-box;
      font-size: 1em;
      outline: none;
      transition: border-color 0.3s ease, transform 0.3s ease;
    }

    .form-group textarea {
      resize: vertical;
    }

    .form-group input:focus,
    .form-group textarea:focus {
      transform: translateY(-3px);
      border-color: #007bff;
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

    .form-group input:focus + label,
    .form-group input:not(:placeholder-shown) + label,
    .form-group textarea:focus + label,
    .form-group textarea:not(:placeholder-shown) + label {
      top: -10px;
      left: 10px;
      font-size: 0.8em;
      color: #007bff;
      background-color: white;
      padding: 0 5px;
      border-radius: 2px;
    }

    .optional::after {
      content: " (optional)";
      color: #999;
      font-size: 0.8em;
    }

    .required::after {
      content: " (required)";
      color: #dc3545;
      font-size: 0.8em;
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

    .error-message {
      color: #dc3545;
      font-size: 0.9em;
      margin-top: 5px;
    }

    /* Animation for container fade-in */
    @keyframes fadeIn {
      0% {
        opacity: 0;
        transform: scale(0.95);
      }
      100% {
        opacity: 1;
        transform: scale(1);
      }
    }

    /* Slide-in from left */
    @keyframes slideInLeft {
      0% {
        opacity: 0;
        transform: translateX(-100px);
      }
      100% {
        opacity: 1;
        transform: translateX(0);
      }
    }

    /* Slide-in from right */
    @keyframes slideInRight {
      0% {
        opacity: 0;
        transform: translateX(100px);
      }
      100% {
        opacity: 1;
        transform: translateX(0);
      }
    }

    /* Adjustments for desktop screen */
    @media (min-width: 992px) {
      .left-section h2 {
        font-size: 2em;
      }

      .left-section p {
        font-size: 1em;
      }

      .right-section h2 {
        font-size: 1.6em;
      }

      .form-group input,
      .form-group textarea {
        padding: 12px;
        font-size: 0.95em;
      }

      .form-group label {
        font-size: 0.9em;
      }

      .form-group input:focus + label,
      .form-group input:not(:placeholder-shown) + label,
      .form-group textarea:focus + label,
      .form-group textarea:not(:placeholder-shown) + label {
        font-size: 0.75em;
      }

      button {
        padding: 12px 20px;
        font-size: 1em;
      }

      .registration-container {
        max-width: 800px;
      }
    }

    /* Responsive adjustment for smaller screens */
    @media (max-width: 768px) {
      .registration-container {
        flex-direction: column;
      }

      .left-section,
      .right-section {
        width: 100%;
      }

      .left-section {
        padding: 30px 20px;
      }

      .right-section {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="registration-container row mx-auto">
      <div class="left-section col-md-5">
        <h2>Join the Sanasa Life Affiliate Program</h2>
        <p>Unlock exciting opportunities and start earning by partnering with Sanasa. Our easy-to-use platform makes affiliate marketing simple and rewarding.</p>
      </div>
      <div class="right-section col-md-7">
        <h2>Registration</h2>
        <form id="registrationForm">
          <div class="form-group">
            <input type="text" id="firstName" name="firstName" required placeholder=" " />
            <label for="firstName">First Name</label>
          </div>
          <div class="form-group">
            <input type="text" id="lastName" name="lastName" required placeholder=" " />
            <label for="lastName">Last Name</label>
          </div>
          <div class="form-group">
            <input type="email" id="email" name="email" placeholder=" " />
            <label for="email">Email <span class="optional"></span></label>
          </div>
          <div class="form-group">
            <input type="text" id="nic" name="nic" placeholder=" " />
            <label for="nic">NIC</label>
          </div>
          <div class="form-group">
            <input type="text" id="contactNum" name="contactNum" required placeholder=" " />
            <label for="contactNum">Contact Number <span class="required"></span></label>
          </div>
          <div class="form-group">
            <input type="password" id="password" name="password" required placeholder=" " />
            <label for="password">Password</label>
          </div>
          <div class="form-group">
            <input type="password" id="confirmPassword" name="confirmPassword" required placeholder=" " />
            <label for="confirmPassword">Confirm Password</label>
          </div>
          <div class="form-group">
            <textarea id="address" name="address" rows="3" placeholder=" "></textarea>
            <label for="address">Address</label>
          </div>
          <button type="submit">Register</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const form = document.getElementById('registrationForm');

      form.addEventListener('submit', (event) => {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const contactNum = document.getElementById('contactNum').value;

        if (password !== confirmPassword) {
          alert("Passwords do not match.");
          event.preventDefault();
        }

        if (!/^\d{10}$/.test(contactNum)) {
          alert("Please enter a valid 10-digit contact number.");
          event.preventDefault();
        }
      });
    });
  </script>
</body>
</html>
