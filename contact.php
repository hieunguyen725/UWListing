<?php
require_once("requires/functions.php");
require_once("requires/datasource.php");

if (!isLoggedIn()) {
    include("headers/publicheader.php");
} else {
    include("headers/adminheader.php");
}

// if was submitted from the contact seller, review, or email submit button
// get the seller information to display
if (isset($_POST["contactseller"]) || isset($_POST["reviewsubmit"])
        || isset($_POST["mailsubmit"])) {
    $sellerName = $_POST["name"];
    $seller = $_POST["seller"];
    $itemID = $_POST["item"];
    $result = DataSource::getUser("username = '{$seller}'");
    $row = $result->fetch_assoc();
    $email = $row["emailAddress"];
    $phone = $row["phoneNumber"];
    // if was submitted from the review submit button, create the new
    // review for the seller
    if (isset($_POST["reviewsubmit"])) {
        $newReview = escapeValue(trim($_POST["review"]));
        $seller = $_POST["seller"];
        if (!empty($newReview)) {
            DataSource::createUserReview($seller, $newReview);
        }
    // else if was submitted from the email message button, create
    // the message and send it to the seller
    } else if (isset($_POST["mailsubmit"])) {
        $result = DataSource::getItem($itemID);
        $row = $result->fetch_assoc();
        $itemName = $row["itemName"];
        $itemDescription = $row["itemDescription"];
        
        $to = $email;
        
        $subject = "UWT Listing New Message";
        
        $fromName = $_POST["fromname"];
        $fromEmail = $_POST["fromemail"];
        $from = $fromName . "<{$fromEmail}>";
        
        // send email message in html format
        $message = "<html><body>";
        $message .= "<p>Hello {$sellerName}, you have a new message:</p>";
        $message .= "<br/>";
        $message .= "<table cellpadding='10' style='border:1px solid black'>";
        $message .= "<tr style='border:1px solid black'>";
        $message .= "<th style='background:#673AB7; color:white'>Item Name</th>"
                . "<th style='background:#673AB7; color:white'>Item Description</th>"
                . "<th style='background:#673AB7; color:white'>Sender</th>"
                . "<th style='background:#673AB7; color:white'>Sender Email</th>";
        $message .= "</tr>";
        $message .= "<tr style='border:1px solid black'>";
        $message .= "<td>{$itemName}</td><td>{$itemDescription}</td>"
                . "<td>{$fromName}</td><td>{$fromEmail}</td>";
        $message .= "</tr>";
        $message .= "</table>";
        $message .= "<br/>";
        $message .= "<p><b>Message:</b></p>";
        $message .= "<p>{$_POST["emailmessage"]}</p>";
        $message .= "</body></html>";
        
        $headers = "From: {$from}\n";
        $headers .= "Reply-To: {$from}\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\n";
        $headers .= "MINE-Version: 1.0\n";
        $headers .= "Content-Type: text/html; charset=iso-8859-1";
        
        mail($to, $subject, $message, $headers);
    }
    // get the review results for this seller to display
    $reviewResult = DataSource::getUserReviews($seller);
    $reviews = array();
    if ($reviewResult) {
        while ($review = $reviewResult->fetch_assoc()) {
            $reviews[] = $review["reviewDescription"];
        }
    }
} else {
    redirectTo("items.php");
}
closeConnection();
?>

<main>
    <div id="contactinfo">
        <div class="container">
            <div class="row">
                <div class="col s12 m5">
                    <div class="card white hoverable">
                        <div class="card-content text-darken-4 grey-text">
                            <span class="card-title text-darken-4 grey-text">
                                Seller - <?php echo htmlentities($sellerName) ?>
                            </span>
                            <br/><br/>
                            <p><i class="small material-icons left">email</i>
                                <?php echo htmlentities($email) ?> </p><br/>
                            <p><i class="small material-icons left">phone</i>
                                <?php echo htmlentities($phone) ?> </p>
                        </div>
                    </div>
                </div>
                <form class="col s12 m5 push-m2" action="contact.php" method="post">
                    <div class="row">
                        <div class="input-field col s12">
                            <input  id="fromname" type="text" name="fromname" 
                                    class="validate white-text" required="" aria-required="true">
                            <label for="fromname" class="white-text">Full Name</label>
                        </div>                       
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input  id="fromemail" type="email" name="fromemail" 
                                    class="validate white-text" required="" aria-required="true">
                            <label for="fromemail" class="white-text">Your Email</label>
                        </div>    
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="emailmessage" type="text" 
                                      class="materialize-textarea validate white-text" 
                                      name="emailmessage" required="" 
                                      aria-required="true"></textarea>
                            <label for="emailmessage" class="white-text">Message</label>
                        </div>
                    </div>
                    <input type="hidden" name="name" value="<?php echo $sellerName ?>"/>
                    <input type="hidden" name="seller" value="<?php echo $seller ?>"/>
                    <input type="hidden" name="item" value="<?php echo $itemID ?>"/>
                    <div class="row">
                        <div class="input-field col s12">
                            <button id="mailsubmit" type="submit" name="mailsubmit" 
                                    class="waves-effect waves-light btn  indigo accent-1">
                                Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <hr/>
    <div id="reviewinfo">
        <div class="container">
            <div class="row">
                <div class="col s12 m5">
                    <h5 class="white-text">Seller Review</h5>
                    <?php
                    // if there are reviews, display them as a list collection
                    if (!empty($reviews)) {
                        echo "<br />";
                        echo "<ul class='collection with-header white-text  blue-grey darken-2'>";
                        foreach ($reviews as $reviewDescription) {
                            echo "<li class='collection-item  blue-grey darken-2'>";
                            echo "<p>{$reviewDescription}</p><br/>";
                            echo "</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p class='white-text'>Seller has no review.</p>";
                    }
                    ?>
                </div>
                <form class="col s12 m5 push-m2" action="contact.php" method="post">
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="review" type="text" name="review" 
                                      class="materialize-textarea validate white-text" 
                                      required="" aria-required="true"></textarea>
                            <label for="review" class="white-text">New Review</label>
                        </div>                       
                    </div>
                    <input type="hidden" name="name" value="<?php echo $sellerName ?>"/>
                    <input type="hidden" name="seller" value="<?php echo $seller ?>"/>
                    <input type="hidden" name="item" value="<?php echo $itemID ?>"/>
                    <div class="row">
                        <div class="input-field col s12">
                            <button id="reviewsubmit" type="submit" name="reviewsubmit" 
                                    class="waves-effect waves-light btn  indigo accent-1"
                                    style="background: #f2b632;">
                                Submit Review</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
</body>
</html>

