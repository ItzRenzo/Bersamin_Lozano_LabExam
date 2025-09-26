<?php
session_start();
require_once 'auth_functions.php';


if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: vantavoyage.php');
    exit;
}

$success_message = '';
if (isset($_SESSION['registration_success'])) {
    $success_message = $_SESSION['registration_success'];
    unset($_SESSION['registration_success']);
}

if ($_POST) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password';
    } else {
        $result = authenticateUser($email, $password);
        
        if ($result['success']) {
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $result['user']['id'];
            $_SESSION['user_name'] = $result['user']['name'];
            $_SESSION['user_email'] = $result['user']['email'];
            header('Location: vantavoyage.php');
            exit;
        } else {
            $error = $result['message'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif; /* for normal text */
            background: linear-gradient(135deg, #f2e3c6 0%, #b8906c 40%, #640908 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e0e0e0;
            padding: 20px;
        }   

        .container {
            display: flex;
            background: #f8f4f0;
            border-radius: 20px;
            overflow: hidden;
            width: 100%;
            max-width: 800px;
            min-height: 500px;
            box-shadow: 0 0 6px rgba(100,9,8,0.3);
        }

        .form-section {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .illustration-section {
            flex: 1;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Overlay */
        .illustration-section::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(to right, rgba(0,0,0,0.6), rgba(0,0,0,0.2));
            z-index: 1;
        }


        /* Image styling */
        .illustration-section img {
            width: 100%;
            height: 100%;
            object-fit: fill;   /* better than fill, prevents distortion */
            position: absolute;
            top: 0; left: 0;
            z-index: 0;
        }


        h1 {
            font-family: 'Cinzel', serif; /* decorative serif, dramatic */
            font-size: 28px;
            letter-spacing: 1px;
            color: #1a1a1a;
            text-transform: uppercase;
        }

        .subtitle {
            color: #5a4036;
            font-size: 15px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-input {
            width: 100%;
            padding: 16px;
            background: #f8f9fa;
            border: 1px solid #bbb;
            border-radius: 8px;
            color: #333;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: 'Montserrat', sans-serif;
        }

        .form-input::placeholder {
            color: #aaa;
        }

        .form-input:focus {
            outline: none;
            border-color: #640908;
            box-shadow: 0 0 6px rgba(100, 9, 8, 0.1);
        }

        .password-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 18px;
            color: #666;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .password-toggle:hover {
            color: #640908;
        }

        /* Submit button */
        .submit-btn {
            width: 100%;
            padding: 16px;
            background: #4b0c0c;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.5px; /* subtle poster-like spacing */
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Montserrat', sans-serif;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #781010 0%, #a11c19 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .submit-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }


        .divider {
            text-align: center;
            margin: 20px 0;
            color: #999;
            font-size: 14px;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e0e0e0;
        }

        .divider span {
            background: white;
            padding: 0 15px;
        }

        .social-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .social-btn {
            flex: 1;
            padding: 12px;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            border-color: #640908;
        }

        .login-link {
            text-align: center;
            color: #666;
            font-size: 14px;
        }

        .login-link a {
            color: #640908;
            text-decoration: none;
            font-weight: 600;
        }

        .error-message {
            background: rgba(140, 26, 23, 0.1);
            border: 1px solid rgba(140, 26, 23, 0.3);
            color: #8c1a17;
        }

        .success-message {
            background: rgba(60, 120, 60, 0.1);
            border: 1px solid rgba(60, 120, 60, 0.3);
            color: #2e6d2e;
        }


        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                margin: 10px;
            }
            
            .illustration-section {
                min-height: 150px;
            }
            
            .form-section {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-section">
            <h1>Log in</h1>
            <p class="subtitle">Join the march. Be part of the voyage.</p>

            <?php if (!empty($success_message)): ?>
                <div class="success-message">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <input 
                        type="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="Email" 
                        required 
                        value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                    >
                </div>

                <div class="form-group">
                    <div class="password-container">
                        <input 
                            type="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="Password" 
                            required
                            id="password"
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword()">👁</button>
                    </div>
                </div>

                <button type="submit" class="submit-btn">Sign in</button>
            </form>
                <br>
            <div class="login-link">
                First time here? March with us → <a href="register.php">Sign up</a>
            </div>
        </div>

        <div class="illustration-section">
            <img src="assets/illustration_1.png" alt="Registration Illustration">
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.querySelector('.password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.textContent = '🩸';
            } else {
                passwordInput.type = 'password';
                toggleBtn.textContent = '👁';
            }
        }
    </script>
</body>
</html>