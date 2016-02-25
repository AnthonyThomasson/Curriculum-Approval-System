<?php
require_once(CLASS_PATH."requestObj.php");


class CreateProgramRequest extends Request
{

    // Specific request data
    private $programName;
    private $term;
    private $rationale;
    private $crossImpact;
    private $studentImpact;
    private $comments;
    private $calendar;
    private $libraryImpact;
    private $itsImpact;

	public function createNewRequestFromPost($user, $state)
	{
		// get user info
		$this->userId = $user->getUserId();

		// get general request data
		$this->creationDate = date('Y-m-d H:i:s');
		$this->state = $state;
		$this->currentApprover = 0;
		$this->type = "create-program";

		// specific request data
		if($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$this->programName = $_POST['programName'];
			$this->term = $_POST['term'];
			$this->rationale = $_POST['rationale'];
			$this->crossImpact = $_POST['crossImpact'];
			$this->studentImpact = $_POST['studentImpact'];
			$this->comments = $_POST['comments'];
			$this->calendar = $_POST['calendar'];
			$this->libraryImpact = $_POST['libraryImpact'];
			$this->itsImpact = $_POST['itsImpact'];
		}
	}

	public function loadRequestFromId($id)
	{
		$con = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Failed to connect to database');

		// sanitize input
		$id = mysqli_real_escape_string($con, $id);
		
		$sql = "SELECT * FROM `users`, `request`, `createProgramRequest` 
							WHERE request.id = '$id' 
								AND request.id = createProgramRequest.id
								AND users.userId = request.userId";

		$result = mysqli_query($con, $sql);


      	$data = $result->fetch_assoc();


      	// get user info
		$this->userId = $data['userId'];
		$this->firstname = $data['firstname'];
		$this->lastname = $data['lastname'];

		// get general request data
		$this->requestId = $data['id'];
		$this->creationDate = $data['creationDate'];
		$this->state = $data['state'];
		$this->currentApprover = $data['currentApprover'];
		$this->type = $data['type'];

		// specific request data
		$this->programName = $data['programName'];
		$this->term = $data['term'];
		$this->rationale = $data['rationale'];
		$this->crossImpact = $data['crossImpact'];
		$this->studentImpact = $data['studentImpact'];
		$this->comments = $data['comments'];
		$this->calendar = $data['calendar'];
		$this->libraryImpact = $data['libraryImpact'];
		$this->itsImpact = $data['itsImpact'];

		mysqli_close($con);
	}

	public function createTableEntries()
	{
		if($this->validateInput())
		{
			// create request table entry
			$this->createRequestEntry();

			// create the createProgramRequest table entry
			$this->createSpecificRequestEntry();

			// create approval table entries
			$this->createApprovalEntries();

			return TRUE;
		}
		else
			return FALSE;

	}

	private function createSpecificRequestEntry()
	{
		$con = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Failed to connect to database');
		$tableName = "createProgramRequest";

		$requestId = $this->requestId;
    	$programName = $this->programName;
    	$term = $this->term;
    	$rationale = $this->rationale;
    	$crossImpact = $this->crossImpact;
    	$studentImpact = $this->studentImpact;
    	$comments = $this->comments;
    	$calendar = $this->calendar;
    	$libraryImpact = $this->libraryImpact;
    	$itsImpact = $this->itsImpact;

    	// sanitize all input
    	$requestId = mysqli_real_escape_string($con, $requestId);
    	$programName = mysqli_real_escape_string($con, $programName);
    	$term = mysqli_real_escape_string($con, $term);
    	$rationale = mysqli_real_escape_string($con, $rationale);
    	$crossImpact = mysqli_real_escape_string($con, $crossImpact);
    	$studentImpact = mysqli_real_escape_string($con, $studentImpact);
    	$comments = mysqli_real_escape_string($con, $comments);
    	$calendar = mysqli_real_escape_string($con, $calendar);
    	$libraryImpact = mysqli_real_escape_string($con, $libraryImpact);
    	$itsImpact = mysqli_real_escape_string($con, $itsImpact);


    	$insertSql = "INSERT INTO $tableName (id, programName, term, rationale, crossImpact, studentImpact, comments, calendar, libraryImpact, itsImpact) 
	     			  		VALUES ('$requestId', '$programName', '$term', '$rationale', '$crossImpact', '$studentImpact', '$comments', '$calendar', 
	     							'$libraryImpact', '$itsImpact')";

		mysqli_query($con, $insertSql);
		mysqli_close($con);
	}

	private function validateInput()
	{
		$con = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Failed to connect to database');

		// check to see if name is already taken
		// sanitize input
		$programName = mysqli_real_escape_string($con, $this->programName);
		$sql = "SELECT * FROM `createProgramRequest` 
					WHERE createProgramRequest.programName = '$programName'";

		$result = mysqli_query($con, $sql);
		$row = $result->fetch_assoc();
		if(count($row) > 0 || $this->programName == "")
			return FALSE;
		else
			return TRUE;

	}

	public function printRequestContent($user)
	{
		$approval = $this->verifyApprovalAccess($user);

		$requestContent = $this->printRequestJumbotron($approval);
		$requestContent .= $this->printRequestInfo();

		return $requestContent;
	}

	private function printRequestJumbotron($approval)
	{
		// print jumbotron
		$requestJumbotron = 
	                '<div class="jumbotron custom-jumbotron">
	                  <div class="container">
	                    <h1>'.$this->getProgramName().'</h1>';

  
		if($this->getState() == "in-progress")
		    $requestJumbotron .=
		                      '<p><strong>Waiting for the approval of: </strong>'.unserialize(MAJOR_CHANGE_STACK)[$this->getCurrentApprover()].'<p>';
	                    

		if($approval)
		{
		  	$requestJumbotron .=
							'<div class="row approval-btns">
								<div class="col-md-2 nav-btn-col">
									<p><a class="btn btn-primary btn-lg btn-success jumbotron-approval-btn" href="singleRequest.php?request='.$this->getRequestId().'&type='.$this->getType().'&submission=Approved" role="button">Approve   <span class="glyphicon glyphicon-ok" ></span></a></p>
								</div>
								<div class="col-md-2 nav-btn-col">
									<p><a class="btn btn-primary btn-lg btn-danger jumbotron-approval-btn" href="singleRequest.php?request='.$this->getRequestId().'&type='.$this->getType().'&submission=Denied" role="button">Reject   <span class="glyphicon glyphicon-remove" ></span></a></p>
								</div>
							</div>';
		}

		$requestJumbotron .=
		                  '</div>
		                </div>';
	    

	    return $requestJumbotron;
	}

	private function printRequestInfo()
	{

		$requestContent =
	                    '<div class="container general-content">
	                    <p><strong>Requested by: </strong>'.$this->getFirstname()." ".$this->getLastname().'</p>
	                    <p><strong>Request Type: </strong>'.$this->getType().'</p>
	                    <p><strong>Date Created: </strong>'.$this->getCreationDate().'</p>
	                    <p><strong>Term to be implemented: </strong>'.$this->getTerm().'</p>';
		if($this->getRationale() != "")
			$requestContent .=					
									'<div class="row">
										<div class="col-md-12">
							  				<h3>Rationale</h3>
							  				<p>'.$this->getRationale().'</p>
										</div>
									</div>';

		if($this->getCrossImpact() != "")
					$requestContent .=
								'<div class="row">
									<div class="col-md-12">
						  				<h3>CrossImpact</h3>
						  				<p>'.$this->getCrossImpact().'</p>
									</div>
								</div>';

		if($this->getStudentImpact() != "")
					$requestContent .=
								'<div class="row">
									<div class="col-md-12">
						  				<h3>Student Impact</h3>
						  				<p>'.$this->getStudentImpact().'</p>
									</div>
								</div>';

		if($this->getLibraryImpact() != "")
					$requestContent .=
								'<div class="row">
									<div class="col-md-12">
						  				<h3>Library Impact</h3>
						  				<p>'.$this->getLibraryImpact().'</p>
									</div>
								</div>';

		if($this->getItsImpact() != "")
					$requestContent .=
								'<div class="row">
									<div class="col-md-12">
						  				<h3>ITS Impact</h3>
						  				<p>'.$this->getItsImpact().'</p>
									</div>
								</div>';

		if($this->getCalendar() != "")
					$requestContent .=								
								'<div class="row">
									<div class="col-md-12">
						  				<h3>Calendar</h3>
						  				<p>'.$this->getCalendar().'</p>
									</div>
								</div>';

		if($this->getComments() != "")
					$requestContent .=								
								'<div class="row">
									<div class="col-md-12">
						  				<h3>Comments</h3>
						  				<p>'.$this->getComments().'</p>
									</div>
								</div>';

		$requestContent .= '</div>';

		return $requestContent;
	}

	public function setProgramName($value) { $this->programName = $value; }
	public function getProgramName() { return $this->programName; }

	public function setTerm($value) { $this->term = $value; }
	public function getTerm() { return $this->term; }

	public function setRationale($value) { $this->rationale = $value; }
	public function getRationale() { return $this->rationale; }

	public function setCrossImpact($value) { $this->crossImpact = $value; }
	public function getCrossImpact() { return $this->crossImpact; }

	public function setStudentImpact($value) { $this->studentImpact = $value; }
	public function getStudentImpact() { return $this->studentImpact; }

	public function setComments($value) { $this->comments = $value; }
	public function getComments() { return $this->comments; }

	public function setCalendar($value) { $this->calendar = $value; }
	public function getCalendar() { return $this->calendar; }

	public function setLibraryImpact($value) { $this->libraryImpact = $value; }
	public function getLibraryImpact() { return $this->libraryImpact; }

	public function setItsImpact($value) { $this->itsImpact = $value; }
	public function getItsImpact() { return $this->itsImpact; }
}
?>