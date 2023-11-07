<?php
	error_reporting(0);
	session_start();
	include("include/session.php");
	$parentpage='school_record';
	$parentpage_link='';
	$page=$currentpage=$childpage='Institute';
	$content_right='';
	include("../include/conn.php");
	include("../include/function.php");
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
				include("include/topnav.php");
				include("include/snackbar.php");
				include("include/breadcrumbs.php");
			?>
			<!-- Page content -->
			<div class="container-fluid mt--6">
				  <div class="row">
					<div class="col">
					<div class="card">
					<div class="card-header border-0">
					  <div class="row">
						<div class="col-6">
						  <h3 class="mb-0">Insitutes</h3>
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
									<th>Institute Name</th>
									<th>Description</th>
									<th>Date Created</th>
								</tr>
							</thead>
							<tfoot class="tfoot-light">
								<tr>
									<th>No.</th>
									<th>Institute Name</th>
									<th>Description</th>
									<th>Date Created</th>
								</tr>
							</tfoot>
						<tbody>
							<?php
							try{
								$sql = "SELECT * FROM `institute`";
								$query = $con->query($sql);
								$cnt = 0;
								while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
									$cnt++;
							?>
						  <tr>
						  <td class="text-muted">
								<b>
									<?php 
										echo htmlspecialchars($cnt, ENT_QUOTES, 'UTF-8');
									?>
							  	</b>
							</td>
							<td class="table-user">
								<b>
									<?php 
										$name = isset($row['name']) ? htmlspecialchars(short_text($row['name']), ENT_QUOTES, 'UTF-8') : '';
										echo $name;
									?>
							  	</b>
							</td>
							<td>
							  	<span class="text-muted">
									<?php
										$description = isset($row['description']) ? htmlspecialchars(short_text($row['description']), ENT_QUOTES, 'UTF-8') : '';
										echo $description;
									?>
								</span>
							</td>
							<td>
							  <span class="text-muted">
							  	<?php
							  		$created_on = isset($row['created_on']) ? htmlspecialchars(created_on($row['created_on']), ENT_QUOTES, 'UTF-8') : '';
							  	?> 
							  	<label title="<?php echo formatDate($created_on); ?>"> <?php echo $created_on; ?></label>
							  </span>
							</td>
						  </tr>
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
        </div>
      </div>
	</body>
</html>
