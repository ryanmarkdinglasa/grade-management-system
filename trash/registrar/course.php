<?php
	error_reporting(0);
	session_start();
	include("include/session.php");
	$parentpage='';
	$parentpage_link='';
	$page=$currentpage='Course';
	include("include/header.php");

	?>
	<script>
		if ( window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href );
		}
	</script>
	</head>
	<?php	include("include/sidebar.php");	?>
	<!-- Main content -->
	<div class="main-content" id="panel">
		<?php
			include("include/topnav.php"); //Edit topnav on this page
			include("include/prompt");
		?>
		<div class="header bg-primary pb-6">
		  <div class="container-fluid">
			<div class="header-body">
			  <div class="row align-items-center py-4">
				<div class="col-lg-6 col-7">
				  <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
					<ol class="breadcrumb breadcrumb-links breadcrumb-dark">
					<li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
					  <li class="breadcrumb-item"><a href="./">Dashboard</a></li>
					  <li class="breadcrumb-item active" aria-current="page">Course</li>
					</ol>
				  </nav>
				</div>
				<div class="col-lg-6 col-5 text-right">
				</div>
			  </div>
			</div>
		  </div>
		</div>
			<style>
			/* Hide the scrollbar for the sidenav */
			.modal::-webkit-scrollbar {
				width: 0.4em; /* Adjust the width as desired */
				display: none; /* Hide the scrollbar */
			}
			.modal {
				overflow: -moz-scrollbars-none;
				scrollbar-width: none;
			}
			</style>
			<div class="col-md-4">
				<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal" role="document">
                      <div class="modal-content">
                        <div class="modal-body p-0">
                          <div class="card bg-secondary border-0 mb-0">
                            <div class="card-body px-lg-5 py-lg-5">
                              <div class="text-center text-muted mb-3">
                                <small class="form-control-label">Add New Course</small>
                              </div>
                              <form role="form" method="post" action="course_controller.php">
							  	<div class="form-group mb-2">
									<label class="form-control-label mb-0">Subject Code</label>
                                  	<div class="input-group input-group-merge input-group-alternative">
										<input type="text" class="form-control"  name="subject_code" id="subject_code" placeholder="Enter subject code" type="text" oninvalid="this.setCustomValidity('Please enter a subject code.')" oninput="setCustomValidity('')" required>
									</div>
                                	<span id="user-availability-status1"></span>
                                </div>
								<div class="form-group mb-2">
									<label class="form-control-label mb-0">Descriptive Title </label>
                                  	<div class="input-group input-group-merge input-group-alternative">
                                    	<input type="text" class="form-control" id="description" name="description" placeholder="Enter descriptive title" title="Enter descriptive title"  oninvalid="this.setCustomValidity('Please enter a descriptive title.')" oninput="setCustomValidity('')" required>
									</div>
                                </div>
								<div class="form-group mb-2">
									<label class="form-control-label mb-0">Descriptive Title </label>
                                  	<div class="input-group input-group-merge input-group-alternative">
									  	<select  class="form-control" id="program" name="program" placeholder="Enter program" title="Enter  program"  oninvalid="this.setCustomValidity('Please enter program.')" oninput="setCustomValidity('')" required>
											<option value=''>Select Program</option>
											<?php
												try{
													$query2="SELECT * FROM `program`";
													$stmt2 = $con->prepare($query2);
													$stmt2->execute();
													$result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
												}catch(Exception $e){
															$_SESSION['error']='Something went wrong accessing program.';
												}
													foreach ($result2 as $row2) {
													echo"<option value=".$row2['id'].">".$row2['name']."</option>";
												}
											?>
										</select>
									</div>
                                </div>
								<div class="row">
									<div class="col">
										<div class="form-group mb-2">
											<label class="form-control-label mb-0">Year Level </label>
											<div class="input-group input-group-merge input-group-alternative">
												<select  class="form-control" id="level" name="level" placeholder="Enter level" title="Enter  level"  oninvalid="this.setCustomValidity('Please enter year level.')" oninput="setCustomValidity('')" required>
													<option value=''>Select Year Level</option>
													<option value='1'> 1st Year</option>
													<option value='2'> 2nd Year</option>
													<option value='3'> 3rd Year</option>
													<option value='4'> 4th Year</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col">
										<div class="form-group mb-2">
											<label class="form-control-label mb-0">Term </label>
											<div class="input-group input-group-merge input-group-alternative">
												<select class="form-control" id="term" name="term" placeholder="Enter term" title="Enter term"  oninvalid="this.setCustomValidity('Please enter term.')" oninput="setCustomValidity('')" required>
													<option value=''>Select Term</option>
													<option value='1'>1st Semester</option>
													<option value='2'>2nd Semester</option>
													<option value='3'>Summer</opti	on>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<div class="form-group mb-2">
											<label class="form-control-label mb-0">Lab Unit </label>
											<div class="input-group input-group-merge input-group-alternative">
												<input type="number" class="form-control" id="lab" name="lab" placeholder="Enter unit" title="Enter  unit"  oninvalid="this.setCustomValidity('Please enter a labaratory unit.')" oninput="setCustomValidity('')" required>
											</div>
										</div>
									</div>
									<div class="col">
										<div class="form-group mb-2">
											<label class="form-control-label mb-0">Lec Unit </label>
											<div class="input-group input-group-merge input-group-alternative">
												<input type="number" class="form-control" id="lec" name="lec" placeholder="Enter  unit" title="Enter unit"  oninvalid="this.setCustomValidity('Please enter a lecture unit.')" oninput="setCustomValidity('')" required>
											</div>
										</div>
									</div>
									<div class="col">
										<div class="form-group mb-2">
											<label class="form-control-label mb-0">Hours</label>
											<div class="input-group input-group-merge input-group-alternative">
												<input type="number" class="form-control" id="hours" name="hours" placeholder="Enter hourse per session " title="Enter hours"  oninvalid="this.setCustomValidity('Please enter a hours.')" oninput="setCustomValidity('')" required>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group mb-2">
									<label class="form-control-label mb-0">Pre-requisite</label>
                                  	<div class="input-group input-group-merge input-group-alternative">
                                    	<select class="form-control" id="prerequisite" name="prerequisite" placeholder="Enter prerequisite" title="Enter prerequisite"  oninvalid="this.setCustomV	ustomValidity('')" required>
										<option vlaue=''>Select Prerequisite</option>
										<option vlaue='0'>None</option>
										<?php
											try{
												$query1="SELECT * FROM `course`";
												$stmt1 = $con->prepare($query1);
												$stmt1->execute();
												$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
											}catch(Exception $e){
												$_SESSION['error']='Something went wrong accessing course.';
											}
												foreach ($result1 as $row1) {
												echo"<option value=".$row1['id'].">".$row1['subject_code']."</option>";
											}
										?>
										</select>
									</div>
                                </div>
                                <div class="text-center">
                                  <button type="submit" id="add" name="add" class="btn btn-primary my-2 mb-0 sp-add">Save</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div> 
			<div class="container-fluid mt--6">
				  <div class="row">
					<div class="col">
					<div class="card">
					<div class="card-header border-0">
					  <div class="row">
						<div class="col-6">
						  <h3 class="mb-0">Course</h3>
						</div>
						<div class="col-6 text-right">
						  <a type="button" data-toggle="modal" data-target="#modal-form" class="btn btn-sm btn-primary btn-round btn-icon" style="color:white;">
							<span class="btn-inner--icon"><i class="fas fa-plus" style="color:white;"></i></span>
							<span class="btn-inner--text" style="color:white;"> New</span>
						  </a>
						</div>
					  </div>
					</div>
					<div class="table-responsive">
              			<table class="table align-items-center table-flush table-striped" id="tableCourse">
                			<thead class="thead-light">
								<tr>
									<th>Subject Code</th>
									<th>Descriptive Title</th>
									<th>Program </th>
									<th>Total Unit</th>
									<th>Hour(s)</th>
									<th>Prerequisite</th>
								</tr>
							</thead>
							<tfoot class="tfoot-light">
								<tr>
									<th>Subject Code</th>
									<th>Descriptive Title</th>
									<th>Program </th>
									<th>Total Unit</th>
									<th>Hour(s)</th>
									<th>Prerequisite</th>
								</tr>
							</tfoot>
							<tbody>
								<tr>
									<td>Subject Code</td>
									<td>Description</td>
									<td>Program & Year Level</td>
									<td>Unit(s)</td>
									<td>Hour(s)</td>
									<td>Prerequisite</td>
								</tr>
							</tbody>
						</table>
						</div>
					</div>
				</div>
			</div>
			<?php	include("include/footer.php"); ?>
			<script type="text/javascript">
					$(document).ready(function() {
					  var table = $('#tableCourse').DataTable({
						"processing": true,
						"serverSide": true,
						"pagingType": "full_numbers",
						"ajax": "scripts/data_course.php",
						"order": [
						  [2, "desc"]
						],
						"language": {
						  "lengthMenu": "Showing _MENU_ data per page",
						  "zeroRecords": "Sorry, the data you are looking for was not found.",
						  "info": "Show page _PAGE_ no _PAGES_ page",
						  "infoEmpty": "No data available.",
						  "infoFiltered": "(Wanted from the total _MAX_ data)",
						  "paginate": {
							"previous": "<i class='fas fa-angle-left'></i>",
							"next": "<i class='fas fa-angle-right'></i>",
							"first": "<i class='fas fa-angle-double-left'></i>",
							"last": "<i class='fas fa-angle-double-right'></i>"
						  }
						},

						/*"columnDefs": [
						  {
							"targets": -2,
							"data": 3,

							render: function(data, type, row) {
							  moment.locale('');
							  var data_date = data;
							  var change = moment(data_date, "YYYY-MM-DD h:mm:ss").format('DD-MM-YYYY h:mm:ss');
							  return change;
							}
						  }
						]*/
					  });

					});
			</script>
        </div>
      </div>
	</body>
</html>
