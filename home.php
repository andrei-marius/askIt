<?php
session_start();
if(!$_SESSION) header('Location: login.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>askIt</title>
    <link rel="stylesheet" href="styles/app.css">
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
</head>
<body>
    <div id="page">

    <?php
        if($_SESSION){
    ?>
        <h1>Welcome, <?= $_SESSION['userName'] .' - '. $_SESSION['userId'] ?></a>
        <button id="logout">log out</button>
    <?php
        }
    ?>

    <div id="form-container">
        <form id="topicForm" method="POST">
            <span>Create Topic</span>
            <div id="title-container">
                <div>
                    <label>title</label>
                </div>
                <input name="topicTitle" type="text">
            </div>
            <div id="description-container">
                <div>
                    <label>description</label>
                </div>
                <input name="topicDescription" type="password">
            </div>
            <div id="topic-btn-container">
                <button id="topicBtn" type="submit">create topic</button>
            </div>
        </form>
    </div>

    <div id="topics">
    
    </div>

    </div>
    <!-- end page -->

    <script src="scripts/app.js"></script>
</body>
</html>