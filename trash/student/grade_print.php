<?php
    error_reporting(0);
	session_start();
	include("include/session.php");
	include("../include/function.php");
    
	$parentpage = "Records";
	$parentpage_link = "";
	$currentpage = "Prelim";
	$page=$childpage = "Prelim";
   
    date_default_timezone_set('Asia/Manila'); // change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());
    /*if(!isset($_POST['print'])){
        echo    "
            <script>
                window.location.href='404.php';
            </script>
        ";
        exit();
	}*/
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
                        if(isset($_POST['print'])){    
                        // Access the fetched data by key
                        $period_id=(empty($_POST['period']) || $_POST['period']==NULL)?'2':($_POST['period']);
                        $class_id=(empty($_POST['class']) || $_POST['class']==NULL)?'2':($_POST['class']);
                        $schedule_id=(empty($_POST['course']) || $_POST['course']==NULL)?'9':($_POST['course']);
                        $periodical = (empty($_POST['periodical']) || $_POST['periodical'] == NULL) ? '' : (($_POST['periodical'] == '1') ? 'prelim' : (($_POST['periodical'] == '2') ? 'midterm' : 'final'));
                        
                       /*TEST
                        echo  'period_id:'.$period_id.'\n';
                        echo  'class_id:'.$class_id.'\n';
                        echo  'schedule_id:'.$_POST['course'].'\n';
                        echo  'periodical:'.$periodical.'\n';
                        */

                        $get_period=getrecord('period',['id'],[$period_id]);
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
                                            <label><?php echo htmlspecialchars(strtoupper($periodical), ENT_QUOTES, 'UTF-8');?> PERIODICAL GRADES</label>
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
                                        <td>
                                            <label colspan="" class="form-control-label text-muted" for="">No.</label>
                                        </td>
                                        <td  colspan="3" style="">
                                            <label class="form-control-label text-muted" for="">Name of Students</label>
                                        </td>
                                        <td  colspan="">
                                            <label class="form-control-label text-muted" for="">Students No.</label>
                                        </td>
                                        <td  colspan="">
                                            <label class="form-control-label text-muted" for="">
                                                <?php  
                                                    echo htmlspecialchars($periodical, ENT_QUOTES, 'UTF-8');
                                                ?>
                                            </label>
                                        </td>
                                        <td  colspan="">
                                            <label class="form-control-label text-muted" for="">Remarks</label>
                                        </td>
                                    </tr>
                                    <?php
                                        try {       
                                            $sql=" SELECT`student`.`idno` AS `student_idno`,
                                                    CONCAT(`student`.`lastname`, ', ', `student`.`firstname`, ' ', LEFT(`student`.`middlename`, 1), '.') AS `student_name`,
                                                    `grade`.`".$periodical."` AS `period`,
                                                    CASE
                                                        WHEN `grade`.`".$periodical."` >= 75 THEN 'PASSED'
                                                        WHEN `grade`.`".$periodical."` < 75 THEN 'FAILED'
                                                        WHEN `grade`.`".$periodical."` = 'INC' THEN 'INC'
                                                        WHEN `grade`.`".$periodical."` = 'UD' THEN 'UD'
                                                        WHEN `grade`.`".$periodical."` = 'OD' THEN 'OD'
                                                        ELSE 'Error'
                                                    END AS `remarks`
                                                FROM `participants`
                                                INNER JOIN `student` ON `student`.`id` = `participants`.`student_id`
                                                INNER JOIN `class` ON `class`.`id` = `participants`.`class_id`
                                                INNER JOIN `period` ON `period`.`id`= `class`.`period_id`
                                                INNER JOIN `schedule` ON `schedule`.`class_id` = `class`.`id`
                                                INNER JOIN `course` ON `course`.`id` = `schedule`.`course_id`
                                                LEFT JOIN `grade` ON `grade`.`schedule_id` = `schedule`.`id` 
                                                                AND `grade`.`student_id` = `participants`.`student_id`
                                                WHERE `participants`.`class_id` = '".$class_id ."'
                                                AND `period`.`id`='".$period_id."'
                                                AND `schedule`.`id` = '".$schedule_id."'
                                                AND `grade`.`".$periodical."` IS NOT NULL
                                                ORDER BY `student`.`lastname` ASC";
                                                
                                            //echo $sql;
                                            $query = $con->prepare($sql);
                                            $query->execute();
                                            $cnt = 0;
                                            $rows = $query->fetchAll(PDO::FETCH_ASSOC);
                                           
                                            if(empty($rows)||$rows==NULL){
                                                echo"<td colspan='7' style='text-align:center;color:red;'>No Data Found</td>";
                                            }
                                            foreach ($rows as $row) {
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
                                                            $grade=(empty($row['period']) || $row['period']==NULL)?'':$row['period'];
                                                            echo htmlspecialchars($grade, ENT_QUOTES, 'UTF-8');
                                                        ?>	
                                                    </td>

                                                    <td class="text-muted" style="text-align:center;">
                                                        <?php
                                                            if(is_string($grade)){
                                                                if(strtoupper($grade)=='INC'){
                                                                    $remarks="INC";
                                                                } else if(strtoupper($grade)=='UD'){
                                                                    $remarks="UD";
                                                                } else if(strtoupper($grade)=='OD'){
                                                                    $remarks="OD";
                                                                }else{
                                                                    $grade=floatval($grade);
                                                                    if($grade>=75 && $grade <=100){
                                                                        $remarks="PASSED";
                                                                    } else if($grade<75 && $grade >=50){
                                                                        $remarks="FAILED";
                                                                    }else{
                                                                        $remarks="ERROR";
                                                                    }
                                                                }
                                                            }
                                                            $remarks=(empty($remarks) || $remarks==NULL)?'':$remarks;
                                                            echo htmlspecialchars($remarks, ENT_QUOTES, 'UTF-8');
                                                        ?>	
                                                    </td>
                                                </tr>	
                                            <?php
                                            } //while
                                        }catch(Exception $e){
                                            echo"<td colspan='7' style='text-align:center;color:red;'>No Data Found</td>";
                                            
                                        }
                                    }//if print
                                    else{
                                       // echo "<script>window.location.href='grade.php'</script>";
                                        echo"<td colspan='7' style='text-align:center;color:red;'>No Data Found</td>";
                                        exit();
                                    }
                                        ?> 
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
