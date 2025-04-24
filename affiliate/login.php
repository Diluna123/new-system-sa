<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sanasa Easy Affiliate Program Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

        .login-container {
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
        }

        .form-group input {
            width: calc(100% - 20px);
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 1em;
            outline: none;
            transition: border-color 0.3s ease, transform 0.3s ease;
        }

        .form-group input:focus {
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

        .form-group input:focus+label,
        .form-group input:not(:placeholder-shown)+label {
            top: -10px;
            left: 10px;
            font-size: 0.8em;
            color: #007bff;
            background-color: white;
            padding: 0 5px;
            border-radius: 2px;
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

        /* Language toggle button styling */
        #langToggle {
            background-color: transparent;
            color: #007bff;
            padding: 5px 15px;
            border: 1px solid #007bff;
            border-radius: 30px;
            cursor: pointer;
            font-size: 1em;
            display: flex;
            align-items: center;
        }

        #langToggle i {
            margin-right: 5px;
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

            .form-group input {
                padding: 12px;
                font-size: 0.95em;
            }

            .form-group label {
                font-size: 0.9em;
            }

            .form-group input:focus+label,
            .form-group input:not(:placeholder-shown)+label {
                font-size: 0.75em;
            }

            button {
                padding: 12px 20px;
                font-size: 1em;
            }

            .login-container {
                max-width: 800px;
            }
        }

        /* Responsive adjustment for smaller screens */
        @media (max-width: 768px) {
            .login-container {
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
        <div class="login-container row mx-auto">
            <div class="left-section col-md-5">
                <h2 id="welcomeText">Welcome Back to Sanasa Easy</h2>
                <p id="loginText">Login to your account and start managing your affiliate tasks.</p>
            </div>
            <div class="right-section col-md-7">
                <h2 id="loginHeader">Login</h2>
                <form id="loginForm">
                    <div class="form-group">
                        <input type="text" id="contactNum" name="contactNum" required />
                        <label for="contactNum" id="contactNumLabel">Contact Number</label>
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" name="password" required />
                        <label for="password" id="passwordLabel">Password</label>
                    </div>
                    <button type="submit">Login</button>
                </form>
                <div class="mt-3">
                    <button id="langToggle" class="btn border-0 text-secondary text-center">
                      <span id="langText">Switch to Sinhala</span>
                    </button>
                </div>
                <!-- Affiliate Program link -->
                <div class="mt-3">
                    <a href="register.php" class="btn btn-link text-secondary text-center">
                        Affiliate Program Registeration
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Language text object for English and Sinhala
        const texts = {
            en: {
                welcomeText: "Welcome Back to Sanasa Easy",
                loginText: "Login to your account and start managing your affiliate tasks.",
                loginHeader: "Login",
                contactNumLabel: "Contact Number",
                passwordLabel: "Password",
                loginButton: "Login",
                langToggle: "Switch to Sinhala",
            },
            si: {
                welcomeText: "සනසා ඉසි අන්තර්ජාල වැඩසටහනට ආයුබෝවන්",
                loginText: "ඔබගේ ගිණුමට පිවිස ඔබගේ අයැදුම් පනස්වන්න.",
                loginHeader: "පිවිසෙන්න",
                contactNumLabel: "සම්බන්ධතා අංකය",
                passwordLabel: "මුරපදය",
                loginButton: "පිවිසෙන්න",
                langToggle: "Switch to English",
            },
        };

        let currentLang = "en";

        // Function to toggle language
        const toggleLanguage = () => {
            currentLang = currentLang === "en" ? "si" : "en";
            updateTexts();
        };

        // Update the text content based on the selected language
        const updateTexts = () => {
            document.getElementById("welcomeText").innerText = texts[currentLang].welcomeText;
            document.getElementById("loginText").innerText = texts[currentLang].loginText;
            document.getElementById("loginHeader").innerText = texts[currentLang].loginHeader;
            document.getElementById("contactNumLabel").innerText = texts[currentLang].contactNumLabel;
            document.getElementById("passwordLabel").innerText = texts[currentLang].passwordLabel;
            document.querySelector('button[type="submit"]').innerText = texts[currentLang].loginButton;
            document.getElementById("langToggle").innerText = texts[currentLang].langToggle;
            document.getElementById("langIcon").classList.toggle("fa-globe", currentLang === "en");
            document.getElementById("langIcon").classList.toggle("fa-translate", currentLang === "si");
        };

        // Add event listener for language toggle button
        document.getElementById("langToggle").addEventListener("click", toggleLanguage);

        // Initial call to update text when the page loads
        updateTexts();
    </script>
</body>

</html>
