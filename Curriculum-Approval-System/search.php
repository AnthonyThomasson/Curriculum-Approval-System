<?php 
require_once("resources/config.php");
require_once(TEMPLATES_PATH."header.php");
require_once(TEMPLATES_PATH."navbar.php");
require_once(TEMPLATES_PATH."jumbotron.php");
require_once(CLASS_PATH."searchHandlerObj.php");
require_once(CLASS_PATH."userObj.php");

// load the current user
$currentuser = new User($con);
$validUser = $currentuser->loadCurrentUser();
if(!$validUser)
	header("location: login.php");
else if(isset($_GET['logout']))
	$currentuser->logout();

// create search handler
$searchHandler = new SearchHandler();



echo createHeader(WEBPAGE_TITLE); ?>
	<body class="main-body">
	<?php
		echo createNavbar($currentuser);

		if(isset($_GET['view']))
		{
			if($_GET['view'] == 'all')
				echo $searchHandler->listAllRequests();

			else if($_GET['view'] == 'userRequests')
				echo $searchHandler->listUsersRequests($currentuser);

			else if($_GET['view'] == 'pendingApproval')
				echo $searchHandler->listPendingApproval($currentuser);

			else if($_GET['view'] == 'approved')
				echo $searchHandler->listAllApproved();

			else if($_GET['view'] == 'notApproved')
				echo $searchHandler->listAllNotApproved();
		}
		else if(isset($_GET['searchParam']))
		{
			echo $searchHandler->searchByParam($_GET['searchParam']);
		}


echo '<script src="'.JS_PATH.'sortScript.js"></script>'
?>
	</body>
</html>