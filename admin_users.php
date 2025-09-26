<?php
session_start();
require_once 'auth_functions.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['user_email'] !== 'admin@example.com') {
    header('Location: login.php');
    exit;
}

$users = readUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #000000 0%, #640908 100%);
            color: white;
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 10px;
            text-align: left;
        }
        th {
            background: rgba(100, 9, 8, 0.7);
        }
        .nav {
            margin-bottom: 20px;
        }
        .nav a {
            color: #ffdd00;
            text-decoration: none;
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="vantavoyage.php">← Back to Dashboard</a>
            <a href="logout.php">Logout</a>
        </div>
        
        <h1>Registered Users</h1>
        <p>Total Users: <?php echo count($users); ?></p>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
