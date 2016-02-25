<?php
class Login 
{ 
  // User input
  private $username;
  private $password;
  private $remember;

  // Indicates if credentials have been validated yet
  private $hasValidated;

  // Indicates the results of credential validation
  private $valid;
  private $message;

  // Constructor initializing the hasValidated bool
  public function __construct() 
  {
    $this->hasValidated = TRUE;
  }


  // Process user credentials against a user database and save credentials 
  // in a session/cookie if valid
  public function processUserCredentials($username, $password, $remember)
  {
    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Failed to connect to database');

    // set user information
    $this->username = $username;
    $this->password = $password;
    $this->remember = $remember;

    // has been validated 
    $this->hasValidated = FALSE;

    // sanitize input
    $username = mysqli_real_escape_string($con, $username);

    // querry username
    $result = mysqli_query($con, "SELECT * FROM Users WHERE username = '$username'");

    // match entered password with the selected username
    $row = mysqli_fetch_assoc($result);

      // username was not found
      if(count($row) == 0)
      {
        $this->valid = FALSE;
        $this->message = "That username does not exist";
      }
      // password did not match the username
      else if ($row['password'] != md5($this->password)) 
      {
        $this->valid = FALSE;
        $this->message = "The username and password do not match";

      }
      // username and password match with an existing user
      else if ($row['password'] == md5($this->password)) 
      {
        $this->valid = TRUE;

        // save session/cookie
        $this->saveUserState($row);
      }

    mysqli_close($con);

    // return true if user found and false if not found
    return $this->valid;
  }


  // Saves user information in a session/cookie
  public function saveUserState($data)
  {
    session_start();
    $_SESSION['user'] = $data['username'];
    $_SESSION['password'] = $data['password'];
    session_write_close();

    if($this->remember == "remember-me")
    {
      setcookie("user", $data['username']);
      setcookie("password", $data['password']);
    }
    else
    {
      session_start();
      $_SESSION['user'] = $data['username'];
      $_SESSION['password'] = $data['password'];
      session_write_close();
    }
  }


  // Creates an alert box displaying an error message inside
  public function printLoginDisplay()
  {
    $result = "<div class=\"container login-container\">";

    //If not valid show alert box
    if(!$this->valid && !$this->hasValidated)
      $result .= $this->createAlertBox();

    //Show main login form
    $result .= $this->createLoginForm();

    $result .= "</div>";

    echo $result;
  }

  // Creates an alert box displaying an error message inside
  private function createAlertBox()
  {
    $alert = '<div class="alert alert-danger login-alert" role="alert">
                <span class="glyphicon glyphicon-info-sign glyphicon-alert" ></span><span class="text-alert"><strong>'.$this->message.'</strong></span>
              </div>';

    return $alert;
  }

  // Creates a login form
  private function createLoginForm()
  {

    $loginForm =  '<div class="jumbotron login-jumbotron">
                    <form class="form-signin" role="form" action="login.php" method="POST">
                      <h2 class="form-signin-heading">Login</h2>
                      <input name = "username" type="username" class="form-control" placeholder="Username" required autofocus>
                      <input name = "password" type="password" class="form-control" placeholder="Password" required>
                      <label class="checkbox">
                        <input name="remember" type="checkbox" value="remember-me"> Keep me signed in
                      </label>
                      <button class="btn btn-lg btn-primary btn-block btn-block-login" type="submit">Sign in</button>
                    </form>
                  </div>';

    return $loginForm;
  }
}


?>