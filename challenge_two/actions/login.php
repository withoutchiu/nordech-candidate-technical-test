<?php
/**
 * If given a chance i will use a carbon date since i will be dealing with date, this could give me a
 * better and much easier access with Dates. Since this does not have composer.json i cant
 */

/*
 * Suggestion:
 * 1.) Instead of using repeated if statement we can use switch to identify the error for logging in.
 * 2.) repeated variable can be a functional scoped variables so we dont have to repeatedly declare it.
 * 3.) If given a chance i will convert the whole project into PHP Laravel and avoid having inline php.
 */
session_start();
// connect to database
try {
    $pdo = new PDO("mysql:host=localhost;dbname=nordech_challenge", "root", "", [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                        ]
                    );
} catch(\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
};
function getGivenUser($pdo) {
    // query database
    $query = 'SELECT * FROM Users WHERE email=:email LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_POST['email']]);
    return $stmt->fetch();
}
function updateTable($pdo, $updateTable, $setKey, $setValue, $searchKey, $searchValue) {
    $query = "UPDATE $updateTable SET $setKey=:setValue WHERE $searchKey=:searchValue";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$setValue, $searchValue]);
    return $stmt->rowCount();

}
function doLogin($pdo) {

        $givenUser = getGivenUser($pdo);
        if(!$givenUser) {
            // no user found?
            $_SESSION['login_success'] = false;
            $_SESSION['user_found'] = false;
            return 4;
        }
        if($givenUser['password']!==$_POST['psw']) {
            // do passwords match?
            $_SESSION['login_success'] = false;
            $_SESSION['user_found'] = true;
            return 5;
        }
        if($givenUser['passwordExpire'] < date("Y-m-d H:i:s")) {
            // Has the password expired?
//            Using Laravel i can update the data using below
//            $givenUser->update([
//                    'passwordExpire' => date('Y-m-d', strtotime('+1 year', strtotime(date(Y-m-d))) )
//            ]);
            $newExpirationDate =  date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " + 365 day"));
            $updateSuccess = updateTable($pdo, 'Users', 'passwordExpire', $newExpirationDate, 'ID', $givenUser['ID']);
            if($updateSuccess){
                $_SESSION['login_success'] = true;
                $_SESSION['user_found'] = true;
            }else{
                $_SESSION['login_success'] = false;
                $_SESSION['user_found'] = true;
                return 6;
            }
        }
        if($givenUser['lockedOut']===true) {
            // is user locked out?
            $_SESSION['login_success'] = false;
            $_SESSION['user_found'] = true;
            return 7;
        }
        if($givenUser['lockedoutUntil'] && $givenUser['lockedoutUntil'] > date("Y-m-d H:i:s")) {
            // is a lockout time set and is is in to the future?
            $_SESSION['login_success'] = false;
            $_SESSION['user_found'] = true;
            return 8;
        }
        // all cases success, reset login attempts and remove lockout time.
        updateTable($pdo, "Users", "loginAttempts", 0, "ID", $givenUser['ID']);
        updateTable($pdo, "Users", "lockedOut", 0, "ID", $givenUser['ID']);
        updateTable($pdo, "Users", "lockedoutUntil", NULL, "ID", $givenUser['ID']);
        $_SESSION['login_success'] = true;
        $_SESSION['user_found'] = true;
        return 2;      
}
function doFailedLoginUpdate($pdo) {
    $givenUser = getGivenUser($pdo);
    if($givenUser['loginAttempts'] <= 2) {
        // add failed login attempt
        updateTable($pdo, "Users", "loginAttempts", $givenUser['loginAttempts']+1, "ID", $givenUser['ID']);
    } else {
        // lock out user
        updateTable($pdo, "Users", "lockedOut", 0, "ID", $givenUser['ID']);
        updateTable($pdo, "Users", "lockedoutUntil", date("Y-m-d H:i:s", strtotime("+7 day")), "ID", $givenUser['ID']);
    }
}
$loginCode = doLogin($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
    <?php 
    if($loginCode == 2 && $_SESSION['login_success']) {
        echo '
        <div class="success">
            Login successful!
            <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
        </div>            
        ';
    } else {
        if($_SESSION['user_found']) {
            doFailedLoginUpdate($pdo);
        };
        echo '
        <div class="alert">
            Login failure! Error code: '.$loginCode.'
            <span class="closebtn" onclick="this.parentElement.style.display=\'none\';window.location.assign(\'http://localhost:8000\');">&times;</span>
        </div>
        ';
    }
    ?>
</body>
</html>