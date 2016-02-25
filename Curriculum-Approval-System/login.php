<?php
require_once("resources/config.php");
require_once(TEMPLATES_PATH."header.php");
require_once(CLASS_PATH."loginObj.php");
require_once(CLASS_PATH."userObj.php");



//	PROCESS LOGIN
$login = new Login();
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	// get user inputed values
	$username = $_POST['username'];
	$password = $_POST['password'];
	if(isset($_POST['remember']))
		$remember = $_POST['remember'];
	else
		$remember = "no-remember";

	// load user information into session/cookie if credentials are correct 
	$valid = $login->processUserCredentials($username, $password, $remember);

	// if user is valid redirect to homepage
	if($valid)
		header("location: index.php");	
}


echo createHeader(WEBPAGE_TITLE); ?>
<body class="login-body">
	<?php echo $login->printLoginDisplay(); ?>
</body>
</html>
