<?php
session_start();
if($_SESSION) header('Location: home.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>askIt</title>
    <link rel="stylesheet" href="styles/login.css">
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
</head>
<body>
    <div id="form-container">
        <form id="loginForm" method="POST" onsubmit="logIn(); return false">
            <span>Login</span>
            <div id="email-container">
                <div>
                    <label>email</label>
                </div>
                <input name="email" type="text">
            </div>
            <div id="password-container">
                <div>
                    <label for="">password</label>
                </div>
                <input name="password" type="password">
            </div>
            <div id="btn-container">
                <button id="loginBtn" type="submit">log in</button>
            </div>
        </form>
        <div id="redirect">
            <a href="signup.php">Don't have an account? Sign up here</a>
        </div>
    </div>
    
    <script src="scripts/login.js"></script>
</body>
</html>