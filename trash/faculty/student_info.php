<?php
    error_reporting(0);
	session_start();
	include("include/session.php");
    include("include/header.php");

	$parentpage = "Student";
	$parentpage_link = "student.php";
	$currentpage = "Student Information";
	$page=$childpage = "Student";

    date_default_timezone_set('Asia/Manila'); // change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());
    if(!isset($_GET['id'])){
        echo    "
            <script>
                window.location.href='404.php';
            </script>
        ";
        exit();
	}
    $id = intval($_GET['id']);
    $check_student=getrecord('student',['id'],[$_GET['id']]);
    if(empty($check_student['username'])){
        echo    "
            <script>
                window.location.href='404.php';
            </script>
        ";
        exit();
    }
?>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <style>
        .select2-selection__rendered {
            font-size: .875rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 35px;
            top: 50%;
            transform: translateY(-50%);
            right: 0.01px;
            width: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            background-image: url(https://cdn4.iconfinder.com/data/icons/user-interface-174/32/UIF-76-512.png);
            background-color: transparent;
            background-size: contain;
            border: none !important;
            height: 20px !important;
            width: 20px !important;
            margin: auto !important;
            top: auto !important;
            left: auto !important;
        }
    </style>

    </head>
    <?php
    include("include/sidebar.php");
    ?>
    <!-- Main content -->
    <div class="main-content" id="panel">
        <?php
        include("include/topnav.php"); //Edit topnav on this page
        ?>
        <!-- Header -->
        <!-- Header & Breadcrumbs -->
        <?php include "include/breadcrumbs.php";?>
        <!-- Batas Header & Breadcrumbs -->
        <!-- Page content -->
        <div class="container-fluid mt--6">
            <div class="card mb-4">
                <!-- Card header -->
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <!-- Title -->
                            <h3 class="mb-0">Student Information</h3>
                        </div>
                        <div class="col-4 text-right mb-0">
                            <form>
                                    <a href="student_print.php?id=<?php echo $_GET['id'];?>" target="_blank" id="approve" name="approve" class="btn btn-icon btn-primary text-white my-4"  type="button">
                                            <svg style="fill:white;" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg></span>
                                            Print
                                    </a>
                            </form>
                            <!--<code class="text-default"><mark class="text-default"></mark></code>-->
                        </div>
                    </div>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <!-- Form groups used in grid -->         
                            
                            <form role="form" method="post">
                                <h6 class="heading-small text-muted mb-4">Personal information</h6>
                                   
                                <?php
                               $sql = "SELECT * FROM `student` WHERE `username` = '".$check_student['username']."' LIMIT 1";
                               $stmt2 = $con->prepare($sql);
                               $stmt2->execute();
                               $application_data = $stmt2->fetch(PDO::FETCH_ASSOC);
                               
                               // Check if there is any data returned from the database
                               if (!$application_data) {
                                   // No data found
                                   $_SESSION['error'] = "No data found for the specified ID.";
                                  
                                   exit();
                               }
                               
                               // Access the fetched data by key
                                ?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Full Name:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php echo $application_data['firstname'].' '.$application_data['middlename'].' '.$application_data['lastname'];?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Email:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php echo $application_data['username'];?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Mobile No.:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php echo $application_data['contact_no'];?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Date of Birth:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php echo $application_data['birthdate'];?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Place of Birth:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php echo $application_data['birthplace'];?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Sex:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php echo $application_data['gender'];?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Civil Status:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php echo $application_data['civil_status'];?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Citizenship:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php echo $application_data['citizenship'];?></label>
                                        </div>
                                     </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Permanent Address:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php echo $application_data['permanent_address'];?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Zip Code:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php echo $application_data['zipcode'];?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">School Name:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php echo $application_data['school_name'];?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">School Address:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php echo $application_data['school_address'];?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">School Type:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php echo $application_data['school_type'];?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Highest Grade/Year:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php echo $application_data['educational_attainement'];?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Type of disability(if applicatlbe):</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php
                                                $disability =($application_data['disability']=='')?'None':$application_data['disability'];
                                                echo $disability;?></label>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4" />
    
                                <h6 class="heading-small text-muted mb-4">Family Background</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Father Vital Status:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php echo $application_data['father_vital_status'];?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Father's Name:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php
                                                $father_name =($application_data['father_name']=='')?'None':$application_data['father_name'];
                                                echo $father_name;?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Father's Address:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php
                                                $father_address =($application_data['father_address']=='')?'None':$application_data['father_address'];
                                                echo $father_address;?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Father Occupation:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php 
                                                 $father_occupation =($application_data['father_occupation']=='')?'None':$application_data['father_occupation'];
                                                echo $father_occupation;
                                                ?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Father's Name:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php
                                                $father_educationalAtt =($application_data['father_educationalAtt']=='')?'None':$application_data['father_educationalAtt'];
                                                echo $father_educationalAtt;?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Mother Vital Status:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php 
                                                 $mother_vital_status =($application_data['mother_vital_status']=='')?'None':$application_data['mother_vital_status'];
                                                echo $mother_vital_status;
                                                ?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Mother's Name:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php
                                                $mother_name =($application_data['mother_name']=='')?'None':$application_data['mother_name'];
                                                echo $mother_name;?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Mother's Address:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php
                                                $mother_address =($application_data['mother_address']=='')?'None':$application_data['mother_address'];
                                                echo $mother_address;?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Mother Occupation:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php 
                                                 $mother_occupation =($application_data['mother_occupation']=='')?'None':$application_data['mother_occupation'];
                                                echo $mother_occupation;
                                                ?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Mother's Edducational Attainment:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php
                                                $mother_educationalAtt =($application_data['mother_educationalAtt']=='')?'None':$application_data['mother_educationalAtt'];
                                                echo $mother_educationalAtt;?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Parent's Gross Income Classification:</label><br>
                                            <label class="form-control-label text-muted" for="">
                                                <?php 
                                                 $gross_income =($application_data['gross_income']=='')?'None':$application_data['gross_income'];
                                                echo $gross_income;
                                                ?></label>
                                        </div>
                                    </div>
                                    
                                </div>
                                <hr class="my-4" />
                                <h6 class="heading-small text-muted mb-4">Requirements</h6>
                                <style>
                                    .media:hover{
                                        opacity:0.7;
                                    }
                                </style>
                                <div class="form-group" style="width:500px;height:700px;">
                                    <div class="container">
                                        <div class="row py-2">
                                            <label class="form-control-label"> 2x2 Picture</label>
                                            <div class="col-md-12 media">
                                                <a href="../registrar/img/<?php echo $application_data['picture'];?>" target="_blank" data-toggle="lightbox" data-gallery="gallery" data-max-width="100%" data-max-height="100%">
                                                <img src="../registrar/img/<?php echo $application_data['picture'];?>" alt="requirement" class="img-fluid application-requirement" style="width:200px;height:200px; border:1px solid grey;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                               
                                    <div class="container">
                                        <div class="row py-2">
                                            <label class="form-control-label"> Signature</label>
                                            <div class="col-md-12 media">
                                                <a href="../registrar/img/<?php echo $application_data['signature'];?>" target="_blank" data-toggle="lightbox" data-gallery="gallery" data-max-width="100%" data-max-height="100%">
                                                <img src="../registrar/img/<?php echo $application_data['signature'];?>" alt="requirement" class="img-fluid application-requirement" style="width:200px;height:200px; border:1px solid grey;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                </div>
            </div>
        </div>




        <?php
        include("include/footer.php"); //Edit topnav on this page
        ?>
        <script>
            function toggle_select(id) {
                var X = document.getElementById(id);
                if (X.checked == true) {
                    X.value = "1";
                } else {
                    X.value = "0";
                }
                //var sql="update clients set calendar='" + X.value + "' where cli_ID='" + X.id + "' limit 1";
                var who = X.id;
                var chk = X.value
                //alert("Joe is still debugging: (function incomplete/database record was not updated)\n"+ sql);
                $.ajax({
                    //this was the confusing part...did not know how to pass the data to the script
                    url: 'as_status_penyeleksi.php',
                    type: 'post',
                    data: 'who=' + who + '&chk=' + chk,
                    success: function(output) {
                        alert('success, server says ' + output);
                    },
                    error: function() {
                        alert('something went wrong, save failed');
                    }
                });
            }
        </script>
        <script type="text/javascript">
            document.getElementById("close_direct").onclick = function() {
                location.href = "application_pending.php";
            };
        </script>
        <script>
            $('.select2').select2();
        </script>
        <script src="js/fakultas-prodi.js?v=1"></script>

    </div>
    </div>

    </body>

    </html>
