<?php

function createInformativeJumbotron($title, $message)
{
          
  $jumbotron =  '<div class="jumbotron custom-jumbotron">
                  <div class="container">
                    <h1>'.$title.'</h1>
                    <p>'.$message.'</p>
                  </div>
                </div>';

  return $jumbotron;
}

function createRequestJumbotron($request)
{
  $jumbotron =  
                '<div class="jumbotron custom-jumbotron">
                  <div class="container">
                    <h1>'.$request->getProgramName().'</h1>';

  
  if($request->getState() == "in-progress")
    $jumbotron .=
                      '<p><strong>Waiting for the approval of: </strong>'.unserialize(MAJOR_CHANGE_STACK)[$request->getCurrentApprover()].'<p>';
                    
  $jumbotron .=
                    '<div class="row">
                      <div class="col-md-2 col-sm-1"></div>
                      <div class="col-md-4 col-sm-5 nav-btn-col">
                        <p><a class="btn btn-primary btn-lg jumbotron-nav-btn" href="#" role="button">Approve</a></p>
                      </div>
                      <div class="col-md-4 col-sm-5 nav-btn-col">
                        <p><a class="btn btn-primary btn-lg jumbotron-nav-btn" href="#" role="button">Reject</a></p>
                      </div>
                      <div class="col-md-2 col-sm-1 col-xs-1"></div>
                    </div>
                  </div>
                </div>';

  return $jumbotron;
}

function createNavJumbotron($title, $message)
{
          
  $jumbotron =  '<div class="jumbotron custom-jumbotron">
                  <div class="container">
                    <h1>'.$title.'</h1>
                    <p>'.$message.'</p>
                    <div class="row">
                      <div class="col-md-2 col-sm-1"></div>
                      <div class="col-md-4 col-sm-5 nav-btn-col">
                        <p><a class="btn btn-primary btn-lg jumbotron-nav-btn" href="generalNav.php?makeRequest=makeRequest" role="button">Make Request</a></p>
                      </div>
                      <div class="col-md-4 col-sm-5 nav-btn-col">
                        <p><a class="btn btn-primary btn-lg jumbotron-nav-btn" href="search.php?view=all" role="button">Browse Requests</a></p>
                      </div>
                      <div class="col-md-2 col-sm-1 col-xs-1"></div>
                    </div>
                  </div>
                </div>';

  return $jumbotron;
}

?>