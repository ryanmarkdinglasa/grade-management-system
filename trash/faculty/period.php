<?php
	error_reporting(0);
	session_start();
	include("include/session.php");
	include("include/header.php");

	$parentpage='';
	$parentpage_link='';
	$page=$currentpage='Period';
	
	?>
	<script>
		if ( window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href );
		}
	</script>
	</head>
	<?php
		include("include/sidebar.php");
	?>
	<!-- Main content -->
	<div class="main-content" id="panel">
		<?php
		include("include/topnav.php"); //Edit topnav on this page
		?>
		<?php if(isset($_SESSION['success'])){ ?>
			<div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
			  <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
			  <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Success!</span>
				<span data-notify="message"><?php echo $_SESSION['success'];?></span>
			  </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
				<span aria-hidden="true">×</span></button>
			</div>
			<?php }  unset($_SESSION['success']); ?>

			<?php if(isset($_SESSION['error'])){ ?>
			<div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
			  <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
			  <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Fail!</span>
				<span data-notify="message"><?php echo $_SESSION['error'];?></span>
			  </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
				<span aria-hidden="true">×</span></button>
			</div>
			<?php }  unset($_SESSION['error']); ?>
    <!-- Header -->
    <!-- Header & Breadcrumbs -->
		<div class="header bg-primary pb-6">
		  <div class="container-fluid">
			<div class="header-body">
			  <div class="row align-items-center py-4">
				<div class="col-lg-6 col-7">
				  <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
					<ol class="breadcrumb breadcrumb-links breadcrumb-dark">
					<li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
					  <li class="breadcrumb-item"><a href="./">Dashboard</a></li>
					  <li class="breadcrumb-item active" aria-current="page">Academic Year</li>
					</ol>
				  </nav>
				</div>
				<div class="col-lg-6 col-5 text-right">
				</div>
			  </div>
			</div>
		  </div>
		</div>
    <!-- Batas Header & Breadcrumbs -->
			
			<div class="col-md-4">
				<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                      <div class="modal-content">
                        <div class="modal-body p-0">
                          <div class="card bg-secondary border-0 mb-0">
                            <div class="card-body px-lg-5 py-lg-5">
                              <div class="text-center form-control-label mb-4">
                                <small>Add New Academic Year</small>
                              </div>
                              <form role="form" method="post" action="period_controller.php">
                              
							  	<div class="form-group mb-2">
									<label class="form-control-label mb-0">Year</label>
                                  	<div class="input-group input-group-merge input-group-alternative">
										<input class="form-control" data-provide="datepicker" data-date-format="yyyy" data-date-start-view="years" data-date-min-view-mode="years" name="year" id="year" placeholder="Select Year" type="text">
									</div>
                                </div>

                                <div class="form-group mb-2">
									<label class="form-control-label mb-0">Term </label>
                                  	<div class="input-group input-group-merge input-group-alternative">
                                    	<select class="form-control" id="term" name="term"  title="Enter Term"  oninvalid="this.setCustomValidity('Please enter a semester.')" oninput="setCustomValidity('')" required>
											<option class="form-control"> Select Term</option>
											<option value="1"> 1st Semester </option>
											<option value="2"> 2nd Semester </option>
											<option value="3"> Summer </option>
										</select>
									</div>
                                </div>
								
                                <div class="text-center">
                                  <button type="submit" id="add" name="add" class="btn btn-primary my-4 sp-add">Save</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div> 
			
			
			<!-- Page content -->
			<div class="container-fluid mt--6">
				  <div class="row">
					<div class="col">
					<div class="card">
					<div class="card-header border-0">
					  <div class="row">
						<div class="col-6">
						  <h3 class="mb-0">Academic Year</h3>
						</div>
						<div class="col-6 text-right">
						  <a type="button" data-toggle="modal" data-target="#modal-form" class="btn btn-sm btn-primary btn-round btn-icon" style="color:white;">
							<span class="btn-inner--icon"><i class="fas fa-plus" style="color:white;"></i></span>
							<span class="btn-inner--text" style="color:white;"> New</span>
						  </a>
						   <!--<a type="button"  data-id="1" class="btn btn-sm btn-primary btn-round btn-icon edit" style="color:white;">
							<span class="btn-inner--icon"><i class="fas fa-user-plus" style="color:white;"></i></span>
							<span class="btn-inner--text" style="color:white;"> Edit</span>
						  </a>-->
			
						</div>
					  </div>
					</div>
					<div class="table-responsive">
              			<table class="table align-items-center table-flush table-striped" id="datatable-buttons">
                			<thead class="thead-light">
						  <tr>
							<th>Academic Year</th>
							<th>Academic Term</th>
							<th>Status</th>
							<th>Date Created</th>
							<th>Options</th>
						  </tr>
						</thead>
						<tbody>
							<?php
							try{
								$sql = "SELECT * FROM `period`";
								$query = $con->query($sql);
								$cnt = 1;
								while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
							?>
						  <tr>
							<td class="table-user">
								<b>
								<?php 
								$name = isset($row['year']) ? htmlspecialchars(short_text($row['year']), ENT_QUOTES, 'UTF-8') : '';
								echo $name;
								?>
							  </b>
							</td>
							<td>
							  <span class="text-muted"><?php
							  if($row['term']=='1'){
								echo '1st Semester';
							  }
							  else if($row['term']=='2'){
								echo '2nd Semester';
							  }
							  else if($row['term']=='3'){
								echo 'Summer';
							  }
							  ?></span>
							</td>
							<td>
							<?php $status = $row['status'];
								if ($status >0) {
								echo '<span class="badge badge-success">Active</span>';
								} else {
								echo '<span class="badge badge-danger">Inactive</span>';
								}
								?>
							</td>
							<td>
							  <span class="text-muted"><?php
							  $created_on = isset($row['created_on']) ? htmlspecialchars(created_on($row['created_on']), ENT_QUOTES, 'UTF-8') : '';
							  echo $created_on;
							  ?></span>
							</td>
							<td class="text-right">
							  <div class="dropdown">
								<a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								  <i class="fas fa-ellipsis-v"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow"> 
									<?php $status = $row['status'];
										if ($status >0):
									?>
										<a class="dropdown-item" href="period_controller.php?id=<?php echo $row['id'] ?>&off=0"><i class="fas fa-times" style="color:#fb6340;"></i> Deactivate</span></a>
									<?php	else : ?>
										<a class="dropdown-item" href="period_controller.php?id=<?php echo $row['id'] ?>&on=1"><i class="fas fa-check" style="color:#2dce89;"></i> Activate</a>
									<?php 	endif; ?>
									<a class="dropdown-item" href="period_controller.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to clear the academic year, <?php echo htmlentities($row['year']);?> ?')"><i class="fas fa-trash" style="color:#f5365c;"></i> Delete</a>	
								</div>
							  </div>
							</td>
						  </tr>
						  <div class="col-md-4">
							<div class="modal fade" id="modal-edit-form<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="modal-edit-form" aria-hidden="true">
								<div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
								<div class="modal-content">
									<div class="modal-body p-0">
									<div class="card bg-secondary border-0 mb-0">
										<div class="card-body px-lg-5 py-lg-5">
										<div class="text-center text-muted mb-4">
											<small>Edit Academic Year</small>
										</div>
										<form role="form" method="post" action="period_controller.php">
											
											<div class="form-group mb-3">
												<label class="text-muted">Academic Year</label>
												<div class="input-group input-group-merge input-group-alternative">
													<div class="input-group-prepend">
														<span class="input-group-text"></span>
													</div>
													<input id="edit_id" name="edit_id" class="id form-control" value="<?php echo $row['id']?>"  type="hidden" title="Enter Institute Name"  oninvalid="this.setCustomValidity('Please enter the new Scholarship Program Name.')" oninput="setCustomValidity('')" required>
													<input id="edit_year" name="edit_year" class="form-control" value="<?php echo $row['year']?>" type="text" title="Enter Academic Year"  oninvalid="this.setCustomValidity('Please enter the new Academic Year.')" oninput="setCustomValidity('')" required>
												</div>
												<span id="user-availability-status1"></span>
											</div>

											<div class="form-group mb-2">
												<label class="text-muted mb-0">Semester </label>
												<div class="input-group input-group-merge input-group-alternative">
													<div class="input-group-prepend">
														<span class="input-group-text"></span>
													</div>
													<select class="form-control" id="semester" name="semester" placeholder="Enter" title="Enter Semester"  oninvalid="this.setCustomValidity('Please enter a semester.')" oninput="setCustomValidity('')" required>
														<option class="form-control"> Select Term</option>
														<option value="1"> 1st Semester </option>
														<option value="2"> 2nd Semester </option>
														<option value="3"> Summer </option>
													</select>
												</div>
											</div>

											<div class="text-center">
											<button type="submit" id="edit-program" name="edit-program" class="btn btn-primary my-4">Save</button>
											</div>
										</form>
										</div>
									</div>
									</div>
								</div>
								</div>
							</div>
						</div> 
						  <?php  } //while
							}catch(Exception $e){
								$_SESSION['error']='Something went wrong in accessing scholarship program data.';
							}?>
						</tbody>
					  </table>
					</div>
				</div>
			</div>
		</div>
	<?php
		include("include/footer.php"); //Edit topnav on this page
    ?>
	
	<script type="text/javascript">
	$(function(){
	   $(document).on('click', '.edit', function(e){
		e.preventDefault();
		$('#modal-edit-form').modal('show');
		var id = $(this).data('id');
		//document.getElementById('edit_name').value='bogog-mama';
		getRow(id);
	  });
	});
	function getRow(id){
	  $.ajax({
		type: 'POST',
		url: 'institute_row.php',
		data: {id:id},
		dataType: 'json',
		success: function(response){
		  $('.edit_id').val(response.id);
		  $('#edit_name').val(response.name);
		  $('#edit_description').val(response.description);
		}
	  });
	}
	</script>
	<script type="text/javascript">
	
		document.getElementById("close_direct").onclick = function () {
			location.href = "institute.php";
		};
	</script>
	<script type="text/javascript">
		$(document).on("click", ".add",function(){
				var lettersRegex = /^[a-zA-Z\s]+$/;
				var numbersRegex = /^[0-9]+$/;
				var specialCharactersRegex = /^[a-zA-Z0-9\s]*$/;
				var sp_name=document.getElementById("name").value.trim();
				if (sp_name==='') {
					$("#name").css({ 
						"border" :"1px solid red",
					});
					$("#name").fadeIn("slow");
					$("#name").focus();
				   return false;
				}
				if (!lettersRegex.test(sp_name)) {
					 $("#name").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#name").fadeIn("slow");
					$("#name").focus();
				   return false;
				}
				var sp_description=document.getElementById("sp_description").value.trim();
				if (sp_description==='') {
					$("#description").css({ 
						"border" :"1px solid red",
					});
					$("#description").fadeIn("slow");
					$("#description").focus();
				   return false;
				}
				if (!lettersRegex.test(sp_description)) {
					 $("#sdescription").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#description").fadeIn("slow");
					$("#description").focus();
				   return false;
				}
		});
	</script>


        </div>
      </div>

</body>

</html>
