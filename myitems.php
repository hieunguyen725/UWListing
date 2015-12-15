<?php
require_once("requires/functions.php");
require_once("requires/datasource.php");

if (!isLoggedIn()) {
    redirectTo("login.php");
} else {
    include("headers/adminheader.php");
}
?>

<main>
    <div class="container">
        <div class="col s12">
            <div class="row">
                <a class="btn-floating btn-large waves-effect waves-light right
                   modal-trigger indigo accent-1"
                   href="#addmodel"><i class="material-icons">add</i></a>
            </div>
        </div>
        <div id="myitemtable" class="col s12">
            <?php
            // display all the items for the current user as a table
            echo "<table class='bordered highlight responsive-table'>";
            echo "<tr class='grey lighten-3'>";
            echo "<th></th><th>Name</th><th>Price</th><th>Description</th>"
            . "<th></th><th></th>";
            echo "</tr>";
            $result = DataSource::getUserItems($_SESSION["currentUser"]);
            if ($result) {
                $displayEmpty = true;
                while ($row = $result->fetch_assoc()) {
                    $itemID = $row["itemID"];
                    $itemName = escapeValue($row["itemName"]);
                    $price = $row["itemPrice"];
                    $description = escapeValue($row["itemDescription"]);
                    $image = $row["itemImage"];
                    
                    // display the image for the current item if available
                    echo "<tr>";
                    if ($image != NULL) {
                        echo "<td>";
                        echo "<img class='materialboxed' height='100' width='100' "
                        . "src='data:image;base64," . $image . "'/>";
                        echo "</td>";
                    } else {
                        echo "<td></td>";
                    }
                    echo "<td>{$itemName}</td><td>{$price}</td>"
                    . "<td>{$description}</td>";
                    // create update item button for this item
                    echo "<td>";
                    echo "<form action='updateitem.php' method='post'>";
                    echo "<input type='hidden' name='itemID' value='{$itemID}'>";
                    echo "<button class='waves-effect waves-light "
                    . "btn black-text white'"
                    . "type='submit' name='update' "
                    . "value='Contact Seller'>Edit</button></form>";
                    echo "</td>";
                    // create delete item button for this item
                    echo "<td>";
                    echo "<form action='deleteitem.php' method='post'>";
                    echo "<input type='hidden' name='itemID' value='{$itemID}'>";
                    echo "<button class='waves-effect waves-light "
                    . "btn black-text white'"
                    . "type='submit' name='delete' "
                    . "value='Contact Seller'>Delete</button></form>";
                    echo "</td>";
                    echo "</tr>";
                    $displayEmpty = false;
                }
                // display an empty row if there is no item to display
                if ($displayEmpty) {
                    echo "<tr><td></td><td></td><td></td><td></td>"
                    . "<td></td><td></td></tr>";
                }
            }
            echo "</table>";
            ?>
        </div>        
    </div>
    <div id="additem">

       <div id="addmodel" class="modal">
    <div class="modal-content">
        <div class="">
            <div class="row">
                <form class="col s12 m8 push-m2" action="myitems.php" 
                      method="post" enctype="multipart/form-data">
                    <h4>Add Item</h4>
                    <div class="row">
                        <div class="input-field col s12">
                            <input  id="name" type="text" name="name" 
                                    class="validate" required="" aria-required="true">
                            <label for="name">Item Name</label>
                        </div>                       
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input  id="price" type="number" step="any" name="price" 
                                    class="validate" required="" aria-required="true">
                            <label for="price">Price</label>
                        </div>    
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="description" type="text" 
                                      class="materialize-textarea validate" 
                                      name="description" required="" aria-required="true"></textarea>
                            <label for="description">Description</label>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="file-field input-field">
                            <div class="waves-effect waves-light btn indigo accent-1">
                                <i class="material-icons left">perm_media</i>
                                <span>Image</span>
                                <input type="file" name="image">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" name="imagetext" type="text">
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="input-field col s12">
                            <button id="addsubmit" type="submit" name="addsubmit" 
                                    class="waves-effect waves-light btn indigo accent-1">
                                Add Item</button>
                        </div>
                    </div>
                    <?php
                    // if was submitted from the add button, validate the user's
                    // inputs and add the new item for the user to the database
                    if (isset($_POST["addsubmit"])) {
                        $name = escapeValue(trim($_POST["name"]));
                        $price = trim($_POST["price"]);
                        $description = escapeValue(trim($_POST["description"]));                        
                        if (empty($name) || empty($price) || empty($description)) {
                            echo "<h3>Error: Please fill in all inputs</h3>";
                        } else {
                            $image = NULL;
                            $username = $_SESSION["currentUser"];
                            // check if any image is uploaded
                            if (isset($_FILES["image"]["tmp_name"]) && 
                                    !empty($_FILES["image"]["tmp_name"])) {
                                // get the image content and encode it before
                                // adding into the database
                                $image = addslashes($_FILES["image"]["tmp_name"]);
                                $image = base64_encode(file_get_contents($image));
                            }
                            DataSource::createItem($name, $price, $description, 
                                    $image, $username);
                            redirectTo("myitems.php");
                        }
                    }
                    closeConnection();
                    ?>
                </form>
            </div>
        </div>
    </div> </div>
    </div>
</main>
</body>
</html>