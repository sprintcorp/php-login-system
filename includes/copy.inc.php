<?php
/* User got here from sign up button */
if (isset($_POST['signup-submit'])) {

    /* Access the database files */
    require 'dbh.inc.php';

    /* Declare variables (Take the data from the page and put into variables) */
    $username = $_POST['uid'];
    $email = $_POST['mail'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd-repeat'];

    /* =================== CHECK THE FIELDS FOR ERRORS =================== */

    /* Field(s) is empty (error: emptyfields) */
    if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
        header("Location: ../signup.php?error=emptyfields&uid=" . $username . "&mail=" . $email);
        exit();
    }

    /* Email is not valid + username has weird characters (error: invalidmailandorusername) */ else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../signup.php?error=invalidmailandoruid");
        exit();
    }

    /* Email is not valid (error: invalidmail) */ else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup.php?error=invalidmail&uid=" . $username);
        exit();
    }

    /* username has weird characters (error: invaliduid) */ else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../signup.php?error=invaliduid&mail=" . $email);
        exit();
    }

    /* Password does not match (error: passwordcheck) */ else if ($password !== $passwordRepeat) {
        header("Location: ../signup.php?error=passwordcheck&uid=" . $username . "&mail=" . $email);
        exit();
    }

    /* =================== NO DATA ENTRY ERRORS (Storing Proccess) =================== */ else {
        $sql = "SELECT uidUsers FROM users WHERE uidUsers=?";
        $stmt = mysqli_stmt_init($conn); //initialize the connection

        /* Check if the statement(s) ^^ failed (error: sqlerror) */
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../signup.php?error=sqlerror");
            exit();
        }

        /* Statements didnt fail */ else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);

            //$sql = mysqli_query($conn,"SELECT email FROM users WHERE email = '{$mail}'");

            /* If the the result is taken */
            if ($resultCheck > 0) {
                header("Location: ../signup.php?error=usertaken&mail=" . $email);
                exit();
            }

            /* Insert the data into the database */ else {
                $sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);

                /* SQL fail Check */
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../signup.php?error=sqlerror");
                    exit();
                }

                /* Hash the password + Insert the data into the database + Return Success Report */ else {
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
                    mysqli_stmt_execute($stmt);

                    header("Location: ../signup.php?signup=success");
                    exit();
                }
            }
        }
    }

    /* Close all the statements */
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

/* User did NOT get here from sign up button */ else {
    header("Location: ../signup.php?");
    exit();
}
