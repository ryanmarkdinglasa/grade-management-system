<?php
  error_reporting(0);
	session_start();
	include("include/session.php");
	$parentpage = "";
	$parentpage_link= "#";
	$currentpage='Records';
	$childpage = "Records";
  $content_right='';
	include("../include/conn.php");
	include("../include/function.php");
  include("include/header.php");
?>
    <script>  if (window.history.replaceState)  window.history.replaceState(null, null, window.location.href); </script>
  </head>
  <?php include("include/sidebar.php"); ?>
  <div class="main-content" id="panel">
    <?php
      include("include/topnav.php"); //Edit topnav on this page
      include("include/prompt.php");
      include "include/breadcrumbs.php";
    ?>
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header border-0">
              <div class="row">
                <div class="col-6">
                  <h3 class="mb-0">Records</h3>
                </div>
                <div class="col-6 text-right">
						      <a type="button" href="register.php" class="btn btn-sm btn-primary btn-round btn-icon" style="color:white;">
							      <span class="btn-inner--icon"><i class="fas fa-user-plus" style="color:white;"></i></span>
							      <span class="btn-inner--text" style="color:white;"> New</span>
						      </a>
                </div>
              </div>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-3" style="border:1px solid red;">
                    <label class="form-control-label"> Academic Year & Term</label>
                    <select class="form-control">
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include("include/footer.php"); ?>
    </div>
  </div>
  </body>
</html>
