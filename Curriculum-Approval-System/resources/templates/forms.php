<?php

function createAddProgramForm($validInput)
{

	// connection
	$con = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die('Failed to connect to database');

	// querry username
    $result = mysqli_query($con, "SELECT * FROM term");

	$form = 
						'<div class="container general-content">';


	if(!$validInput)
		$form .= 
						'<div class="alert alert-danger" role="alert">
							<p> Invalid Program Name. </p>
				  		</div>';


		$form .= 
						'<div class="form-context">
							<div class="form-context">
							<p class="programName-context"><strong>Program Name: </strong><span></span></p>
							<p class="term-context"><strong>Effective term for change: </strong><span></span></p>
							</div>
						</div>';

    	// pagination
		$form .=
							'<div class="form-pagination">
								<ul class="pagination">
									<li><a class="prev-btn">&laquo;</a></li>
									<li><a href="#">1</a></li>
									<li><a href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li><a href="#">4</a></li>
									<li><a href="#">5</a></li>
									<li><a class="next-btn">&raquo;</a></li>
								</ul>
							</div>';


	$form .= 		'<form class="general-form" role="form" method="POST" action="formProcessing.php?addProgram=addProgram">
								<div id="page-one">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
								    			<label>Program Name</label>
								    			<input name="programName" class="form-control" placeholder="Program Name" data-validetta="required,minLength[1]">
								  			</div>
								  		</div>
								  		<div class="col-md-6">
								  			<div class="form-group">
								    			<label>Effective Term For Change</label>
								    			<select name="term" class="form-control">';

								    			while($row = $result->fetch_assoc())
								    				$form .= '<option>'.$row['season'].' - '.$row['year'].'</option>';

	$form .=   					   '</select>
								  			</div>
								  		</div>
								  	</div>
							  	</div>
							  	<div id="page-two">
							  		<div class="row">
										<div class="col-md-6">
							  				<div class="form-group">
							    				<label>
							    					Rationale
							    				</label>
							    			
												<textarea name="rationale" class="form-control" rows="5" placeholder=""></textarea>
												<input class="resource-upload" type="file">
											</div>
										</div>
										<div class="col-md-6">
							  				<div class="form-group">
							    				<label>
													Library Impact
												</label>
							    			
												<textarea name="libraryImpact" class="form-control" rows="5"></textarea>
												<input class="resource-upload" type="file">
											</div>
										</div>
									</div>
								</div>
								<div id="page-three">
									<div class="row">
										<div class="col-md-6">
							  				<div class="form-group">
							    				<label>
													Student Input/Impact
												</label>
							    			
												<textarea name="studentImpact" class="form-control" rows="5" placeholder=""></textarea>
												<input class="resource-upload" type="file">
												<span class="help-block">
													Please identify how student input or impact has been assessed
												</span>
											</div>
										</div>
										<div class="col-md-6">
							  				<div class="form-group">
							    				<label>
													Cross Impact
												</label>
							    			
												<textarea name="crossImpact" class="form-control" rows="5" placeholder=""></textarea>
												<input class="resource-upload" type="file">
												<span class="help-block">
													Please identify how impact to other departments has been addressed, including General Education as appropriate
												</span>
											</div>
										</div>
									</div>
								</div>
								<div id="page-four">
									<div class="row">
										<div class="col-md-6">
							  				<div class="form-group">
							    				<label>
													ITS Impact
												</label>
							    			
												<textarea name="itsImpact" class="form-control" rows="5"></textarea>
												<input class="resource-upload" type="file">
											</div>
										</div>
										<div class="col-md-6">
							  				<div class="form-group">
							    				<label>
													Proposed Calendar
												</label>
							    			
												<textarea name="calendar" class="form-control" rows="5"></textarea>
												<input class="resource-upload" type="file">
											</div>
										</div>
									</div>
								</div>
								<div id="page-five">
									<div class="row">
										<div class="col-md-12">
							  				<div class="form-group">
							    				<label>
													General Comments
												</label>
							    			
												<textarea name="comments" class="form-control" rows="5"></textarea>
												<input class="resource-upload" type="file">
											</div>
										</div>
									</div>
									<button type="submit" class="btn btn-default pull-right">Submit</button>
								</div>
							</form>';

    // pagination
	$form .= 
							'<div class="form-pagination">
								<ul class="pagination">
									<li><a class="prev-btn">&laquo;</a></li>
									<li><a class="0" href="#">1</a></li>
									<li><a class="1" href="#">2</a></li>
									<li><a class="2" href="#">3</a></li>
									<li><a class="3" href="#">4</a></li>
									<li><a class="4" href="#">5</a></li>
									<li><a class="next-btn">&raquo;</a></li>
								</ul>
							</div>
						</div>';

    mysqli_close($con);

	return $form;
}

function createAddCourseForm()
{

	$addCourseForm =
	'<div class="container form-content">
		<form class="general-form" role="form">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Program</label>
						<select class="form-control">
							<option></option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Effective Term For Change</label>
						<select class="form-control">
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>
							Course(s)
						</label>
					
						<textarea class="form-control" rows="5" placeholder=""></textarea>
						<input class="resource-upload" type="file" id="exampleInputFile">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>
							Title
						</label>
					
						<textarea class="form-control" rows="5"></textarea>
						<input class="resource-upload" type="file" id="exampleInputFile">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>
							Prerequisites
						</label>
					
						<textarea class="form-control" rows="5" placeholder=""></textarea>
						<input class="resource-upload" type="file" id="exampleInputFile">
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label>
							Schedule Type
						</label>
						<div class="radio">
							<label>
								<input type="radio" checked>
								Lecture
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio">
								Lab
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio">
								Tutorial
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio">
								Other
							</label>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>
							Transfer Credit
						</label>
						<div class="radio">
							<label>
								<input type="radio" checked>
								Required
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio">
								Preferred
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio">
								Not Required
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
						<div class="form-group">
						<label>
							Student Input/Impact
						</label>
					
						<textarea class="form-control" rows="5" placeholder=""></textarea>
						<input class="resource-upload" type="file" id="exampleInputFile">
						<span class="help-block">
							Please identify how student input or impact has been assessed
						</span>
					</div>
				</div>
				<div class="col-md-6">
	  				<div class="form-group">
	    				<label>
	    					Rational
	    				</label>
	    			
						<textarea class="form-control" rows="5" placeholder=""></textarea>
						<input class="resource-upload" type="file" id="exampleInputFile">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
	  				<div class="form-group">
	    				<label>
							Library Impact
						</label>
	    			
						<textarea class="form-control" rows="5"></textarea>
						<input class="resource-upload" type="file" id="exampleInputFile">
					</div>
				</div>
				<div class="col-md-6">
	  				<div class="form-group">
	    				<label>
							Cross Impact
						</label>
	    			
						<textarea class="form-control" rows="5" placeholder=""></textarea>
						<input class="resource-upload" type="file" id="exampleInputFile">
						<span class="help-block">
							Please identify how impact to other departments has been addressed, including General Education as appropriate
						</span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
	  				<div class="form-group">
	    				<label>
							ITS Impact
						</label>
	    			
						<textarea class="form-control" rows="5"></textarea>
						<input class="resource-upload" type="file" id="exampleInputFile">
					</div>
				</div>
				<div class="col-md-6">
	  				<div class="form-group">
	    				<label>
							Proposed Calendar
						</label>
	    			
						<textarea class="form-control" rows="5"></textarea>
						<input class="resource-upload" type="file" id="exampleInputFile">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
	  				<div class="form-group">
	    				<label>
							General Comments
						</label>
	    			
						<textarea class="form-control" rows="5"></textarea>
						<input class="resource-upload" type="file" id="exampleInputFile">
					</div>
				</div>
			</div>
				<button type="submit" class="btn btn-default pull-right">Submit</button>
		</form>
	</div>';

	return $addCourseForm;
}
?>
