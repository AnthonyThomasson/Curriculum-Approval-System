<?php 

function createNavbar($currentuser)
{

  $navbar = '<div class="navbar navbar-blue navbar-static-top" role="navigation">
              <div class="container">
              <div class="navbar-header">
                <a class="navbar-brand" href="index.php">CAT</a>
              </div>
              <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-left navbar-menu">
                  <li class="active"><a href="generalNav.php?makeRequest=makeRequest">Make Request</a></li>
                  <li><a href="search.php?view=all">Browse Requests</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right current-user">
                  <li class="logout-btn">
                    <a href="index.php?logout=true">Log out</a>
                  </li>
                </ul>                
      
                <form class="navbar-form navbar-right" action="search.php" method="GET" role="search">
                  <div class="form-group">
                    <input name="searchParam" type="text" class="form-control search-nav" placeholder="Search">
                  
                    <button type="submit" class="btn btn-default search-btn">Search</button>
                  </div>
                </form>


                <ul class="nav navbar-nav navbar-right current-user">
                   <li>
                      <span>'.
                        $currentuser->getFirstname().' '.$currentuser->getLastname()
                      .'</span>
                    </li>
                </ul> 
              </div>
              </div>
            </div>';

  return $navbar;

}
?>
