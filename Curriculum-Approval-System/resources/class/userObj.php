<?php
class User 
{ 
  private $userID;
  private $username;
  private $password; 
  private $firstname; 
  private $lastname;
  private $faculty;
  private $discipline;
  private $phone;
  private $email;
  private $director;
  private $title;
    
  // Looks to see if there is a session/cookie for a user and loads user information.
  // If no user found return false
  public function loadCurrentUser()
  {
    // look for user in session or cookie
    session_start();
    if(isset($_SESSION['user']) && isset($_SESSION['password']))
    {
      $username = $_SESSION['user'];
      $password = $_SESSION['password'];
    }
    elseif(isset($_COOKIE['user']) && isset($_COOKIE['password']))
    {
      $username = $_COOKIE['user'];
      $password = $_COOKIE['password'];
    }
    session_write_close();


    // if user was found load user data
    if(isset($username) && isset($password))
    {
      $con = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Failed to connect to database');

      // sanitize input
      $username = mysqli_real_escape_string($con, $username);

      // querry username
      $result = mysqli_query($con, "SELECT * FROM users WHERE username = '$username'");
      $data = mysqli_fetch_assoc($result);

      // validate username and password in session/cookie
      if($username == $data["username"] && $password == $data["password"])
      {
        // set all user data
        $this->userId = $data['userId'];
        $this->username = $data["username"];
        $this->password = $data["password"];
        $this->firstname = $data["firstname"];
        $this->lastname = $data["lastname"];
        $this->faculty = $data["faculty"];
        $this->discipline = $data["discipline"];
        $this->phone = $data["phone"];
        $this->email = $data['email'];
        $this->director = $data["director"];
        $this->title = $data["title"];

        mysqli_close($con);
        
        // user was found
        return TRUE;
      }
      else
        // password in cookie/session is wrong
        return FALSE;
    }
    // user was not found
    return FALSE;
  }

  // Removes session and cookie information for the current user
  // and redirects to the login page
  public function logout()
  {
    session_start();
    setcookie (session_id(), "user", time() - 3600);
    setcookie (session_id(), "password", time() - 3600);
    session_destroy();


    header("location: login.php");
    session_write_close();
  }

  public function listPendingApprovalRequests()
  {
    $title = "Requests Pending Users Approval";

    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Failed to connect to database');
    $userId = $this->getUserId();
    $fname = $this->getFirstname();
    $lname = $this->getLastname();
    $sql = "SELECT users.firstname, users.lastname, request.id, request.type, request.state, request.creationDate, createProgramRequest.programName
                      FROM `request`, `createProgramRequest`, `approval`, `users` 
                        WHERE approval.userId = '$userId' 
                          AND approval.requestId = request.id 
                          AND request.id = createProgramRequest.id 
                          AND request.userId = users.userId 
                          AND approval.userId != request.userId 
                          AND approval.approved = 'Unset'";

    $result = mysqli_query($con, $sql);
    $pendingApprovalRequests = $this->printRequestDataTable($result, $title);

    mysqli_close($con);
    return $pendingApprovalRequests;
  }

  public function listUsersRequestsBox()
  {
    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Failed to connect to database');
    $userId = $this->getUserId();
    $sql = "SELECT * FROM `request`, `createProgramRequest`, `users` 
                      WHERE request.userId = '$userId' 
                        AND request.userId = users.userId
                        AND request.id = createProgramRequest.id";

    $result = mysqli_query($con, $sql);

    $requestsList = $this->printUserRequestsBox($result);

               
    mysqli_close($con);
    return $requestsList;
  }

  public function listUsersRequestsTable()
  {
    $title = "Users Requests";

    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Failed to connect to database');
    $userId = $this->getUserId();
    $sql = "SELECT * FROM `request`, `createProgramRequest`, `users` 
                      WHERE request.userId = '$userId' 
                        AND request.userId = users.userId
                        AND request.id = createProgramRequest.id";

    $result = mysqli_query($con, $sql);

    $title = "Users Requests";
    $requestsList = $this->printRequestDataTable($result, $title);

               
    mysqli_close($con);
    return $requestsList;
  }

  private function printUserRequestsBox($result)
  {
    $requestsList = '<div class="container requests-regular">';
    while($row = $result->fetch_assoc())
    {

      $percentage = (($row['currentApprover']+1)/(count(unserialize(MAJOR_CHANGE_STACK))))*100;

      $requestsList .= 
                        '<div class="col-md-4 col-sm-6">
                            <div class="thumbnail request-thumbnail">
                              <h2>'.$row['programName'].'</h2>
                                <div class="progress request-progress">';
      if($percentage >= 100)
        $requestsList .= 
                                  '<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'.$percentage.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$percentage.'%">
                                    <span class="sr-only">'.$percentage.'% Complete</span>
                                  </div>';
      else
        $requestsList .= 
                                  '<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="'.$percentage.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$percentage.'%">
                                    <span class="sr-only">'.$percentage.'% Complete</span>
                                  </div>';
      $requestsList .= 
                                '</div>
                              <p><strong>Date Created: </strong>'.$row['creationDate'].'</p>
                              <p><strong>Status: </strong>'.$row['state'].'</p>
                              <p><a class="btn btn-primary" href="singleRequest.php?request='.$row['id'].'&type='.$row['type'].'" role="button">View details &raquo;</a></p>
                            </div>
                          </div>';
    }

    $requestsList .= '</div>';

    return $requestsList;
  }

  private function printRequestDataTable($result, $title)
  {

    $pendingApprovalRequests =
                            '<div class="container">
                            <div class="panel panel-default approval-alert">
                              <!-- Default panel contents -->
                              <div class="panel-heading"><h3>'.$title.'<h3></div>

                              <!-- Table -->
                              <table id="results-table" class="table tablesorter">
                                <thead>
                                  <tr>
                                    <th class="alert-requestId">Request ID</th>
                                    <th class="alert-programName">Title</th>
                                    <th class="alert-creatorName">Requested By</th>
                                    <th class="alert-creationDate">Time Created</th>
                                    <th class="alert-state">State</th>
                                    <th class="alert-viewBtn"></th>
                                  </tr>
                                </thead>
                                <tbody>';

    while($row = $result->fetch_assoc())
    {
      $pendingApprovalRequests .=
                                  '<tr>
                                    <td class="alert-requestId">'.$row['id'].'</td>
                                    <td class="alert-programName">'.$row['programName'].'</td>
                                    <td class="alert-creatorName">'.$row['firstname']." ".$row['lastname'].'</td>
                                    <td class="alert-creationDate">'.$row['creationDate'].'</td>
                                    <td class="alert-state">'.$row['state'].'</td>
                                    <td class="alert-viewBtn"><p><a class="btn btn-primary" href="singleRequest.php?request='.$row['id'].'&type='.$row['type'].'" role="button">View details &raquo;</a></p></td>
                                  </tr>';
    }

    $pendingApprovalRequests .=
                            '</tbody>
                          </table>
                        </div>
                        </div>';

    return $pendingApprovalRequests;
  }


  public function setUserId($value) { $this->userId = $value; }
  public function getUserId() { return $this->userId; }

  public function setUsername($value) { $this->username = $value; }
  public function getUsername() { return $this->username; }

  public function setPassword($value) { $this->password = $value; }
  public function getPassword() { return $this->password; }

  public function setFirstname($value) { $this->firstname = $value; }
  public function getFirstname() { return $this->firstname; }

  public function setLastname($value) { $this->lastname = $value; }
  public function getLastname() { return $this->lastname; }

  public function setFaculty($faculty) { $this->faculty = $faculty; }
  public function getFaculty() { return $this->faculty; }

  public function setDiscipline($value) { $this->discipline = $value; }
  public function getDiscipline() { return $this->discipline; }

  public function setPhone($value) { $this->phone = $value; }
  public function getPhone() { return $this->phone; }

  public function setEmail($value) { $this->email = $value; }
  public function getEmail() { return $this->email; }

  public function setDirector($value) { $this->director = $value; }
  public function getDirector() { return $this->director; }

  public function setTitle($value) { $this->title = $value; }
  public function getTitle() { return $this->title; }

}
?>