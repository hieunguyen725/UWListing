<?php
require_once("requires/functions.php");
require_once("requires/datasource.php");

if (!isLoggedIn()) {
    redirectTo("login.php");
} else {
    include("headers/adminheader.php");
    if (isset($_SESSION["currentUser"])) {
        $username = $_SESSION["currentUser"];
        // if the current session has a logged in user
        // and the update info button was submitted, update
        // their information
        if (isset($_POST["updateinfosubmit"])) {
            $firstName = escapeValue(trim($_POST["firstname"]));
            $lastName = escapeValue(trim($_POST["lastname"]));
            $phoneNumber = escapeValue(trim($_POST["phone"]));
            $emailAddress = escapeValue(trim($_POST["email"]));
            DataSource::updateUser($username, $firstName, $lastName, 
                    $emailAddress, $phoneNumber);
        // else get current information about the username in the
        // database to display
        } else {
            $result = DataSource::getUser("username = '{$username}'");
            $row = $result->fetch_assoc();
            $firstName = $row["firstName"];
            $lastName = $row["lastName"];
            $emailAddress = $row["emailAddress"];
            $phoneNumber = $row["phoneNumber"];
        }
        // get the reviews for the username from the database to
        // display
        $reviewResult = DataSource::getUserReviews($username);
        $reviews = array();
        if ($reviewResult) {
            while ($review = $reviewResult->fetch_assoc()) {
                $reviews[] = $review["reviewDescription"];
            }
        }
    } else {
        redirectTo("myitems.php");
    }
}
?>


<main>
    <div id="myinfoform">
        <div class="container">
            <div>
                <form class="col s12 col m8 push-m2" action="myinfo.php" method="post">
                    <div class="card white hoverable">
                        <div class="card-content text-darken-4 grey-text">
                            <span class="card-title text-darken-4 grey-text">
                                Profile - <?php echo htmlentities($username); ?>
                            </span>
                            <br/><br/>
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

                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="phone" type="tel" name="phone" 
                                           class="validate" required="" aria-required="true"
                                           value="<?php echo htmlentities($phoneNumber); ?>">
                                    <label for="phone">Phone Number</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="email" type="email" name="email" 
                                           class="validate" required="" aria-required="true"
                                           value="<?php echo htmlentities($emailAddress); ?>">
                                    <label for="email">Email Address</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <button id="updateinfosubmit" type="submit" name="updateinfosubmit" 
                                            class="waves-effect waves-light btn indigo accent-1">
                                        Update Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div id="myreview">
        <div class="container">
            <div class="card white hoverable">
                <div class="card-content text-darken-4 grey-text">   
                    <span class="card-title text-darken-4 grey-text">
                        My Reviews
                    </span>
                    <br/><br/>                            
                    <div class="row">
                        <div class="col s12">
                            <?php
                            // display the user's reviews as a list of collection
                            if (!empty($reviews)) {
                                echo "<br />";
                                echo "<ul class='collection'>";
                                foreach ($reviews as $reviewDescription) {
                                    echo "<li class='collection-item'>";
                                    echo "<p>{$reviewDescription}</p><br/>";
                                    echo "</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "You have no review.";
                            }
                            closeConnection();
                            ?>
                        </div>
                    </div> 
                </div> 
            </div>
        </div>
    </div>
</main>
</body>
</html>