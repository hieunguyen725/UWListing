<?php
require_once("requires/functions.php");
require_once("requires/datasource.php");

if (!isLoggedIn()) {
    include("headers/publicheader.php");
} else {
    include("headers/adminheader.php");
}
?>

<main>
    <div class="container">
        <div id="itemtable">
            <?php
            // create a table of items from all seller and display it to all
            // users of the system
            echo "<table class='bordered highlight responsive-table'>";
            echo "<tr class='grey lighten-3'>";
            echo "<th></th><th>Name</th><th>Price</th><th>Description</th>"
            . "<th>Seller</th><th></th>";
            echo "</tr>";
            $result = DataSource::getAllItems();
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $itemID = $row["itemID"];
                    $seller = $row["username"];
                    $itemName = $row["itemName"];
                    $price = $row["itemPrice"];
                    $description = $row["itemDescription"];
                    $image = $row["itemImage"];
                    $sellerName = $row["firstName"] . " " . $row["lastName"];
                    echo "<tr>";
                    // display the image if it is not null
                    if ($image != NULL) {
                        echo "<td>";
                        echo "<img class='materialboxed' height='100' width='100' "
                        . "src='data:image;base64," . $image . "'/>";
                        echo "</td>";
                    } else {
                        echo "<td></td>";
                    }
                    echo "<td>{$itemName}</td><td>{$price}</td>"
                    . "<td>{$description}</td><td>{$sellerName}</td>";
                    // create contact seller button for the table item
                    echo "<td>";
                    echo "<form action='contact.php' method='post'>";
                    echo "<input type='hidden' name='name' value='{$sellerName}'>";
                    echo "<input type='hidden' name='seller' value='{$seller}'>";
                    echo "<input type='hidden' name='item' value='{$itemID}'>";
                    echo "<button class='waves-effect waves-light btn black-text white'"
                    . "type='submit' name='contactseller' "
                    . "value='Contact Seller'>Contact Seller</button></form>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
            echo "</table>";
            closeConnection();
            ?>
        </div>
    </div>
</main>
</body>
</html>