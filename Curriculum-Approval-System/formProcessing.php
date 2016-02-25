<?php 
require_once("resources/config.php");
require_once(TEMPLATES_PATH."header.php");
require_once(TEMPLATES_PATH."navbar.php");
require_once(TEMPLATES_PATH."jumbotron.php");
require_once(TEMPLATES_PATH."forms.php");
require_once(CLASS_PATH."createProgramObj.php");
require_once(CLASS_PATH."userObj.php");

// load the current user
$currentuser = new User();
$validUser = $currentuser->loadCurrentUser();
if(!$validUser)
	header("location: login.php");
else if(isset($_GET['logout']))
	$currentuser->logout();





echo createHeader(WEBPAGE_TITLE); ?>
<body class="main-body">
<?php
	echo createNavbar($currentuser);

// Generate add program form 
if (isset($_GET['addProgram'])) {

	// Run when the form is submitted
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		// create tables in database
		$createProgramRequest = new CreateProgramRequest();
		$createProgramRequest->createNewRequestFromPost($currentuser, "in-progress");
		$validInput = $createProgramRequest->createTableEntries();

		// if tables created print notification
		if($validInput)
		{
			$title = "Program request was created!";
			$message = 'You can check the progress of your request on this <a href="singleRequest.php?request='.$createProgramRequest->getRequestId().'&type='.$createProgramRequest->getType().'"> page </a>';

			echo createInformativeJumbotron($title, $message);
		}
	}
	// Run to create form
	if($_SERVER["REQUEST_METHOD"] != "POST" || !$validInput)
	{
		if(!isset($validInput))
			$validInput = TRUE;

		$title = "Add a program";
		$message = "Fill out all information required for a new program request and press submit";

		echo createInformativeJumbotron($title, $message);
		echo createAddProgramForm($validInput);
	}
}
// Generate add course form
else if (isset($_GET['addCourse'])) {

	$title = "Add a course";
	$message = "Fill out all information required for a new course request and press submit";

	echo createInformativeJumbotron($title, $message);

	echo createAddCourseForm();
}
// Generate add program form 
else if (isset($_GET['removeProgram'])) {

	$title = "Remove a program";
	$message = "Fill out all information required for a program removal request and press submit";

	echo createInformativeJumbotron($title, $message);

	//echo createRemoveProgramForm();
}
// Generate add course form
else if (isset($_GET['removeCourse'])) {

	$title = "Remove a course";
	$message = "Fill out all information required for a course removal request and press submit";

	echo createInformativeJumbotron($title, $message);

	//echo createRemoveCourseForm();
}
    echo '<script src="'.JS_PATH.'formScript.js"></script>'
?>
</body>
</html>