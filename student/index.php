<?php
	session_start();
	error_reporting(E_ALL);
	include("include/session.php");
	include("include/header.php");
	$parentpage = "dashboard";
?>
	<script>
		if (window.history.replaceState) {
		  window.history.replaceState(null, null, window.location.href);
		}
	</script>
	</head>
		<?php	include("include/sidebar.php");	?>
		<!-- ain content -->
		<div class="main-content" id="panel">
			<?php
				include("include/topnav.php");
				include("include/prompt.php");
			?>
			<!-- Header -->
			<div class="header bg-primary pb-6">
			  <div class="container-fluid">
				<div class="header-body">
				  <div class="row align-items-center py-4">
					<div class="col-lg-6 col-7">
					  <h6 class="h2 text-white d-inline-block mb-0">Dashboard</h6>
					  <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
						<ol class="breadcrumb breadcrumb-links breadcrumb-dark">
						  <li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
						  <li class="breadcrumb-item active" aria-current="page">Dashboard
						  </li>
						</ol>
					  </nav>
					</div>
					<div class="col-lg-6 col-5 text-right">
					</div>
				  </div>
				  <!-- Card stats -->
				  <div class="row">
				  </div>
				</div>
			  </div>
			</div>
			<!-- Page content -->
			<div class="container-fluid mt--6">
				<br>
				<div class="row">
					<?php
						try{
							$sql = "SELECT 
								`post`.`id` AS `post_id`,
								`post`.`user_id` AS `post_user`,
								`post`.`title` AS `post_title`,
								`post`.`context` AS `post_context`,
								`post`.`status` AS `post_status`,
								`post`.`created_on` AS `post_on`,
								`user`.`type` AS `user_type`,
								`user`.`profileImage` AS `user_image`,
								`user`.`firstname` AS `user_fname`, `user`.`lastname` AS `user_lname`
								FROM `post` 
								INNER JOIN `user` ON `user`.`id`= `post`.`user_id`
								WHERE `post`.`status`='1' ORDER BY `post_on` DESC";
							$query = $con->query($sql);
							$count=$query->rowCount();
							if($count<1){
					?>
						<div class="col-xl-12">
							<div class="card">
							  <div class="card-header">
								<h6 class="text-black text-uppercase ls-1 mb-1">ANNOUNCEMENT</h6>
								<h5 class="h3 text-uppercase text-primary mb-0"> </h5>
								<span class="text-muted"><?php //echo $row['created_on']; ?></h5>
							  </div>
							  <div class='card-body'>No Data Found
								<?php //echo $row['context']; ?>
							  </div>
							</div>
						</div>
					<?php
						}
						else{
					?>
						<div class="col-xl-12">
							<div class="card">
							  <div class="card-header">
								<h4 class="text-black text-uppercase ls-1 mb-1"><i class="ni ni-notification-70"></i> ANNOUNCEMENT</h4>
								<h5 class="h3 text-uppercase text-primary mb-0"> </h5>
								<span class="text-muted"><?php //echo $row['created_on']; ?></h5>
							  </div>
							  
							</div>
						</div>
					<?php
						}
						while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
							
					?>
					<div class="col-xl-12">
						<div class="card">
						  <div class="card-header">
							<div class="poster">
							<?php $userphoto = $row['user_image'];
								if ($userphoto == "" || $userphoto == "NULL") :
								 echo' <img src="img/profile.png" class="avatar rounded-circle mr-3">';
								else : 
									//echo$row['user_type'];
								   echo'<img src="../'.$row['user_type'].'/img/'.htmlentities($userphoto).'" class="avatar rounded-circle mr-3">';
								endif;
								//Posted By & Posted On
								echo '<h5 class="text-black  mb-0">'.$row['user_fname'].' '.$row['user_lname'].'<br>';
								echo'<span class="text-muted""><small>';
								$post_created=''.$row['post_on'];
								echo $row['user_type'].' | '.created_on($post_created);
								echo'</small></span></h5>';
								?>
								<?php
								if($user['id']==$row['post_user']){
								?>
								<div class="text-right" style="margin-top:-30px;">
									<div class="dropdown">
									  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fas fa-ellipsis-v"></i>
									  </a>
									  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<a class="dropdown-item" href="announcement_edit.php?id=<?php echo $row['post_id'] ?>&edit=edit" style="color: black;" type="button"><i class="fas fa-pen" style="color:#172b4d;"></i> Edit post</a>
										<a class="dropdown-item" href="announcement_controller.php?id=<?php echo $row['post_id'] ?>&del=delete" onClick="return confirm('Are you sure you want to clear, <?php echo htmlentities($row['post_title']); ?> ?')"><i class="fas fa-trash" style="color:#f5365c;"></i> Delete post</a>
									  </div>
									</div>
								</div>
								<?php }?>
							</div>
						  </div>
						  <div class='card-body'>
							<h5 class="h3 text-uppercase text-primary mb-0"><?php echo $row['post_title']; ?></h5>
							<?php echo $row['post_context']; ?>
						  </div>
						</div>
					</div>
					<?php	
						}//while
					}catch(Exception $e){
						$_SESSION['error']='Something went wrong in accessing annoouncement post.';
					}
					?>
				</div>
				<?php
					include("include/footer.php"); //Edit topnav on this page
				?>
			</div>
		</div>
	</body>
</html>