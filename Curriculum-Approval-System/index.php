<?php 
require_once("resources/config.php");
require_once(TEMPLATES_PATH."header.php");
require_once(TEMPLATES_PATH."navbar.php");
require_once(TEMPLATES_PATH."jumbotron.php");
require_once(TEMPLATES_PATH."userRequests.php");
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

		$message = "This application is currently a work in progress and does not fully 
					represent the final product. Many features that will be available in 
					the final project are currently not available.";
		echo createNavJumbotron(WEBPAGE_TITLE, $message);
		//echo listUsersRequests($currentuser, $con);
		echo $currentuser->listPendingApprovalRequests();
		echo $currentuser->listUsersRequestsBox();
		
		//echo listMinUsersRequests($currentuser, $con);



echo '<script src="'.JS_PATH.'sortScript.js"></script>'
	?>
	</body>
</html>
