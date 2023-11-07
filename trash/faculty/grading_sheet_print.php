<?php
    error_reporting(0);
	session_start();
	include("include/session.php");
	include("../include/function.php");
   
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
    if(!isset($_GET['period'])){
        echo    "
            <script>
                window.location.href='404.php';
            </script>
        ";
        exit();
	}
    $_SESSION['period']=$_GET['period'];
    $_SESSION['schedule']=$_GET['id'];
    $period_id=(empty($_GET['period']) || $_GET['period']==NULL)?'0':($_POST['period']);

    $schedule_id=(empty($_GET['id']) || $_GET['id']==NULL)?'0':($_GET['id']);
    ?>
    <style>
        @media print {
                         thead { display: table-header-group; }
                         tfoot { display: table-footer-group; }
                        button { display: none; }
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
         .btn{
            width:100px;
            height:40px;
            background:rgba(34,63,128);
            color:#FFF;
            border-radius:10px;
            border:none;
            font-weight:bolder;
            float:right;
            cursor:pointer;
            position:absolute;
            margin:100px 80%;
         }
         .btn:hover{
            background:rgba(28,60,120);
            color:#FFF;
            /margin-top:-2px;
            opacity:0.7;
            transition:0.3s;
         }
         .uppercase-text {
            text-transform: uppercase;
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
        
        <body onload=" window.print();">
            <script>
                function printPage() {
                window.print();
                }
            </script>
            
            <div class="main-content" >
                <div class="container-fluid mt--6" style="">
                    <button type="button" class="btn btn-primary"onclick="printPage()">Print</button>
                    <?php
                        // Access the fetched data by key
                       

                        $get_period=getrecord('period',['id'],[$_SESSION['period']]);
                        $get_period=($get_period==false)?'':$get_period;
                        $term=(empty($get_period['term']) || ($get_period['term']==NULL))?'':$get_period['term'];
                        $term = (empty($term) )? '' : (($term == '1') ? '1st Semester' : (($term == '2') ? '2nd Semester' : 'Summer'));
                        $year=(empty($get_period['year']) || ($get_period['year']==NULL))?'':$get_period['year'];


                        $get_course_sql="SELECT * FROM schedule 
                            INNER JOIN `course` ON `course`.`id`=`schedule`.`course_id`
                        WHERE `schedule`.`id`='".$schedule_id."'";
                        $get_course_stmt=$con->prepare( $get_course_sql);
                        $get_course_stmt->execute();
                        $get_course=$get_course_stmt->fetch(PDO::FETCH_ASSOC);
                   ?>
                                <style>
                                    table tr td{
                                        padding:5px 5px;

                                    }
                                    .table tr td {
                                        border:1px solid grey;
                                    }
                                </style>
                                <table  style="
                                    /width:900px;
                                    heigth:100%;
                                    padding:5px 5px;
                                    margin:0 auto;
                                
                                    ">
                                <tr>
                                        <td rowspan="5" style="text-align:right;">
                                            <img src="../img/favicon.png" alt="requirement" class="img-fluid application-requirement" style="width:50px;height:50px;">
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
                                           <span> Brig Gen Benito Ebuen Air Base, Lapu-Lapu City | philscamactanregistrar@gmail.com</span>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="text-align:center; ">
                                            <label> </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="text-align:center; ">
                                            <label>GRADING SHEET</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="text-align:center; ">
                                            <label>
                                                <b>
                                                    <u>
                                                        <?php 
                                                            echo htmlspecialchars($term, ENT_QUOTES, 'UTF-8');
                                                        ?>
                                                    </u>
                                                </b>
                                                / Academic Year: 
                                                <b>
                                                    <u>
                                                        <?php 
                                                            echo htmlspecialchars($year, ENT_QUOTES, 'UTF-8');
                                                        ?>
                                                    </u>
                                                </b>
                                            </label>
                                        </td>
                                    </tr>
                                </table>
                                
                                <table  class="myTable"
                                    style="
                                    width:900px;
                                    heigth:100%;
                                    padding:5px 5px;
                                    margin:0 auto;
                                    
                                    ">
                                    <tr>
                                        <td>
                                            <label colspan="" class="form-control-label text-muted" for=""></label>
                                        </td>
                                        <td  colspan="3">
                                            <label class="form-control-label text-muted" for="">Course No.
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                                                <?php 
                                                     $course_code=(empty($get_course['subject_code']) || $get_course['subject_code']==NULL)?'':($get_course['subject_code']);
                                                     echo htmlspecialchars($course_code, ENT_QUOTES, 'UTF-8');
                                                ?>
                                            </label>
                                        </td>
                               
                                        <td  colspan="">
                                            <label class="form-control-label text-muted" for=""></label>
                                        </td>
                                        <td  colspan="" style="text-align:right;">
                                            <label class="form-control-label " for="">Days:</label>
                                        </td>
                                        <td  colspan="" >
                                            <label class="form-control-label " for="">
                                                <?php
                                                    $days=(empty($get_course['days']) || $get_course['days']==NULL)?'':($get_course['days']);
                                                     echo htmlspecialchars($days, ENT_QUOTES, 'UTF-8');
                                                ?>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label colspan="" class="form-control-label text-muted" for=""></label>
                                        </td>
                                        <td  colspan="3">
                                            <label class="form-control-label text-muted" for="">Descriptions :
                                                <?php
                                                    $description=(empty($get_course['description']) || $get_course['description']==NULL)?'':($get_course['description']);
                                                     echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
                                                ?>
                                            </label>
                                        </td>
                               
                                        <td  colspan="">
                                            <label class="form-control-label text-muted" for=""></label>
                                        </td>
                                        <td  colspan="" style="text-align:right;">
                                            <label class="form-control-label " for="">Time:</label>
                                        </td>
                                        <td  colspan="" >
                                            <label class="form-control-label " for="">
                                                <?php
                                                    $time=(empty($get_course['time']) || $get_course['time']==NULL)?'':($get_course['time']);
                                                    echo htmlspecialchars($time, ENT_QUOTES, 'UTF-8');
                                                ?>
                                            </label>
                                        </td>
                                    </tr>  
                                    <tr >
                                        <td>
                                            <label colspan="" class="form-control-label text-muted" for=""></label>
                                        </td>
                                        <td  colspan="3">
                                            <label class="form-control-label text-muted" for=""> 
                                                 UNITS
                                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 
                                                <?php
                                                    $unit=(empty($get_course['unit']) || $get_course['unit']==NULL)?'':($get_course['unit']);
                                                    echo htmlspecialchars($unit, ENT_QUOTES, 'UTF-8');
                                                ?>
                                            </label>
                                        </td>
                               
                                        <td  colspan="">
                                            <label class="form-control-label text-muted" for=""></label>
                                        </td>
                                        <td  colspan="" style="text-align:right;">
                                            <label class="form-control-label " for="">Room:</label>
                                        </td>
                                        <td  colspan="" >
                                            <label class="form-control-label " for="">
                                                <?php
                                                    $room=(empty($get_course['room']) || $get_course['room']==NULL)?'':($get_course['room']);
                                                    echo htmlspecialchars($room, ENT_QUOTES, 'UTF-8');
                                                ?>
                                            </label>
                                        </td>
                                    </tr>  
                                    </table>
                                    <table class="myTable" border="1" 
                                        style="
                                        width:900px;
                                        border-collapse: collapse;
                                        heigth:100%;
                                        padding:5px 5px;
                                        margin:0 auto;
                                        
                                        ">
                                    <tr style="text-align:center; ">
                                        <td rowspan="2">
                                            <label  class="form-control-label text-muted" for="">No.</label>
                                        </td>
                                        <td  colspan="3" rowspan="2">
                                            <label class="form-control-label text-muted" for="">Name of Students</label>
                                        </td>
                                        <td  colspan="" rowspan="2">
                                            <label class="form-control-label text-muted" for="">Students No.</label>
                                        </td>
                                        <td  colspan="" rowspan="2">
                                            <label class="form-control-label text-muted" for="">Prelim</label>
                                        </td>
                                        <td  colspan="" rowspan="2">
                                            <label class="form-control-label text-muted" for="">Midterm</label>
                                        </td>
                                        <td  colspan="" rowspan="2">
                                            <label class="form-control-label text-muted" for="">Finals</label>
                                        </td>
                                        <td  colspan="2">
                                            <label class="form-control-label text-muted" for="">FINAL</label>
                                        </td>
                                        <td  colspan="" rowspan="2">
                                            <label class="form-control-label text-muted" for="">Remarks</label>
                                        </td>
                                    </tr>
                                    <tr style="text-align:center; ">
                                        <td  colspan="" >
                                            <label class="form-control-label text-muted" for="">GRADE</label>
                                        </td>
                                        <td  colspan="">
                                            <label class="form-control-label text-muted" for="">EQUIVALENT</label>
                                        </td>
                                    
                                    </tr>
                                    <?php
                                        try {       
                                         $sql=" SELECT
                                                    `student`.`idno` AS `student_idno`,
                                                    CONCAT(`student`.`lastname`, ', ', `student`.`firstname`, ' ', LEFT(`student`.`middlename`, 1), '.') AS `student_name`,
                                                    `grade`.`prelim` AS `grade_prelim`,
                                                    `grade`.`midterm` AS `grade_midterm`,
                                                    `grade`.`final` AS `grade_final`,
                                                    ROUND(((`grade`.`prelim` + `grade`.`midterm` + `grade`.`final`) / 3), 2) AS `average_grade`,
                                                    CASE
                                                        WHEN ROUND(((`grade`.`prelim` + `grade`.`midterm` + `grade`.`final`) / 3), 2) BETWEEN 99 AND 100 THEN '1.0'
                                                        WHEN ROUND(((`grade`.`prelim` + `grade`.`midterm` + `grade`.`final`) / 3), 2) BETWEEN 96 AND 98 THEN '1.25'
                                                        WHEN ROUND(((`grade`.`prelim` + `grade`.`midterm` + `grade`.`final`) / 3), 2) BETWEEN 93 AND 95 THEN '1.5'
                                                        WHEN ROUND(((`grade`.`prelim` + `grade`.`midterm` + `grade`.`final`) / 3), 2) BETWEEN 90 AND 92 THEN '1.75'
                                                        WHEN ROUND(((`grade`.`prelim` + `grade`.`midterm` + `grade`.`final`) / 3), 2) BETWEEN 86 AND 89 THEN '2.0'
                                                        WHEN ROUND(((`grade`.`prelim` + `grade`.`midterm` + `grade`.`final`) / 3), 2) BETWEEN 83 AND 85 THEN '2.25'
                                                        WHEN ROUND(((`grade`.`prelim` + `grade`.`midterm` + `grade`.`final`) / 3), 2) BETWEEN 80 AND 82 THEN '2.5'
                                                        WHEN ROUND(((`grade`.`prelim` + `grade`.`midterm` + `grade`.`final`) / 3), 2) BETWEEN 77 AND 79 THEN '2.75'
                                                        WHEN ROUND(((`grade`.`prelim` + `grade`.`midterm` + `grade`.`final`) / 3), 2) BETWEEN 75 AND 76 THEN 'PASSED'
                                                        ELSE '5.0'
                                                    END AS `equivalent`
                                                FROM `participants`
                                                INNER JOIN `student` ON `student`.`id` = `participants`.`student_id`
                                                INNER JOIN `class` ON `class`.`id` = `participants`.`class_id`
                                                INNER JOIN `period` ON `period`.`id` = `class`.`period_id`
                                                INNER JOIN `schedule` ON `schedule`.`class_id` = `class`.`id`
                                                INNER JOIN `course` ON `course`.`id` = `schedule`.`course_id`
                                                LEFT JOIN `grade` ON `grade`.`schedule_id` = `schedule`.`id` 
                                                                AND `grade`.`student_id` = `participants`.`student_id`
                                                WHERE `period`.`id` = :period_id
                                                AND `schedule`.`id` = :schedule_id
                                                AND `grade`.`prelim` IS NOT NULL
                                                AND `grade`.`midterm` IS NOT NULL
                                                AND `grade`.`final` IS NOT NULL
                                                ORDER BY `student`.`lastname` ASC
                                                ";
                                            // Prepare the statement
                                            $stmt = $con->prepare($sql);

                                            // Bind the parameters
                                            $stmt->bindParam(':period_id', $_SESSION['period'], PDO::PARAM_INT);
                                            $stmt->bindParam(':schedule_id',  $_SESSION['schedule'], PDO::PARAM_INT);

                                            // Execute the query
                                            $stmt->execute();

                                            // Fetch the results
                                            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            $cnt=0;
                                             //
                                           
                                            if(empty($results)||$results==NULL){
                                                echo"<td colspan='11' style='text-align:center;color:red;'>No Data Found</td>";
                                            }

                                            foreach ($results as $row) {
                                                // Your code to display the data goes here
                                                $cnt++;
                                            ?>
                                                <tr>
                                                    <td  style="text-align:center"><?php echo $cnt;?></td>
                                                  

                                                    <td  class="text-muted text-center" colspan='3'>
                                                        <?php
                                                            $name=(empty($row['student_name']) || $row['student_name']==NULL)?'':$row['student_name'];
                                                            echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
                                                        ?>		
                                                    </td>

                                                    <td  class="text-muted " style="text-align:center;">
                                                        <?php
                                                            $idno=(empty($row['student_idno']) || $row['student_idno']==NULL)?'':$row['student_idno'];
                                                            echo htmlspecialchars($idno, ENT_QUOTES, 'UTF-8');
                                                        ?>
                                                    </td>

                                                    <td  class="text-muted" style="text-align:center;">
                                                        <?php
                                                            $prelim=(empty($row['grade_prelim']) || $row['grade_prelim']==NULL)?'':$row['grade_prelim'];
                                                            echo htmlspecialchars($prelim, ENT_QUOTES, 'UTF-8');
                                                        ?>	
                                                    </td>
                                                    <td  class="text-muted" style="text-align:center;">
                                                        <?php
                                                            $midterm=(empty($row['grade_midterm']) || $row['grade_midterm']==NULL)?'':$row['grade_midterm'];
                                                            echo htmlspecialchars($midterm, ENT_QUOTES, 'UTF-8');
                                                        ?>	
                                                    </td>
                                                    <td  class="text-muted" style="text-align:center;">
                                                        <?php
                                                            $final=(empty($row['grade_final']) || $row['grade_final']==NULL)?'':$row['grade_final'];
                                                            echo htmlspecialchars($final, ENT_QUOTES, 'UTF-8');
                                                        ?>	
                                                    </td>
                                                    <td  class="text-muted" style="text-align:center;">
                                                        <?php
                                                            $average=(empty($row['average_grade']) || $row['average_grade']==NULL)?'':$row['average_grade'];
                                                            echo htmlspecialchars($average, ENT_QUOTES, 'UTF-8');
                                                        ?>	
                                                    </td>

                                                    <td class="text-muted" style="text-align:center;">
                                                        <?php
                                                            $equivalent=(empty($row['equivalent']) || $row['equivalent']==NULL)?'':$row['equivalent'];
                                                            echo htmlspecialchars($equivalent, ENT_QUOTES, 'UTF-8');
                                                        ?>	
                                                    </td>

                                                    <td class="text-muted" style="text-align:center;">
                                                        <?php
                                                            
                                                            $average=floatval($average);
                                                                if($average>=75 && $average <=100){
                                                                        $remarks="PASSED";
                                                                } else if($average<75 && $average >=50){
                                                                        $remarks="FAILED";
                                                                 }else{
                                                                        $remarks="ERROR";
                                                                    
                                                                 }
                                                            $remarks=(empty($remarks) || $remarks==NULL)?'':$remarks;
                                                            echo htmlspecialchars($remarks, ENT_QUOTES, 'UTF-8');
                                                        ?>	
                                                    </td>
                                                </tr>	
                                            <?php
                                            } //while
                                        }catch(Exception $e){
                                            echo"<td colspan='11' style='text-align:center;color:red;'>No Data Found</td>";
                                            
                                        }
                                   
                                   /* else{
                                       // echo "<script>window.location.href='grade.php'</script>";
                                        echo"<td colspan='11' style='text-align:center;color:red;'>No Data Found</td>";
                                        exit();
                                    }*/
                                        ?> 
                            </table>
                            <br>
                            <table 
                                    style="
                                        width:900px;
                                        border-collapse: collapse;
                                        heigth:100%;
                                        padding:5px 5px;
                                        margin:0 auto;
                                        font-weight:bolder" >
                                  <tr>
                                    <td>
                                        <?php 
                                            $course_code=(empty($get_course['subject_code']) || $get_course['subject_code']==NULL)?'':($get_course['subject_code']);
                                             echo "
                                            
                                                <center>
                                                <p class='uppercase-text'><u>" . htmlspecialchars($course_code, ENT_QUOTES, 'UTF-8') . "</u></p>
                                                <p style='margin-top:-15px;'><small> Subject</small></p>
                                                </center>
                                                ";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        try {
                                            $adviser_sql = "SELECT
                                                            CONCAT(
                                                                `user`.`lastname`, 
                                                                ', ', 
                                                                `user`.`firstname`, 
                                                                CASE 
                                                                    WHEN `user`.`middlename` IS NULL OR TRIM(`user`.`middlename`) = '' THEN ''
                                                                    ELSE CONCAT(' ', LEFT(`user`.`middlename`, 1), '.')
                                                                END
                                                            ) AS `name`
                                                        FROM `schedule`
                                                        INNER JOIN `staff` ON `staff`.`id`=`schedule`.`faculty_id`
                                                        INNER JOIn `user` ON `user`.`username`=`staff`.`username`
                                                        WHERE `schedule`.`id`=:schedule_id
                                                        ORDER BY `user`.`id` DESC LIMIT 1
                                                        ";
                                            $adviser_stmt = $con->prepare($adviser_sql);
                                            $adviser_stmt->bindParam(':schedule_id', $schedule_id, PDO::PARAM_INT);
                                            // Execute the query
                                            $adviser_stmt->execute();
                                            // Fetch the results
                                            $adviser_result = $adviser_stmt->fetch(PDO::FETCH_ASSOC);
                                            if ($adviser_result) {
                                                echo "
                                                <center>
                                                <p class='uppercase-text'><u>" . $adviser_result['name'] . "</u></p>
                                                <p style='margin-top:-15px;'><small> Teacher's Name</small></p>
                                                </center>
                                                ";
                                            } else {
                                                echo "<p style='text-align:center;color:red;'>No Data Found</p>";
                                            }
                                        } catch (Exception $e) {
                                            echo "<p style='text-align:center;color:red;'>Error: " . $e->getMessage() . "</p>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php
                                        try {
                                            $pc_sql = "SELECT
                                                        CONCAT(
                                                            `user`.`lastname`, 
                                                            ', ', 
                                                            `user`.`firstname`, 
                                                            CASE 
                                                                WHEN `user`.`middlename` IS NULL OR TRIM(`user`.`middlename`) = '' THEN ''
                                                                ELSE CONCAT(' ', LEFT(`user`.`middlename`, 1), '.')
                                                            END
                                                        ) AS `name`,
                                                        `position`.`description` AS `staff_position`
                                                    FROM `class`
                                                    INNER JOIN `schedule` ON `schedule`.`class_id`=`class`.`id`
                                                    INNER JOIN `program` ON `program`.`id` = `class`.`program_id`
                                                    INNER JOIN `institute` ON `institute`.`id` = `program`.`institute_id`
                                                    INNER JOIN `staff` ON `staff`.`institute_id` = `program`.`institute_id`
                                                    INNER JOIN `user` ON `user`.`username` = `staff`.`username`
                                                    INNER JOIN `position` ON `position`.`id` = `staff`.`position_id`
                                                    WHERE `schedule`.`id` = :schedule_id
                                                    AND `staff`.`position_id` = '2'
                                                    ORDER BY `user`.`id` DESC LIMIT 1";
                                        
                                            $pc_stmt = $con->prepare($pc_sql);
                                            $pc_stmt->bindParam(':schedule_id', $_SESSION['schedule'], PDO::PARAM_INT);
                                            // Execute the query
                                            $pc_stmt->execute();
                                            // Fetch the results
                                            $pc_result = $pc_stmt->fetch(PDO::FETCH_ASSOC);
                                            if ($pc_result) {
                                                echo "
                                                <br>
                                                <center>
                                                <p class='uppercase-text'><u>" . $pc_result['name'] . "</u></p>
                                                <p style='margin-top:-15px;'><small>" . $pc_result['staff_position'] . "</small></p>
                                                </center>
                                                ";
                                            } else {
                                                echo "<p style='text-align:center;color:red;'>No Data Found</p>";
                                            }
                                        } catch (Exception $e) {
                                            echo "<p style='text-align:center;color:red;'>Error: " . $e->getMessage() . "</p>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                    <?php
                                        try {
                                            $as_sql = "SELECT
                                                        CONCAT(
                                                            `user`.`lastname`, 
                                                            ', ', 
                                                            `user`.`firstname`, 
                                                            CASE 
                                                                WHEN `user`.`middlename` IS NULL OR TRIM(`user`.`middlename`) = '' THEN ''
                                                                ELSE CONCAT(' ', LEFT(`user`.`middlename`, 1), '.')
                                                            END
                                                        ) AS `name`
                                                    FROM `user`
                                                    WHERE `user`.`type` = :type
                                                    ORDER BY `user`.`id` DESC LIMIT 1";
                                            
                                            $as_type = 'admin';
                                            $as_stmt = $con->prepare($as_sql);
                                            $as_stmt->bindParam(':type', $as_type, PDO::PARAM_STR); // Use PDO::PARAM_STR for string parameters
                                            
                                            // Execute the query
                                            $as_stmt->execute();
                                            
                                            // Fetch the results
                                            $as_result = $as_stmt->fetch(PDO::FETCH_ASSOC);
                                            
                                            if ($as_result) {
                                                echo "
                                                <br>
                                                <center>
                                                <p class='uppercase-text'><u>" . $as_result['name'] . "</u></p>
                                                <p style='margin-top:-15px;'><small>Academic Supervisor</small></p>
                                                </center>
                                                ";
                                            } else {
                                                echo "<p style='text-align:center;color:red;'>No Data Found</p>";
                                            }
                                        } catch (Exception $e) {
                                            echo "<p style='text-align:center;color:red;'>Error: " . $e->getMessage() . "</p>";
                                        }
                                        
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        <script>
                                window.onload = function() {
                                var tables = document.getElementsByClassName("myTable");

                                for (var t = 0; t < tables.length; t++) {
                                    var rows = tables[t].getElementsByTagName("tr");

                                    for (var i = 0; i < rows.length; i++) {
                                        var cells = rows[i].getElementsByTagName("td");
                                        
                                        for (var j = 0; j < cells.length; j++) {
                                            var cell = cells[j];
                                            var text = cell.textContent || cell.innerText; // Handle different browser compatibility
                                            
                                            // Convert the text to uppercase and update the cell content
                                            cell.textContent = text.toUpperCase();
                                        }
                                    }
                                }
                            };
                        </script>       
                </div>
            </div>
        </body>
    </html>
