<?php

define('USERS_FILE', __DIR__ . '/data/users.json');

function readUsers() {
    if (!file_exists(USERS_FILE)) {
        return [];
    }
    
    $content = file_get_contents(USERS_FILE);
    if ($content === false) {
        return [];
    }
    
    $users = json_decode($content, true);
    return $users ? $users : [];
}

function writeUsers($users) {
    $jsonData = json_encode($users, JSON_PRETTY_PRINT);
    return file_put_contents(USERS_FILE, $jsonData) !== false;
}

function registerUser($name, $email, $password) {
    $users = readUsers();
    
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return ['success' => false, 'message' => 'Email already exists'];
        }
    }
    
    $newUser = [
        'id' => uniqid(),
        'name' => $name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    $users[] = $newUser;
    
    if (writeUsers($users)) {
        return ['success' => true, 'message' => 'User registered successfully'];
    } else {
        return ['success' => false, 'message' => 'Failed to save user data'];
    }
}

function authenticateUser($email, $password) {
    $users = readUsers();
    
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            if (password_verify($password, $user['password'])) {
                return [
                    'success' => true, 
                    'user' => [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email']
                    ]
                ];
            } else {
                return ['success' => false, 'message' => 'Invalid password'];
            }
        }
    }
    
    return ['success' => false, 'message' => 'User not found'];
}

function getUserByEmail($email) {
    $users = readUsers();
    
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return $user;
        }
    }
    
    return null;
}
?>
