<?php
class Email
{
	// email sender and reciever
	private $from;
	private $to;

	// email message info
	private $subject;
	private $body;

	public function __construct($from, $subject, $body)
	{
		$this->from = $from;

		$this->subject = $subject;
		$this->body = $body;
	}

	public function sendEmailToApprovers($groupId)
	{
		// select userId from the groupId in the approval table
		$con = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Failed to connect to database');
		$tableName = "createProgramRequest";
		$selectUser = "SELECT users.email FROM `users` LEFT JOIN `approval` ON approval.userId = users.userId WHERE approval.groupId = '$groupId'";
		$result = mysqli_query($con, $selectUser);

		//send the email with THIS 
		mail("rop.tyler@gmail.com", $this->subject, $this->body);

		mysqli_close($con);
	}

	public function setFrom($value) { $this->from = $value; }
	public function getFrom() { return $this->from; }

	public function setTo($value) { $this->to = $value; }
	public function getTo() { return $this->to; }

	public function setSubject($value) { $this->subject = $value; }
	public function getSubject() { return $this->subject; }

	public function setBody($value) { $this->body = $value; }
	public function getBody() { return $this->body; }
}

?>