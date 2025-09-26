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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #000000 0%, #640908 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333333;
            padding: 20px;
        }

        .container {
            display: flex;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            overflow: hidden;
            width: 100%;
            max-width: 800px;
            min-height: 500px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
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
            background: linear-gradient(135deg, #640908 0%, #8b0a0b 50%, #b8860b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            position: relative;
            overflow: hidden;
        }

        h1 {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-input {
            width: 100%;
            padding: 16px;
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            color: #333;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-input::placeholder {
            color: #999;
        }

        .form-input:focus {
            outline: none;
            border-color: #640908;
            box-shadow: 0 0 0 3px rgba(100, 9, 8, 0.1);
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
            color: #999;
            cursor: pointer;
        }

        .submit-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #640908 0%, #8b0a0b 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #7a0b0a 0%, #a00c0d 100%);
            transform: translateY(-1px);
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
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #dc3545;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }

        .success-message {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: #28a745;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
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
            <p class="subtitle">Welcome back! Please sign in to your account</p>

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
                Don't have an account? <a href="register.php">Sign up</a>
            </div>
        </div>

        <div class="illustration-section">
            <img src="assets/illustration_1.png" alt="Registration Illustration" style="width: 100%; height: 100%; object-fit: fill; position: absolute; top: 0; left: 0;">
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.querySelector('.password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleBtn.textContent = '👁';
            }
        }
    </script>
</body>
</html>