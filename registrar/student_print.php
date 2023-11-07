<?php
    error_reporting(0);
	session_start();
	include("include/session.php");
	include("../include/function.php");
    
	$parentpage = "Student";
	$parentpage_link = "student.php";
	$currentpage = "Student Information";
	$page=$childpage = "pending";
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
    <style>
        @media print {
                         thead { display: table-header-group; }
                         tfoot { display: table-footer-group;
                                }
                                
                     }
        @page {
            margin: 25px;
            size: auto;
            
        }
         @media screen {
             thead { display: block; }
             tfoot { display: block;
                   }
         }
    </style>
        <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
            <title>PhilSCA Online Grade Management</title>
        </head>
        <!-- Main content -->
        <body onload="window.print()">
            <div class="main-content" >
                <div class="container-fluid mt--6" style="">
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
                                <style>
                                    table tr td{
                                        padding:5px 5px;

                                    }
                                </style>
                                <table class="" 
                                    style="
                                    /width:900px;
                                    heigth:100%;
                                    padding:5px 5px;
                                    margin:0 auto;

                                    ">
                                    <tr>
                                        <td rowspan="5" style="text-align:right;">
                                            <img src="img/favicon.png" alt="requirement" class="img-fluid application-requirement" style="width:50px;height:50px;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td colspan="4"  style="text-align:center;">
                                        PHILLIPINE STAT COLLEGE OF AERONAUTICS
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"  style="text-align:center;font-weight:bolder;color:rgb(34,63,128);">
                                        MACTAN CAMPUS
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"  style="text-align:center; font-size:10px; ">
                                            Brig Gen Benito Ebuen Air Base, Lapu-Lapu City | philscamactanregistrar@gmail.com
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="text-align:center; ">
                                            <hr>
                                            <label> STUDENT INFORMATION</label>
                                            <hr>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan="6" colspan="2" style="">
                                                <img src="img/<?php echo $application_data['picture'];?>" alt="requirement" class="img-fluid application-requirement" style="width:150px;height:150px; border:1px solid grey;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-control-label" for="">Name:</label>
                                        </td>
                                        <td  colspan="2">
                                            <label class="form-control-label text-muted" for="">
                                                <?php echo $application_data['firstname'].' '.$application_data['middlename'].' '.$application_data['lastname'];?>
                                            </label>
                                        </td>
                                    <tr>
                                        <td>
                                            <label class="form-control-label" for="">Student No:</label>
                                        </td>
                                        <td colspan="2">
                                            <label class="form-control-label text-muted" for="">
                                                <?php 
                                                echo ''.$application_data['idno'];
                                                ?>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-control-label" for="">Program:</label>
                                        </td>
                                        <td  colspan="2">
                                            <label class="form-control-label" for="">
                                                <?php 
                                                $get_idno=getrecord('program',['id'],[$application_data['program_id']]);
                                                echo ''.$get_idno['name'];
                                                ?></label>
                                        </td>                  
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-control-label" for="">Year Level:</label>
                                        </td>
                                        <td  colspan="2">
                                            <label class="form-control-label" for="">
                                                <?php 
                                                    if($application_data['level']=='1'){
                                                        echo "1st Year";
                                                    }
                                                    else if($application_data['level']=='2'){
                                                        echo "2nd Year";
                                                    }
                                                    else if($application_data['level']=='3'){
                                                        echo "3rd Year";
                                                    }
                                                    else if($application_data['level']=='4'){
                                                        echo "4th Year";
                                                    }
                                                    else{
                                                        echo "Error";
                                                    }
                                                    
                                                ?>
                                             </label>
                                        </td>                  
                                    </tr>
                                <tr >
                                    <td colspan="6 " style="text-align:center;padding:5px">
                                        <hr>
                                        <label class="">Personal information</label>
                                    </td>
                                </tr>
                                <tr> 
                                    <td >
                                        <label class="form-control-label" for="">Email:</label>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" >
                                            <?php echo $application_data['username'];?>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="form-control-label" for="">Permanent Address:</label>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" >
                                            <?php echo $application_data['permanent_address'];?>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-control-label" for="">Mobile No.:</label>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                            <?php echo $application_data['contact_no'];?>
                                        </label>
                                    </td>

                                    <td>
                                        <label class="form-control-label" for="">Zip Code:</label>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                            <?php echo $application_data['zipcode'];?>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>  
                                        <label class="form-control-label" for="">Date of Birth:</label>
                                    </td> 
                                    <td colspan="2"> 
                                        <label class="form-control-label text-muted" for="">
                                            <?php echo $application_data['birthdate'];?>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="form-control-label" for="">School Name:</label>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                            <?php echo $application_data['school_name'];?>
                                        </label>
                                    </td>
                                </tr> 
                                <tr>
                                    <td>
                                        <label class="form-control-label" for="">Place of Birth:</label><br>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                                <?php echo $application_data['birthplace'];?>
                                        </label>
                                    </td>
                                    <td >
                                        <label class="form-control-label" for="">School Address:</label>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                            <?php echo $application_data['school_address'];?>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-control-label" for="">Sex:</label><br>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                             <?php echo $application_data['gender'];?>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="form-control-label" for="">School Type:</label>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                                <?php echo $application_data['school_type'];?>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-control-label" for="">Civil Status:</label>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                            <?php echo $application_data['civil_status'];?>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="form-control-label" for="">Highest Grade/Year:</label>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                                <?php echo $application_data['educational_attainement'];?>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-control-label" for="">Citizenship:</label><br>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                            <?php echo $application_data['citizenship'];?>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="form-control-label" for="">Type of disability(if applicatlbe):</label><br>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                            <?php
                                                $disability =($application_data['disability']=='')?'None':$application_data['disability'];
                                                echo $disability;
                                            ?>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" style="text-align:center;padding:5px 5px;">
                                        <hr/>
                                        <label class="">Family Background</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-control-label" for="">Father's Vital Status:</label>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                            <?php echo $application_data['father_vital_status'];?>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="form-control-label" for="">Mother's Vital Status:</label>
                                    </td>  
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                            <?php 
                                                $mother_vital_status =($application_data['mother_vital_status']=='')?'None':$application_data['mother_vital_status'];
                                                echo $mother_vital_status;
                                            ?>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-control-label" for="">Father's Name:</label>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                                <?php
                                                $father_name =($application_data['father_name']=='')?'None':$application_data['father_name'];
                                                echo $father_name;?>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="form-control-label" for="">Mother's Name:</label>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                            <?php
                                                $mother_name =($application_data['mother_name']=='')?'None':$application_data['mother_name'];
                                                echo $mother_name;
                                            ?>
                                        </label>
                                    </td>
                               </tr>
                               <tr>
                                    <td>
                                        <label class="form-control-label" for="">Address:</label>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                            <?php
                                                $father_address =($application_data['father_address']=='')?'None':$application_data['father_address'];
                                                echo $father_address;
                                            ?>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="form-control-label" for="">Address:</label>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                            <?php
                                                $mother_address =($application_data['mother_address']=='')?'None':$application_data['mother_address'];
                                                echo $mother_address;
                                            ?>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-control-label" for="">Occupation:</label>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                            <?php 
                                                $father_occupation =($application_data['father_occupation']=='')?'None':$application_data['father_occupation'];
                                                echo $father_occupation;
                                            ?>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="form-control-label" for="">Mother Occupation:</label>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                            <?php 
                                                $mother_occupation =($application_data['mother_occupation']=='')?'None':$application_data['mother_occupation'];
                                                echo $mother_occupation;
                                            ?>
                                        </label>
                                    </td>         
                                <tr>
                                    <td>
                                        <label class="form-control-label" for="">Educational Attainment:</label><br>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                            <?php
                                                $father_educationalAtt =($application_data['father_educationalAtt']=='')?'None':$application_data['father_educationalAtt'];
                                                echo $father_educationalAtt;
                                            ?>
                                        </label>
                                    </td>
                                    <td>
                                        <label >Mother's Edducational Attainment:</label>
                                    </td>
                                    <td colspan="2">
                                        <label>
                                            <?php
                                                $mother_educationalAtt =($application_data['mother_educationalAtt']=='')?'None':$application_data['mother_educationalAtt'];
                                                echo $mother_educationalAtt;
                                            ?>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-control-label" for="">Parent's Gross Income Classification:</label><br>
                                    </td>
                                    <td colspan="2">
                                        <label class="form-control-label text-muted" for="">
                                            <?php 
                                                 $gross_income =($application_data['gross_income']=='')?'None':$application_data['gross_income'];
                                                echo $gross_income;
                                            ?>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td colspan="2">
                                    </td>
                                    <td style="text-align:right;">
                                        <label class="form-control-label"> Signature</label>
                                    </td>
                                    <td colspan="2">
                                    
                                        <img src="img/<?php echo $application_data['signature'];?>" alt="signature" class="img-fluid application-requirement" style="width:150px;height:50px;">
                                        
                                </tr> 
                            </table>       
                </div>
            </div>
        </body>
    </html>
