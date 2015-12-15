<?php
require_once("requires/functions.php");
require_once("requires/datasource.php");

if (!isLoggedIn()) {
include("headers/publicheader.php");
} else {
    redirectTo("myitems.php");
}

?>

<main>
<div id="loginform">
    <div class="container">
        <div class="row">
            <form class="col s12 col m6 push-m3" action="login.php" method="post">
                <div class="card white hoverable">
                    <div class="card-content text-darken-4 grey-text">
                        <span class="card-title text-darken-4 grey-text">Log In</span>
                        <br/><br/>
                        <div class="row">
                            <div class="input-field col s12">
                                <input  id="username" type="text" name="username" 
                                        class="validate" required="" aria-required="true">
                                <label for="username">Username</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="password" type="password" name="password" 
                                       class="validate" required="" aria-required="true">
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <button id="loginsubmit" type="submit" name="loginsubmit" 
                                        class="waves-effect waves-light btn  indigo accent-1">
                                    Log In</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                // if was submitted from the log in button, hash the password as md5
                // 128 bit format, then compare the username and password in the database
                // if match, log the user in, else display the error
                if (isset($_POST["loginsubmit"])) {
                    $username = escapeValue(trim($_POST["username"]));
                    $password = md5(trim($_POST["password"]));
                    $selection = "username = '{$username}' ";
                    $selection .= "AND password = '{$password}';";
                    $result = DataSource::getUser($selection);
                    $row = $result->fetch_assoc();
                    if ($row != NULL) {
                        // user found, log in successfully
                        $_SESSION["currentUser"] = $row["username"];
                        $_SESSION["currentName"] = $row["firstName"] + $row["lastName"];                   
                        redirectTo("myitems.php");
                    } else {
                        echo "<h3>Error: incorrect username/password</h3>";
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