<!DOCTYPE html>
<html lang="en">
    <head>
    <link rel="icon" type="image/png" href="com.png">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Modern Login</title>

        <!-- Bootstrap -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet">

        <!-- Icons -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
            rel="stylesheet">

        <!-- Google Font -->
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap"
            rel="stylesheet">

        <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #a9b3cc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1000px;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,0.25);
            animation: fadeIn 1s ease;
        }

        .login-left {
            padding: 60px 50px;
        }

        .login-right {
            background: linear-gradient(135deg, #2d5bff, #5b8cff);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .login-right::before {
            content: "";
            position: absolute;
            width: 80%;
            height: 80%;
            background: radial-gradient(circle, rgba(255,255,255,0.2), transparent);
            border-radius: 50%;
        }

        .login-title {
            font-weight: 600;
            margin-bottom: 30px;
            color:rgb(250, 112, 0);
            
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 15px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            background-color: rgb(43, 40, 59);
            color: #fff;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #f36f04;
            background-color: rgb(27, 24, 43);
            color: #f36f04;

        }

        .btn-login {
            background: linear-gradient(135deg, #fc6603, #162341);
            border: none;
            border-radius: 30px;
            padding: 10px 25px;
            color: white;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

      

        .social-icons i {
            font-size: 20px;
            width: 45px;
            height: 45px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #f1f3f6;
            margin: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        .social-icons i:hover {
            transform: scale(1.1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-right {
                display: none;
            }
            .login-left {
                padding: 40px 25px;
            }
            body {
            min-height: 100vh;
            background: rgb(250, 112, 0);
            display: flex;
            align-items: end;
            justify-content: end;
             }

             .login-wrapper {
            width: 100%;
            height: 80vh;
            background: #1c1a3b;
            border-radius: 20px 20px 0 0;

            
            }
            .login-title {
            
            margin-bottom: 50px;
            margin-top: 50px;
            
            
        }
        }
        @media (max-width: 768px) {
    .login-right {
        min-height: 220px;
        border-radius: 0 0 20px 20px;
    }
}
.logo-container {
    position: absolute;
    
    left: 40px;
}

/* Mobile view */
@media (max-width: 768px) {
    .logo-container {
        position: absolute;
        top: 0px;
        left: 50%;
        transform: translateX(-50%);
    }
}

/* Red circle */
.logo-img {
    width: 100%;
 
    

   
 
    animation: floatUpDown 3s ease-in-out infinite;
}
@keyframes floatUpDown {
    0% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-12px);
    }
    100% {
        transform: translateY(0px);
    }
}



    </style>
    </head>
    <body>
        <div class="logo-container">
            <img src="INSURANCE.png" alt="Logo" class="logo-img">
        </div>

        <div class="login-wrapper">
            <div class="row g-0">

                <!-- Right side (illustration) -->

                <div class="col-md-6 login-right order-1 order-md-2">
                    <div class="text-white text-center">
                        <h4>Welcome Back</h4>
                        <p class="opacity-75">Secure and modern login
                            experience</p>
                    </div>
                </div>

                <!-- Left side (form) -->
                <div class="col-md-6 login-left order-2 order-md-1">
                    <div class="login-title">
                        <h1 class>Welcome Back </h1>
                        <h3 class="text-light">to Sanasa Easy</h3>
                        
                    </div>

                    <form id="loginForm">
                        <label class="text-light mb-1"
                            for="username">Username</label>
                        <input type="text" class="form-control form-control-sm"
                            placeholder="Username" required>

                        <label class="text-light mb-1"
                            for="password">Password</label>
                        <input type="password"
                            class="form-control form-control-sm"
                            placeholder="Password" required>

                        <button class="btn btn-sm btn-login mt-2">Login</button>
                        <h6 class="pt-4 text-secondary">version 3.0.0</h6>
                         
                        <small class="text-secondary">Developed by @Diluna Sithija [SPO Madampe]</small>

                    </form>

                    
                </div>

            </div>
        </div>

        <script>
document.getElementById("loginForm").addEventListener("submit", function(e){
    e.preventDefault();
    alert("Login submitted");
});
</script>

    </body>
</html>

