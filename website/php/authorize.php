<?php
    include_once('config.php');
    session_start();
    session_destroy();
    session_start();

    include_once('connectDB.php');

    if (isset($_POST['signUp']) && $_POST['signUp'] == "true") {
        try {
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->beginTransaction();

            $stmt = $dbh->prepare("INSERT INTO `user` (`email`, `name`, `id`) VALUES (:email, :userName, :userID)");
            $stmt->bindParam(":email", $_POST['email']);
            $stmt->bindParam(":userName", $_POST['userName']);
            $stmt->bindParam(":userID", $_POST['userID']);
            $stmt->execute();
            $dbh->commit();

            header('location: ' . '../login.html');
        } catch(Exception $DBerror) {

        }
    } else {
        try {
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->beginTransaction();

            $stmt = $dbh->prepare("SELECT * FROM `user` WHERE `email` = :email");
            $stmt->bindParam(":email", $_POST['email']);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($rows) {
                $_SESSION['userName'] = $rows['name'];
                $_SESSION['userID'] = $rows['id'];
                header('location: ' . '../index.php');
            } else {
                header('location: ' . '../login.html?err=邮件地址错误');
            }
            
            $dbh->commit();
        } catch(Exception $DBerror) {

        }
    }
    
?>