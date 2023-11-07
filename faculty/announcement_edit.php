<?php
	//error_reporting(0);
	session_start();
	include("include/session.php");
	$parentpage=''; $content_right ; $parent_link='';
	$currentpage=$page='announcement';
	include("include/header.php");
	include("../include/conn.php");
	include("../include/function.php");

	if(!isset($_GET['id'])){ 	//SESSION TO EDIT
		echo "<script>window.location.href='404.php';</script>";
		exit();
	}
	$row=$check_id=getrecord('post',['id'],[$_GET['id']]);
	if(empty($check_id)){
		echo "<script>window.location.href='404.php';</script>";
		exit();
	}
?>
    </head>
	<?php include("include/sidebar.php"); ?>
		<!-- Main content -->
		<div class="main-content" id="panel">
			<?php 
				include("include/topnav.php");
				include("include/snackbar.php");
				include("include/breadcrumbs.php");
			?><!-- Batas Header & Breadcrumbs -->
        <!-- Page content -->
			<div class="container-fluid mt--6">
				<div class="card mb-4">
					<!-- Card header -->
					<div class="card-header">
						<h3 class="mb-0 font-weight-bolder text-primary">Edit Announcement</h3>
					</div>
					<!-- Card body -->
					<div class="card-body">
						<!-- Form groups used in grid -->
						<form action="announcement_controller.php"role="form" method="POST">
								<div class="col-md-4">
									<div class="form-group">
										<label class="form-control-label" for="exampleFormControlInput1">Announcement Title</label>
										<input name="post_id" type="hidden" class="form-control"  value="<?php echo$row['id']?>">
										<input name="title" type="text" class="form-control" id="exampleFormControlInput1" value="<?php 
										$title = isset($row['title']) ? htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') : '';
										echo $title?>" placeholder="Announcement Title"required>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-control-label" for="exampleFormControlInput2">Announcement Details</label>
										<textarea class="ckeditor"  name="context" id="exampleFormControlTextarea2" rows="8" resize="none"required> <?php 
										$context = isset($row['context']) ? $row['context'] : '';
										echo $context;?></textarea>
									</div>
									<div class="text-left">
										<button type="submit" id="edit" name="edit" class="btn bg-green text-primary my-2">Post Announcement</button>
									</div>
								</div>
						</form>
					</div>
				</div>
				<?php include("include/footer.php");  ?>
			</div>
		</div>
    </body>
</html>
