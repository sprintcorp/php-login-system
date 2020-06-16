<?php
// line 5 checks if the user used the ryt url
// if line 5 is true connect user to DB by requiring DBhandler
// line 7- 10 similar to getelementsbyID in JS, [getting all the inputfield]
if (isset($_POST["signupbtn"])) {
    require "dbh.inc.php";
    $username = $_POST["Userid"];
    $email = $_POST["mail"];
    $password = $_POST["Pswd"];
    $r_password = $_POST["Repeat-Pswd"];

    //line 13 if block for form validation
    if (empty($username) || empty($email) || empty($password) || empty($r_password)) {
        //if any field is empty line 16 redirects the user 
        //from signup.inc.php back to signup.php & returns username & email if filled alrdy
        header("location:../signup.php?error=emptyfields&Userid=".$username."&email=".$email);
        exit();
    }
    // line 20 validates both email and user name simultaneously
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("location:../signup.php?error=invalidemail&Userid=");
        exit();
    }
    // line 24 validates the email returns username
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("location:../signup.php?error=invalidemail&Userid=".$username);
        exit();
    }
    // line 30 validates the user name with REGEX returns email
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("location:../signup.php?error=invalideUserid&email=".$email);
        exit();
    }
    // validates password match line 35
    else if ($password !== $r_password) {
        header("location:../signup.php?error=yourpassworddoesnotmatch&Userid=".$username."&email=".$email);
        exit();
    }
    // checks the database of the user name has been taken line 41
    // use prepared statements to take in the $username from the form
    else {
        $sql = "SELECT Uidusers FROM users WHERE Uidusers=?";
        $stmt = mysqli_stmt_init($connect);
        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("location:../signup.php?error=sqlerror=");
            exit();
        } else {
            //else bind prepared statement to $username which is a single string
            // then execute the statement
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            //stores the username search result from the DB into $stmt
            // mysqli_store_result($stmt);
            //checks how many results(i.e identical to $username) rows we got frm DB
            $resultCheck = mysqli_stmt_num_rows($stmt);
            // dd($resultCheck);
            if ($resultCheck > 0) {
                header("location:../signup.php?error=usernameisalreadytaken&mail=".$email);
                exit();
            } else {
                // if $resultCheck = 0 then insert the form data into DB using placeholders ???
                $sql = "INSERT INTO users (Uidusers, emailusers, pwduser) VALUES (?, ?, ?)";
                // we have to use prepared statements to assign
                // (Uidusers,emailusers,pwduser) =($username, $email, $password)
                $stmt = mysqli_stmt_init($connect);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("location:../signup.php?error=sqlerror=");
                    exit();
                } else {
                    $hashedPWD = password_hash($password, PASSWORD_DEFAULT); //hashed the password
                    //else bind prepared statement to form vars ($username, $email, $password)
                    //which are 3 single string 'sss" // then execute the statement
                    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPWD);
                    mysqli_stmt_execute($stmt);
                    // onces all the form data have been inserted into DB redirect back
                    // to signup with a success message
                    header("location:../signup.php?signup=success");
                    exit();
                }
            }
        }
        //line 43 to 54 is just to set Uidusers=$username in the DB 
        // using prepared statements for security purpose
    }

    mysqli_stmt_close($stmt);  // to close all the DB statements
    mysqli_close($connect);     // closing the DB connection we earlier established in dbh.inc.php
} 
else {
    // if user got into the this page(signup.inc.php)
    // without clicking the signup button take user back to signup.php  
    header("location:../signup.php?");
    exit();
}
