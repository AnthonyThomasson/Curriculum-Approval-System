<?php 
require_once("resources/config.php");
require_once(TEMPLATES_PATH."header.php");
require_once(TEMPLATES_PATH."navbar.php");
require_once(TEMPLATES_PATH."jumbotron.php");
require_once(CLASS_PATH."createProgramObj.php");
require_once(CLASS_PATH."userObj.php");

// load the current user
$currentuser = new User($con);
$validUser = $currentuser->loadCurrentUser();
if(!$validUser)
	header("location: login.php");
else if(isset($_GET['logout']))
	$currentuser->logout();
	

// load selected request
if(isset($_GET['request']) && isset($_GET['type']) && !isset($_GET['submission']))
{
	// print a create-program request
	if($_GET['type'] = "create-program")
	{
		// load data
		$requestId = $_GET['request'];
		$createProgramRequest = new CreateProgramRequest();
		$createProgramRequest->loadRequestFromId($requestId);


		$page = createHeader(WEBPAGE_TITLE);
		$page .= '<body class="main-body">';
		$page .= createNavbar($currentuser);
		$page .= $createProgramRequest->printRequestContent($currentuser);
		$page .= '</body></html>';

		echo $page;
	}
}

// handle approval submissions
if(isset($_GET['submission']))
{
	if($_GET['type'] = "create-program")
	{
		$requestId = $_GET['request'];
		$submission = $_GET['submission'];
		$userId = $currentuser->getUserId();

		$createProgramRequest = new CreateProgramRequest();
		$createProgramRequest->loadRequestFromId($requestId);

		
		$createProgramRequest->submitApprovalSettings($currentuser, $submission);

		// Print page
		$page = createHeader(WEBPAGE_TITLE);
		$page .= '<body class="main-body">';
		$page .= createNavbar($currentuser);

		if($submission == "Approved")
		{
			$title = "Request Approved";
			$message = 'You can check the progress of the request on this <a href="singleRequest.php?request='.$createProgramRequest->getRequestId().'&type='.$createProgramRequest->getType().'"> page </a>';
			$page .= createInformativeJumbotron($title, $message);
		}
		else if("$submission")
		{
			$title = "Request Rejected";
			$message = 'You can check the progress of the request on this <a href="singleRequest.php?request='.$createProgramRequest->getRequestId().'&type='.$createProgramRequest->getType().'"> page </a>';
			$page .= createInformativeJumbotron($title, $message);
		}

		$page .= '</body></html>';
		echo $page;
	}
	

}

