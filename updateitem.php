<?php
require_once("requires/functions.php");
require_once("requires/datasource.php");

if (!isLoggedIn()) {
    redirectTo("login.php");
} else {
    include("headers/adminheader.php");
    // if was submitted from the update item button
    // get the current item info from the database to display
    if (isset($_POST["update"]) || isset($_POST["updatesubmit"])) {
        $itemID = $_POST["itemID"];
        $result = DataSource::getItem($itemID);
        $row = $result->fetch_assoc();
        $itemName = $row ? $row["itemName"] : "";
        $itemPrice = $row ? $row["itemPrice"] : "";
        $itemDescription = $row ? $row["itemDescription"] : "";
        $itemImage = $row ? $row["itemImage"] : NULL;
    } else {
        redirectTo("myitems.php");
    }
}

?>


<main>
    
<div id="updateitem">
        <div class="container">
            <div class="row">
                <form class="col s12 m8 push-m2" action="updateitem.php" 
                      method="post" enctype="multipart/form-data">
                <div class="card white hoverable">
                    <div class="card-content text-darken-4 grey-text">
                        <span id="updateitemtitle" 
                              class="card-title text-darken-4 grey-text">Update Item</span>
                        <br/><br/>
                    <div class="row">
                        <div class="input-field col s12">
                            <input  id="name" type="text" name="name" 
                                    value="<?php echo htmlentities($itemName); ?>"
                                    class="validate" required="" aria-required="true">
                            <label for="name">Item Name</label>
                        </div>                       
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input  id="price" type="number" step="any" name="price" 
                                    value="<?php echo htmlentities($itemPrice);?>"
                                    class="validate" required="" aria-required="true">
                            <label for="price">Price</label>
                        </div>    
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="description" type="text" 
                                      class="materialize-textarea validate"
                                      name="description" required="" aria-required="true"
                                      ><?php echo htmlentities($itemDescription); ?></textarea>
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
                    <input type="hidden" name="itemID" value="<?php echo $itemID ?>;"/>
                    <div class="row">
                        <div class="input-field col s12">
                            <button id="updatesubmit" type="submit" name="updatesubmit" 
                                    class="waves-effect waves-light btn indigo accent-1">
                                Update Item</button>
                        </div>
                    </div>
                    <?php
                    // if the current item information was submited to be update
                    // validate the input and update the item information
                    // in the database.
                    if (isset($_POST["updatesubmit"])) {
                        $itemName = escapeValue(trim($_POST["name"]));
                        $itemPrice = trim($_POST["price"]);
                        $itemDescription = escapeValue(trim($_POST["description"]));                        
                        if (empty($itemName) || empty($itemPrice) 
                                || empty($itemDescription)) {
                            echo "<h3>Error: Please fill in all inputs</h3>";
                        } else {
                            // check if any image is uploaded                            
                            if (isset($_FILES["image"]["tmp_name"]) && 
                                    !empty($_FILES["image"]["tmp_name"])) {
                                // get the image content and encode it before
                                // adding into the database                               
                                $itemImage = addslashes($_FILES["image"]["tmp_name"]);
                                $itemImage = base64_encode(file_get_contents($itemImage));
                            }
                            DataSource::updateItem($itemID, $itemName, 
                                    $itemPrice, $itemDescription
                                    , $itemImage);
                            redirectTo("myitems.php");
                        }
                    }
                    closeConnection();                    
                    ?>
                    </div> 
                </div>
                </form>
            </div>
        </div>
    </div>    
</main>
</body>
</html>