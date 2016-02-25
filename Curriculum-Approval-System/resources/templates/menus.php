<?php

function createRequestMenu()
{
	$menu =
			'<div class="container menu-content">
				<h2>Add/Remove program or course</h2>
				<div class="row">
					<div class="col-md-2 col-sm-1"></div>
					<div class="col-md-4 col-sm-5 nav-btn-col">
					<p><a class="btn btn-primary btn-lg jumbotron-nav-btn" href="formProcessing.php?addProgram=addProgram" role="button">Add a new program</a></p>
					</div>
					<div class="col-md-4 col-sm-5 nav-btn-col">
					<p><a class="btn btn-primary btn-lg jumbotron-nav-btn" href="formProcessing.php?removeProgram=removeProgram" role="button">Remove a program</a></p>
					</div>
					<div class="col-md-2 col-sm-1 col-xs-1"></div>
				</div>
				<div class="row">
					<div class="col-md-2 col-sm-1"></div>
					<div class="col-md-4 col-sm-5 nav-btn-col">
					<p><a class="btn btn-primary btn-lg jumbotron-nav-btn" href="formProcessing.php?addCourse=addCourse" role="button">Add a new course</a></p>
					</div>
					<div class="col-md-4 col-sm-5 nav-btn-col">
					<p><a class="btn btn-primary btn-lg jumbotron-nav-btn" href="formProcessing.php?removeCourse=removeCourse" role="button">Remove a course</a></p>
					</div>
					<div class="col-md-2 col-sm-1 col-xs-1"></div>
				</div>
				<h2>Change an existing program or course</h2>
			</div>';

    return $menu;

}

?>