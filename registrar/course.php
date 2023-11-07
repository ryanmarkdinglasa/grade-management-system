<?php
	//error_reporting(0);
	session_start();
	include("include/session.php");
	$parentpage='school_record';
	$parentpage_link='';
	$page=$currentpage=$childpage='Course';
	$content_right='';
	include("../include/conn.php");
	include("../include/function.php");
  	include("include/header.php");
	?>
	</head>
		<?php include("include/sidebar.php");	?>
	<!-- Main content -->
		<div class="main-content" id="panel">
			<?php
				include("include/topnav.php"); //Edit topnav on this page
				include("include/snackbar.php");
				include("include/breadcrumbs.php");
			?>
			
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
						</div>
					  </div>
					</div>
					<div class="table-responsive">
              			<table class="table align-items-center table-flush table-striped" id="datatable-buttons">
                			<thead class="thead-light">
								<tr>
									<th>No.</th>
									<th>Subject Code</th>
									<th>Descriptive Title</th>
									<th>Program </th>
									<th>Total Unit</th>
									<th>Hour(s)</th>
									<th>Prerequisite</th>
								</tr>
							</thead>
						<tbody>
							<?php
							try{
								$cnt=0;
								$sql3 = "SELECT `course`.`id` AS `course_id`,
								`course`.`subject_code`,
								`course`.`unit`,
								`course`.`level`,
								`course`.`term`,
								`course`.`hours`,
								`course`.`prerequisite`,
								`course`.`description` AS `course_description`,
								`program`.`id` AS `program_id`,
								`program`.`description` AS `program_description`,
								`program`.`name` AS `program_name`
								FROM `course`
								INNER JOIN `program` ON `program`.`id`=`course`.`program_id`
								";
								$query3 = $con->query($sql3);
								while ($row3 = $query3->fetch(PDO::FETCH_ASSOC)) {
									$cnt++;
							?>
						  <tr>
						  	<td class="text-primary"><?php echo ''.$cnt;?></td>
							<td class="text-primary">
								<b>
								<?php 
								$name = isset($row3['subject_code']) ? htmlspecialchars(short_text($row3['subject_code']), ENT_QUOTES, 'UTF-8') : '';
								echo $name;
								?>
							  </b>
							</td>
							<td>
								<span class="text-primary">
									<?php 
										$description = isset($row3['course_description']) ? htmlspecialchars(short_text($row3['course_description']), ENT_QUOTES, 'UTF-8') : '';
										echo $description;
									?>
								</span>
							</td>
							<td>
								<span class="text-primary">
									<?php 
										$program_name = isset($row3['program_name']) ? htmlspecialchars(short_text($row3['program_name']), ENT_QUOTES, 'UTF-8') : '';
										echo $program_name.'-'.$row3['level'].''.$row3['term'];
									?>
								</span>
							</td>
							<td>
								<span class="text-primary">
									<?php 
										if($row3['unit']!=0 || empty($row3['unit'])){
											$unit = isset($row3['unit']) ? htmlspecialchars($row3['unit'], ENT_QUOTES, 'UTF-8') : '';
											echo $unit;
										}
										else{
											echo '0';
										}										
									?>
								</span>
							</td>
							<td>
								<span class="text-primary">
									<?php 
										$hours = isset($row3['hours']) ? htmlspecialchars($row3['hours'], ENT_QUOTES, 'UTF-8') : '';
										echo $hours;
									?>
								</span>
							</td>
							<td>
								<span class="text-primary ">
									<?php 
										if ($row3['prerequisite']=='0'){
											echo "None";
										}else{
											$prerequisite=getrecord('course',['id'],[$row3['prerequisite']]);
											echo $prerequisite['subject_code'];
										}
									?>
								</span>
							</td>
						  </tr>
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
		<?php include("include/footer.php"); ?>
        </div>
      </div>
	</body>
</html>