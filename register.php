<?php
require_once("requires/functions.php");
require_once("requires/datasource.php");

if (!isLoggedIn()) {
include("headers/publicheader.php");
} else {
    redirectTo("myitems.php");
}

// check to see if the register information input was previously submitted
// if so, display the submitted information, otherwise display blank inputs
$username = isset($_POST["registersubmit"]) ? 
        escapeValue(trim($_POST["username"])) : "";
$firstName = isset($_POST["registersubmit"]) ? 
        escapeValue(trim($_POST["firstname"])) : "";
$lastName = isset($_POST["registersubmit"]) ? 
        escapeValue(trim($_POST["lastname"])) : "";
$email = isset($_POST["registersubmit"]) ? 
        escapeValue(trim($_POST["email"])) : "";
$phone = isset($_POST["registersubmit"]) ? 
        escapeValue(trim($_POST["phone"])) : "";
$password = isset($_POST["registersubmit"]) ? 
        escapeValue(trim($_POST["password"])) : "";
$confirmPassword = isset($_POST["registersubmit"]) ? 
        escapeValue(trim($_POST["confirmpassword"])) : "";
?>

<main>
<div id="registerform">
    <div class="container">
        <div>
            <form class="col s12 col m8 push-m2" action="register.php" method="post">
                <div class="card white hoverable">
                    <div class="card-content text-darken-4 grey-text">
                        <span class="card-title text-darken-4 grey-text">Register</span>
                        <br/><br/>
                        <div class="row">
                            <div class="input-field col s12">
                                <input  id="username" type="text" name="username" 
                                        class="validate" required="" aria-required="true"
                                        value="<?php echo htmlentities($username); ?>">
                                <label for="username">Username</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <input id="firstname" type="text" name="firstname" 
                                       class="validate" required="" aria-required="true"
                                       value="<?php echo htmlentities($firstName); ?>">
                                       <label for="firstname">First Name</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input id="lastname" type="text" name="lastname" 
                                       class="validate" required="" aria-required="true"
                                       value="<?php echo htmlentities($lastName); ?>">
                                <label for="lastname">Last Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <input id="password" type="password" name="password" 
                                       class="validate" required="" aria-required="true"
                                       value="<?php echo htmlentities($password); ?>">
                                <label for="password">Password</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input id="confirmpassword" type="password" name="confirmpassword" 
                                       class="validate" required="" aria-required="true"
                                       value="<?php echo htmlentities($confirmPassword); ?>">
                                <label for="confirmpassword">Confirm Password</label>
                            </div>
                        </div>
                        <div class="row">

                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="phone" type="tel" name="phone" 
                                       class="validate" required="" aria-required="true"
                                       value="<?php echo htmlentities($phone); ?>">
                                <label for="phone">Phone Number</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="email" type="email" name="email" 
                                       class="validate" required="" aria-required="true"
                                       value="<?php echo htmlentities($email); ?>">
                                <label for="email">Email Address</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <button id="registersubmit" type="submit" name="registersubmit" 
                                        class="waves-effect waves-light btn  indigo accent-1">
                                    Register</button>
                            </div>
                        </div>
                    </div>
                </div>
                        
            <?php
            // if was submitted from the register button, validate the register
            // information and add a new user to the database
            if (isset($_POST["registersubmit"])) {
                if (strlen($username) < 5 || strlen($password) < 5) {
                    exit("<h3>Error: Username/password must be at least 5 characters</h3>");
                } else if ($password != $confirmPassword) {
                    exit("<h3>Error: Password do not match</h3>");
                } else {
                    $selection = "username = '{$username}';";
                    $result = DataSource::getUser($selection);
                    $row = $result->fetch_assoc();
                    if ($row != NULL) {
                        exit("<h3>Error: Username already exist</h3>");
                    } else {
                        echo "no error";
                        DataSource::createUser($username, md5($password), 
                                $firstName, $lastName, $email, $phone);
                        redirectTo("login.php");
                    }
                }
            }
            closeConnection();            
            ?>
            </form>
        </div>
    </div>
</div>
</main>
</body>
</html>