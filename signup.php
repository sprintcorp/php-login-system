<?php 
    require "components.php/header.php"
?>
    <main >
       <section class="signupbox">
           <h2>Sign up</h2>
           <form action="includes/signup.inc.php" method="post">
                <input class="uInput" type="text" name="Userid" placeholder="USERNAME"> <br>
                <input type="email" name="mail" placeholder="EMAIL ADDRESS"> <br>
                <input type="password" name="Pswd" placeholder="PASSWORD"><br>
                <input type="password" name="Repeat-Pswd" placeholder="REPEAT-PASSWORD">
                <button type="submit" name="signupbtn">SIGN UP</button>
           </form>
       </section>
    </main>
<?php 
    require "components.php/footer.php"
?>