<?php 
require_once("resources/config.php");
require_once(TEMPLATES_PATH."header.php");
require_once(TEMPLATES_PATH."navbar.php");
require_once(TEMPLATES_PATH."jumbotron.php");
require_once(TEMPLATES_PATH."menus.php");
require_once(CLASS_PATH."userObj.php");

// load the current user
$currentuser = new User($con);
$validUser = $currentuser->loadCurrentUser();
if(!$validUser)
	header("location: login.php");
else if(isset($_GET['logout']))
	$currentuser->logout();




echo createHeader(WEBPAGE_TITLE); ?>
<body class="main-body">
<?php
	echo createNavbar($currentuser);

// Create new request
if(isset($_GET['makeRequest']))
{
	$title = "Make Request";
	$message = "Choose the type of request you would like to make";

    echo createInformativeJumbotron($title, $message);
	echo createRequestMenu();
}
// Modify a request
else if (isset($_GET['modifyRequest'])) {
	# code...
}

?>