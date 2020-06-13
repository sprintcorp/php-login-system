<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
        <header>
            <nav>
                <div class="parent">
                    <a href="">
                        <img src="assets/images/Caghhhjjpture.PNG" alt="" class="logo">
                    </a>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Portfolio</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="parent2">
                    <form action="includes/login.inc.php" method="post">
                        <input type="text" name="mailUid" placeholder="Username/Email">
                        <input type="password" name="Pswd" placeholder="* * * * * * * *">
                        <button type="submit" name="loginsubmitBtn">Login</button>
                    </form>
                     <a href="signup.php" class="Signuplink">Sign Up</a>
                     <form action="includes/logout.inc.php" method="post">
                        <button type="submit" name="logoutsubmitBtn">Log out</button>
                    </form>
                </div>
            </nav>
        </header>
