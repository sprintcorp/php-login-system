<?php
// line 5 checks if the user used the ryt url
// if line 5 is true connect user to DB by requiring DBhandler
// line 7- 10 similar to getelementsbyID in JS, [getting all the inputfield]
if(isset($_POST["signupbtn"])){
//  require "dbh.inc.php";
 $username = htmlentities($_POST["Userid"]);
 $email =htmlentities($_POST["mail"]);
 $password =htmlentities($_POST["Pswd"]);
 $r_password =htmlentities($_POST["Repeat-Pswd"]);

 //line 13 if block for form validation
 if(empty($username)||empty($email) || empty($password) || empty($r_password)){
     //if any field is empty line 16 redirects the user 
     //from signup.inc.php back to signup.php & returns username & email if filled alrdy
     header("location:../signup.php?error=emptyfields&Userid=".$username."&email=".$email);
 }

}