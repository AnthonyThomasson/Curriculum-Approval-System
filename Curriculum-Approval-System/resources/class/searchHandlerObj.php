<?php
class SearchHandler
{
    public function searchByParam($param) 
    {
        $title = "Search by program name";

        $con = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Failed to connect to database');
        $param = mysqli_real_escape_string($con, $param);
        $sql = "SELECT users.userId, users.firstname, users.lastname, request.id, request.state, request.type, createProgramRequest.programName, request.creationDate 
                        FROM `request`, `createprogramrequest`, `users` 
                            WHERE users.userId = request.userId 
                            AND request.id = createProgramRequest.id 
                            AND createProgramRequest.programName LIKE '%$param%'
                                GROUP BY request.id";

        $result = mysqli_query($con, $sql);

        $resultsDisplay = $this->printJumbotronControls();
        $resultsDisplay .= $this->printResultsDisplay($result, $title);

        return $resultsDisplay;
    }
    public function listAllRequests() 
    {
        $title = "All Requests";

        $con = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Failed to connect to database');
        $sql = "SELECT users.userId, users.firstname, users.lastname, request.id, request.state, request.type, createProgramRequest.programName, request.creationDate 
                        FROM `request`, `createprogramrequest`, `users` 
                            WHERE users.userId = request.userId 
                            AND request.id = createProgramRequest.id 
                                GROUP BY request.id";

        $result = mysqli_query($con, $sql);

        $resultsDisplay = $this->printJumbotronControls();
        $resultsDisplay .= $this->printResultsDisplay($result, $title);

        return $resultsDisplay;

    }

    public function listUsersRequests($user) 
    {
        $resultsDisplay = $this->printJumbotronControls();
        $resultsDisplay .=  $user->listUsersRequestsTable();

        return $resultsDisplay;

    }

    public function listPendingApproval($user) 
    {
        $resultsDisplay = $this->printJumbotronControls();
        $resultsDisplay .=  $user->listPendingApprovalRequests();

        return $resultsDisplay;

    }

    public function listAllApproved() 
    {
        $title = "All Approved Requests";

        $con = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Failed to connect to database'); 
        $sql = "SELECT users.userId, users.firstname, users.lastname, users.username, request.id, request.state, createProgramRequest.programName, request.creationDate, request.type 
                    FROM `request`, `createprogramrequest`, `users` 
                        WHERE users.userId = request.userId 
                            AND request.id = createprogramrequest.id 
                            AND request.state = 'Complete' 
                        GROUP BY request.id";

        $result = mysqli_query($con, $sql);

        $resultsDisplay = $this->printJumbotronControls();
        $resultsDisplay .= $this->printResultsDisplay($result, $title);

        return $resultsDisplay;

    }

    public function listAllNotApproved() 
    {
        $title = "All Not Approved Requests";

        $con = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Failed to connect to database'); 
        $sql = "SELECT users.userId, users.firstname, users.lastname, request.id, request.state, request.type, createProgramRequest.programName, request.creationDate
                        FROM `request`, `createprogramrequest`, `approval`, `users` 
                            WHERE users.userId = request.userId 
                                AND request.id = createProgramRequest.id
                                AND request.id = approval.requestId
                                AND request.state != 'Complete' 
                                    GROUP BY request.id";

        $result = mysqli_query($con, $sql);

        $resultsDisplay = $this->printJumbotronControls();
        $resultsDisplay .= $this->printResultsDisplay($result, $title);

        return $resultsDisplay;

    }

    private function printResultsDisplay($result, $title) 
    {

        $resultsDisplay =
                        '<div class="container">
                        <div class="panel panel-default approval-alert">
                          <!-- Default panel contents -->
                          <div class="panel-heading">
                            <h3>'.$title.'<h3>
                            <h5><i>(Press table headings to sort column)</i></h5>
                          </div>

                          <!-- Table -->
                          <table id="results-table" class="table tableSorter">
                            <thead>
                              <tr>
                                <a href="#"><th class="alert-requestId">Request ID</th></a>
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
            $resultsDisplay .=
                              '<tr>
                                <td class="alert-requestId">'.$row['id'].'</td>
                                <td class="alert-programName">'.$row['programName'].'</td>
                                <td class="alert-creatorName">'.$row['firstname']." ".$row['lastname'].'</td>
                                <td class="alert-creationDate">'.$row['creationDate'].'</td>
                                <td class="alert-state">'.$row['state'].'</td>
                                <td class="alert-viewBtn"><p><a class="btn btn-primary" href="singleRequest.php?request='.$row['id'].'&type='.$row['type'].'" role="button">View details &raquo;</a></p></td>
                              </tr>';
        }   

        $resultsDisplay .=
                            '</tbody>
                          </table>
                        </div>
                        </div>';

        return $resultsDisplay;
    }

    private function printJumbotronControls() 
    {
          $jumbotron =  '<div class="jumbotron custom-jumbotron">
                            <div class="container">
                                <h1>Search</h1>

                                    <form class="search-main" action="search.php" method="GET">
                                        <input name="searchParam" type="text" class="form-control search-input-main" placeholder="Search">
                                        <button type="submit" class="btn btn-default search-btn-main">Search</button>
                                    </form>
                                
                                    
                                <div class="col-md-2 nav-btn-col">
                                    <p><a class="btn btn-primary btn-lg jumbotron-filter-btn" href="search.php?view=all" role="button">All Requests</a></p>
                                </div>

                                <div class="col-md-2 nav-btn-col">
                                    <p><a class="btn btn-primary btn-lg jumbotron-filter-btn" href="search.php?view=userRequests" role="button">Your Requests</a></p>
                                </div>
                                <div class="col-md-2 nav-btn-col">
                                    <p><a class="btn btn-primary btn-lg jumbotron-filter-btn" href="search.php?view=pendingApproval" role="button">Pending Approval</a></p>
                                </div>
                                <div class="col-md-2 nav-btn-col">
                                    <p><a class="btn btn-primary btn-lg jumbotron-filter-btn" href="search.php?view=approved" role="button">Approved</a></p>
                                </div>
                                <div class="col-md-2 nav-btn-col">
                                    <p><a class="btn btn-primary btn-lg jumbotron-filter-btn" href="search.php?view=notApproved" role="button">Not Approved</a></p>
                                </div>
                                

                            </div>
                        </div>';

        return $jumbotron;
    }
}