<?php
	error_reporting(0);
	session_start();
	include("include/session.php");
	$parentpage='';
	$parentpage_link='';
	$page=$currentpage='Class';
	include("include/header.php");
	//validate faculty user
	if ($user['position_id']!='2'){
        echo  "
            <script>
                window.location.href='403.php';
            </script>
        ";
        exit();
	}

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
					  <li class="breadcrumb-item active" aria-current="page">Class</li>
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
                              <div class="text-center text-muted mb-4">
                                <small class="form-control-label">Add New Class</small>
                              </div>
                              <form role="form" method="post" action="class_controller.php">
								<?php
									$period=getrecord('period',['status'],['1']);
								?>
							  	<input class="form-control"  name="period" id="period" type="hidden" value="<?php echo ''.$period['id'];?>" required>
									
							  	<div class="form-group mb-2">
									<label class="form-control-label mb-0">Class Code</label>
                                  	<div class="input-group input-group-merge input-group-alternative">
										<input class="form-control"  name="class_code" id="class_code" placeholder="Enter class code" type="text" oninvalid="this.setCustomValidity('Please enter a class code.')" oninput="setCustomValidity('')" required>
									</div>
                                	<span id="user-availability-status1"></span>
                                </div>

								<div class="form-group mb-2">
									<label class="form-control-label mb-0">Program </label>
                                  	<div class="input-group input-group-merge input-group-alternative">
                                    	<select class="form-control" id="program" name="program" placeholder="Enter program" title="Enter program"  oninvalid="this.setCustomValidity('Please enter a program.')" oninput="setCustomValidity('')" required>
										<option value=''>Select Program</option>
										<?php
											try{
												$query="SELECT * FROM `program`";
												$stmt = $con->prepare($query);
														$stmt->execute();
														$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
											}catch(Exception $e){
												$_SESSION['error']='Something went wrong accessing program.';
											}
											foreach ($result as $row) {
												echo"<option value=".$row['id'].">".$row['name']."</option>";
											}
										?>
										</select>
									</div>
                                </div>

								<div class="form-group mb-2">
									<label class="form-control-label mb-0">Level </label>
                                  	<div class="input-group input-group-merge input-group-alternative">
                                    	<select class="form-control" id="level" name="level" placeholder="Enter level" title="Enter level"  oninvalid="this.setCustomValidity('Please enter a level.')" oninput="setCustomValidity('')" required>
										<option>Select Year Level</option>
										<option value="1">1st Year</option>
										<option value="2">2nd Year</option>
										<option value="3">3rd Year</option>
										<option value="4">4th Year</option>
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
						  <h3 class="mb-0">Class</h3>
						</div>
						<div class="col-6 text-right">
							<?php 
								if($user['position_id']=='2'){
							?>
								<a type="button" data-toggle="modal" data-target="#modal-form" class="btn btn-sm btn-primary btn-round btn-icon" style="color:white;">
									<span class="btn-inner--icon"><i class="fas fa-plus" style="color:white;"></i></span>
									<span class="btn-inner--text" style="color:white;"> New</span>
								</a>
						  	<?php
								} 
						  	?>
						</div>
					  </div>
					</div>
					<div class="table-responsive">
              			<table class="table align-items-center table-flush table-striped" id="datatable-buttons">
                			<thead class="thead-light">
						  <tr>
						  	<th>No.</th>
							<th>Class Code</th>
							<th>Program</th>
							<th>Year Level</th>
							<th>Academec Year&Term</th>
							<th>Date Created</th>
							<th>Options</th>
						  </tr>
						</thead>
						<tbody>
							<?php
							try{
								$cnt=0;
								$sql = "SELECT *,`class`.`id` AS `class_id`,
								`program`.`name` AS `program_name`,
								`program`.`id` AS `program_id`,
								`period`.`id` AS `period_id`,
								`period`.`year` AS `period_year`,
								`period`.`term` AS `period_term`
								FROM `class`
								INNER JOIN `program` ON `program`.`id` = `class`.`program_id`
								INNER JOIN `period` ON `period`.`id` = `class`.`period_id`
								WHERE `program`.`institute_id`='".$user['institute_id']."'
								";
								$query = $con->query($sql);
								while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
									$cnt++;
							?>
						  <tr>
						  	<td class="text-muted"><?php echo ''.$cnt;?></td>
							<td class="table-user">
								<b>
								<?php 
								$name = isset($row['class_code']) ? htmlspecialchars(short_text($row['class_code']), ENT_QUOTES, 'UTF-8') : '';
								echo $name;
								?>
							  </b>
							</td>
							<td>
								<span class="text-muted">
									<?php 
										$description = isset($row['program_name']) ? htmlspecialchars(short_text($row['program_name']), ENT_QUOTES, 'UTF-8') : '';
										echo $description;
									?>
								</span>
							</td>
							<td>
								<span class="text-muted">
									<?php 
										if($row['level']=='1'){
											echo "1st Year";
										}
										else if($row['level']=='2'){
											echo "2nd Year";
										}
										else if($row['level']=='3'){
											echo "3rd Year";
										}
										else if($row['level']=='4'){
											echo "4th Year";
										}
									?>
								</span>
							</td>
							<td>
								<span class="text-muted">
									<?php 
										$year = isset($row['period_year']) ? htmlspecialchars(short_text($row['period_year']), ENT_QUOTES, 'UTF-8') : '';
										if($row['period_term']=='1'){
											$term='1st Semester';
										}
										else if($row['period_term']=='2'){
											$term='2nd Semester';
										}
										else if($row['period_term']=='3'){
											$term='Summer';
										}
										echo $year.' '.$term;
									?>
								</span>
							</td>
							
							<td>
							  <span class="text-muted">
								<?php
							  		$created_on = isset($row['created_on']) ? htmlspecialchars(created_on($row['created_on']), ENT_QUOTES, 'UTF-8') : '';
							  		echo $created_on;
							  	?>
							  </span>
							</td>

							<td class="text-right">
								<?php
									if($user['position_id']=='2'){
								?>
							  <div class="dropdown">
								<a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								  <i class="fas fa-ellipsis-v"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow"> 
									<?php
										if($row['isSet']=='1'){
										?>
											<a class="dropdown-item" href="class_student.php?id=<?php echo $row['class_id']?>"><i class="ni ni-bullet-list-67" style=""></i> Add Student</a>	
										<?php
										}
										?>
											<a class="dropdown-item" href="class_schedule.php?id=<?php echo $row['class_id']?>"><i class="ni ni-bullet-list-67" style=""></i> Set Schedule</a>	
											
										
									<a class="dropdown-item" data-id="<?php echo $row['class_id'] ?>" style="color: black;" type="button" data-toggle="modal" data-target="#modal-edit-form<?php echo $row['class_id']; ?>"><i class="fas fa-pen" style="color:#172b4d;" ></i> Edit </a>
									<a class="dropdown-item" href="class_controller.php?id=<?php echo $row['class_id']?>&del=delete" onClick="return confirm('Are you sure you want to clear the class, <?php echo htmlspecialchars($row['class_code']);?> ?')"><i class="fas fa-trash" style="color:#f5365c;"></i> Delete</a>	
								</div>
							  </div>
							  <?php
									} else if($user['position_id']=='3'){
										echo '<button type="button" onclick="'."location.href='course_view.php'".'" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View</button>';
									}
							  ?>
							</td>
						  </tr>

						  <div class="col-md-4">
							<div class="modal fade" id="modal-edit-form<?php echo $row['class_id'];?>" tabindex="-1" role="dialog" aria-labelledby="modal-edit-form" aria-hidden="true">
								<div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
									<div class="modal-content">
										<div class="modal-body p-0">
											<div class="card bg-secondary border-0 mb-0">
												<div class="card-body px-lg-5 py-lg-5">
													<div class="text-center text-muted mb-4">
														<small>Edit Class</small>
													</div>
													<form role="form" method="post" action="class_controller.php">

														<input id="edit_id" name="edit_id" class="id form-control" value="<?php echo $row['class_id']?>"  type="hidden" required>
														<?php
															$edit_period=getrecord('period',['status'],['1']);
														?>
														<input class="form-control"  name="edit_id" id="edit_id" type="hidden" value="<?php echo ''.$row['class_id'];?>" required>
														<input class="form-control"  name="edit_period" id="edit_period" type="hidden" value="<?php echo ''.$edit_period['id'];?>" required>
														<div class="form-group mb-2">
															<label class="form-control-label mb-0">Class Code</label>
															<div class="input-group input-group-merge input-group-alternative">
																<input value="<?php echo $row['class_code']; ?>" class="form-control"  name="edit_class_code" id="edit_class_code" placeholder="Enter class code" type="text" oninvalid="this.setCustomValidity('Please enter a class code.')" oninput="setCustomValidity('')" required>
															</div>
															<span id="user-availability-status1"></span>
														</div>

														<div class="form-group mb-2">
															<label class="form-control-label mb-0">Program </label>
															<div class="input-group input-group-merge input-group-alternative">
																<select class="form-control" id="edit_program" name="edit_program" placeholder="Enter program" title="Enter program"  oninvalid="this.setCustomValidity('Please enter a program.')" oninput="setCustomValidity('')" required>
																<?php echo"<option value='".$row['program_id']."'>".$row['program_name']."</option>";?>
																<?php
																	try{
																		$query1="SELECT * FROM `program`";
																		$stmt1 = $con->prepare($query1);
																				$stmt1->execute();
																				$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
																	}catch(Exception $e){
																		$_SESSION['error']='Something went wrong accessing program.';
																	}
																	foreach ($result1 as $row1) {
																		echo"<option value=".$row1['id'].">".$row1['name']."</option>";
																	}
																?>
																</select>
															</div>
														</div>

														<div class="form-group mb-2">
															<label class="form-control-label mb-0">Level </label>
															<div class="input-group input-group-merge input-group-alternative">
																<select class="form-control" id="edit_level" name="edit_level" placeholder="Enter level" title="Enter level"  oninvalid="this.setCustomValidity('Please enter a level.')" oninput="setCustomValidity('')" required>
																<?php 

																if($row['level']=='1'){
																	$edit_level='1st Year';
																}
																else if($row['level']=='2'){
																	$edit_level='2nd Year';
																}
																else if($row['level']=='3'){
																	$edit_level='3rd Year';
																}
																else if($row['level']=='4'){
																	$edit_level='4th Year';
																}

																echo"<option value='".$row['level']."'>".$edit_level."</option>";?>
																<option value="1">1st Year</option>
																<option value="2">2nd Year</option>
																<option value="3">3rd Year</option>
																<option value="4">4th Year</option>
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
				var sp_description=document.getElementById("description").value.trim();
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
