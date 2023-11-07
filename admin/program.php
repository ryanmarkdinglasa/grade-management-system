<?php
	error_reporting(0);
	session_start();
	include("include/session.php");
	$parentpage='';
	$parentpage_link='';
	$page=$currentpage='Program';
	$content_right='<a type="button" data-toggle="modal" data-target="#modal-form" class="btn btn-round btn-icon bg-green text-primary" >
						<span class="btn-inner--icon text-primary font-weight-bolder"><i class="fas fa-plus"></i></span>
						<span class="btn-inner--text text-primary font-weight-bolder"> New</span>
					</a>';
	include("include/header.php");
	?>
	</head>
	<?php include("include/sidebar.php"); ?>
	<!-- Main content -->
	<div class="main-content" id="panel">
		<?php
			include("include/topnav.php");
			include("include/snackbar.php");
			include("include/breadcrumbs.php");
		?> <!-- Batas Header & Breadcrumbs -->
			<div class="col-md-4">
				<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                      <div class="modal-content">
                        <div class="modal-body p-0">
                          <div class="card bg-blue border-0 mb-0">
                            <div class="card-body px-lg-5 py-lg-5">
                              <div class="text-center text-white font-weight-bolder form-control-label mb-4">
                                <span>Add New Program</span>
                              </div>
                              <form role="form" method="post" action="program_controller.php">
                              
							  	<div class="form-group mb-2">
									<label class="form-control-label mb-0 text-white">Program Name</label>
                                  	<div class="input-group input-group-merge input-group-alternative">
                                    	<div class="input-group-prepend">
                                      		<span class="input-group-text"></span>
                                    	</div>
										<input class="form-control"  name="name" id="name" placeholder="Enter program name" type="text" oninvalid="this.setCustomValidity('Please enter a program name.')" oninput="setCustomValidity('')" required>
									</div>
                                	<span id="user-availability-status1"></span>
                                </div>

                                <div class="form-group mb-2">
									<label class="form-control-label mb-0 text-white">Description </label>
                                  	<div class="input-group input-group-merge input-group-alternative">
                                    	<div class="input-group-prepend">
                                      		<span class="input-group-text"></span>
                                    	</div>
                                    	<input class="form-control" id="description" name="description" placeholder="Enter description" title="Enter description"  oninvalid="this.setCustomValidity('Please enter a description.')" oninput="setCustomValidity('')" required>
										
									</div>
                                </div>

								<div class="form-group mb-2">
									<label class="form-control-label mb-0 text-white">Institute </label>
                                  	<div class="input-group input-group-merge input-group-alternative">
                                    	<div class="input-group-prepend">
                                      		<span class="input-group-text"></span>
                                    	</div>
                                    	<select class="form-control" id="institute" name="institute" placeholder="Enter institute" title="Enter institute"  oninvalid="this.setCustomValidity('Please enter a institute.')" oninput="setCustomValidity('')" required>
										<option>Select Institute</option>
										<?php
											try{
												$query="SELECT * FROM `institute`";
												$stmt = $con->prepare($query);
														$stmt->execute();
														$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
											}catch(Exception $e){
												$_SESSION['error']='Something went wrong accessing institute.';
											}
											foreach ($result as $row) {
												echo"<option value=".$row['id'].">".$row['name']."</option>";
											}
										?>
										</select>
									</div>
                                </div>

                                <div class="text-right">
									<button type="reset" id="cancel-button" class="btn btn-primary my-4 sp-add bg-secondary text-primary font-weight-bolder" >Cancel</button>
									<button type="submit" id="add" name="add" class="btn btn-primary my-4 sp-add bg-green text-primary font-weight-bolder" >Save</button>
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
						  <h3 class="mb-0 text-primary font-weight-bolder">Program</h3>
						</div>
						<div class="col-6 text-right">
						</div>
					  </div>
					</div>
					<div class="table-responsive">
              			<table class="table align-items-center table-flush table-striped" id="datatable-buttons">
                			<thead class="thead-light">
								<tr>
									<th>No.</th>
									<th>Name</th>
									<th colspan='2'>Description</th>
									<th>Institute</th>
									<th>Date Created</th>
									<th>Options</th>
								</tr>
							</thead>
						<tbody>
							<?php
							try{

								$sql = "SELECT *,
								`program`.`id` AS `program_id`,
								`program`.`name` AS `program_name`,
								`program`.`description` AS `program_description`,
								`institute`.`name` AS `institute_name`
								FROM `program`
								INNER JOIN `institute` ON `institute`.`id` = `program`.`institute_id`
								";
								$query = $con->query($sql);
								$cnt = 0;
								while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
									$cnt++;
							?>
						  <tr>
							
						  	<td class="text-muted"><?php echo ''.$cnt;?></td>
							<td class="table-user">
								<b>
								<?php 
								$name = isset($row['program_name']) ? htmlspecialchars(short_text($row['program_name']), ENT_QUOTES, 'UTF-8') : '';
								echo $name;
								?>
							  </b>
							</td>
							<td colspan='2'>
							  <span class="text-primary">
							  	<?php 
									$description = isset($row['program_description']) ? htmlspecialchars(short_text($row['program_description']), ENT_QUOTES, 'UTF-8') : '';
									echo $description;
								?>
							 </span>
							</td>
							<td>
							<span class="text-primary">
							  	<?php 
									$institute = isset($row['institute_name']) ? htmlspecialchars(short_text($row['institute_name']), ENT_QUOTES, 'UTF-8') : '';
									echo $institute;
								?>
							 </span>
							</td>
							<td>
							  <span class="text-muted"><?php
							  $created_on = isset($row['created_on']) ? htmlspecialchars(created_on($row['created_on']), ENT_QUOTES, 'UTF-8') : '';
							 
							  ?> <label title="<?php echo formatDate($created_on); ?>"> <?php echo $created_on; ?></label>
							  </span>
							  
							</td>
							<td class="text-right">
							  <div class="dropdown">
								<a class="btn btn-sm btn-icon-only bg-light rounded-circle shadow text-primary" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fas fa-ellipsis-v"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow"> 
									<a class="dropdown-item" data-id="<?php echo $row['program_id'] ?>" style="color: black;" type="button" data-toggle="modal" data-target="#modal-edit-form<?php echo $row['program_id']; ?>"><i class="fas fa-pen text-primary"  ></i> Edit </a>
									<a class="dropdown-item" href="program_controller.php?id=<?php echo $row['program_id']?>&del=delete" onClick="return confirm('Are you sure you want to clear the program, <?php echo htmlspecialchars($row['name']);?> ?')"><i class="fas fa-trash text-primary" ></i> Delete</a>	
								</div>
							  </div>
							</td>
						  </tr>

						  	<div class="col-md-4">
								<div class="modal fade" id="modal-edit-form<?php echo $row['program_id'];?>" tabindex="-1" role="dialog" aria-labelledby="modal-edit-form" aria-hidden="true">
									<div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
										<div class="modal-content">
											<div class="modal-body p-0">
												<div class="card bg-blue border-0 mb-0">
													<div class="card-body px-lg-5 py-lg-5">
														<div class="text-center text-white font-weight-bolder form-control-label mb-4">
															<span>Edit Program</span>
														</div>
														<form role="form" method="post" action="program_controller.php">

															<input id="edit_id" name="edit_id" class="id form-control" value="<?php echo $row['program_id']?>"  type="hidden" required>
															<div class="form-group mb-2">
																<label class="form-control-label mb-0 text-white">Program Name</label>
																<div class="input-group input-group-merge input-group-alternative">
																	<input  value="<?php echo htmlspecialchars($row['program_name']);?>" class="form-control"  name="edit_name" id="edit_name" placeholder="Enter program name" type="text" oninvalid="this.setCustomValidity('Please enter a program name.')" oninput="setCustomValidity('')" required>
																</div>
																<span id="user-availability-status1"></span>
															</div>

															<div class="form-group mb-2">
																<label class="form-control-label mb-0 text-white">Description </label>
																<div class="input-group input-group-merge input-group-alternative">
																	<input value="<?php echo htmlspecialchars($row['program_description']);?>" class="form-control" id="edit_description" name="edit_description" placeholder="Enter description" title="Enter description"  oninvalid="this.setCustomValidity('Please enter a description.')" oninput="setCustomValidity('')" required>
																</div>
															</div>

															<div class="form-group mb-2">
																<label class="form-control-label mb-0 text-white">Institute </label>
																<div class="input-group input-group-merge input-group-alternative">
																	<select class="form-control" id="edit_institute" name="edit_institute" placeholder="Enter institute" title="Enter institute"  oninvalid="this.setCustomValidity('Please enter an institute.')" oninput="setCustomValidity('')" required>
																	<option value=''>Select Institute</option>
																	<?php
																		try{
																			$query1="SELECT * FROM `institute`";
																			$stmt1 = $con->prepare($query1);
																					$stmt1->execute();
																					$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
																		}catch(Exception $e){
																			$_SESSION['error']='Something went wrong accessing institute.';
																		}
																		foreach ($result1 as $row1) {
																			echo"<option value=".$row1['id'].">".$row1['name']."</option>";
																		}
																	
																	?>
																	</select>
																</div>
															</div>

															<div class="text-right">
																<button type="reset" id="cancel-button<?php echo $row['program_id'];?>" class="btn btn-primary my-4 sp-add bg-secondary text-primary font-weight-bolder" >Cancel</button>
																<button type="submit" id="edit-program" name="edit-program" class="btn btn-primary my-4 bg-green text-primary font-weight-bolder">Save</button>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<script>
									document.addEventListener("DOMContentLoaded", function () {
										// Get a reference to the cancel button
										var cancelButton = document.getElementById("cancel-button<?php echo $row['program_id'];?>");

										// Get a reference to the modal
										var modal = document.getElementById("modal-edit-form<?php echo $row['program_id'];?>");

										// Add a click event listener to the cancel button
										cancelButton.addEventListener("click", function () {
											// Use Bootstrap's modal function to close the modal
											$(modal).modal("hide");
										});
									});
								</script>
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
		<?php	include("include/footer.php"); ?>
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
