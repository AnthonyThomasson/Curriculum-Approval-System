<?php

function listUsersRequests($currentuser, $con)
{

  $userId = $currentuser->getUserId();

  // querry username
  $result = mysqli_query($con, "SELECT * FROM `request`, `createProgramRequest` WHERE request.userId = '$userId' AND request.id = createProgramRequest.id");

  $requestsList = createHeadingJumbotron("User's Current Requests");

  while($row = $result->fetch_assoc())
  {
    $percentage = (($row['currentApprover']+1)/(count(unserialize(MAJOR_CHANGE_STACK))));

    $requestsList .= 

                      '<div class="container requests-regular">
                        <div class="col-md-4 col-sm-6">
                          <div class="thumbnail request-thumbnail">
                            <h2>'.$row['programName'].'</h2>
                              <div class="progress request-progress">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="'.$percentage.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$percentage.'%">
                                  <span class="sr-only">'.$percentage.'% Complete</span>
                                </div>
                              </div>
                            <p><strong>Date Created: </strong>'.$row['creationDate'].'</p>
                            <p><strong>Status: </strong>'.$row['state'].'</p>
                            <p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>
                          </div>
                        </div>';
  }

                   

  return $requestsList;
}

function listMinUsersRequests($currentuser, $con)
{

  $requestsList =   '<div class="container requests-min">
                      <div class="col-md-12">
                        <div class="thumbnail request-min-thumbnail">
                          <h2>Request 1</h2>
                          <p><strong>Date Created: </strong>September 15, 2014</p>
                          <p><strong>Status: </strong>Waiting for APPC approval</p>
                          <p><a class="btn btn-primary min-request-btn" href="#" role="button">View details &raquo;</a></p>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="thumbnail request-min-thumbnail">
                          <h2>Request 2</h2>
                          <p><strong>Date Created: </strong>August 4, 2014</p>
                          <p><strong>Status: </strong>Waiting for GFC approval</p>
                          <p><a class="btn btn-primary min-request-btn" href="#" role="button">View details &raquo;</a></p>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="thumbnail request-min-thumbnail">
                          <h2>Request 3</h2>
                          <p><strong>Date Created: </strong>April 20, 2014</p>
                          <p><strong>Status: </strong>Completed (September 15, 2014)</p>
                          <p><a class="btn btn-primary min-request-btn" href="#" role="button">View details &raquo;</a></p>
                        </div>
                      </div>
                    </div>';

  return $requestsList;

}

?>