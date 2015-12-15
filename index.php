<?php
require_once("requires/functions.php");

if (isLoggedIn()) {
    redirectTo("myitems.php");
}
?>
<!doctype html>

<html lang="en">
    <head>
        <title>UW Listing</title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="shortcut icon" href="webicon.png">
        <link href="stylesheet/main.css" media="all" rel="stylesheet" type="text/css" />
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css" />

        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
        <script type="text/javascript" src="javascript/script.js"></script>

    </head>
    <body id="homepagebody">
        <div class="navbar-fixed ">
            <nav id="mynav" class="white ">
                <div class="container">
                    <div class="nav-wrapper ">
                        <a href="index.php" class="brand-logo" style="color: #8c9eff;">CSS445</a>

                        <ul class="right hide-on-med-and-down">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="items.php">Listing</a></li>
                            <li><a href="register.php">Register</a></li>
                            <li><a href="login.php">Login</a></li>
                        </ul>

                        <a href="#" data-activates="side-menu" class="button-collapse">
                            <i class="material-icons">menu</i></a>
                        <ul class="side-nav" id="side-menu">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="items.php">Listing</a></li>
                            <li><a href="register.php">Register</a></li>
                            <li><a href="login.php">Login</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <main>
            <div id="banner" class="white-text z-depth-1 blue-grey darken-2">
                UWT Listing
                <br/>
                <a href="register.php" class="waves-effect waves-light btn z-depth-3  indigo accent-1">
                    <div class="valign-wrapper">
                        <h5 class="valign">Get Started</h5>
                    </div>
                </a>
            </div>
            <div id="navcard" class="section">
                <div class="container">
                    <div class="row">
                        <a href="items.php">
                            <div class="col l4 s12">
                                <div class="card white hoverable">
                                    <div class="card-content text-darken-4 grey-text">
                                        <div id="navcard-icon"><i class="medium material-icons">
                                                shopping_cart</i></div>
                                        <span class="card-title text-darken-4 grey-text">
                                            Listing</span>
                                        <p>View the current available items</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="register.php">
                            <div class="col l4 s12">

                                <div class="card white hoverable">
                                    <div class="card-content text-darken-4 grey-text">
                                        <div id="navcard-icon"><i class="medium material-icons">
                                                supervisor_account</i></div>
                                        <span class="card-title text-darken-4 grey-text">
                                            Register</span>
                                        <p>Connect with a new account</p>
                                    </div>
                                </div>        
                            </div>  
                        </a>
                        <a href="login.php">
                            <div class="col l4 s12">
                                <div class="card white hoverable">
                                    <div class="card-content text-darken-4 grey-text">
                                        <div id="navcard-icon"><i class="medium material-icons">
                                                perm_identity</i></div>
                                        <span class="card-title text-darken-4 grey-text">
                                            Login</span>
                                        <p>Manage your items and profile</p>
                                    </div>
                                </div>  
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>