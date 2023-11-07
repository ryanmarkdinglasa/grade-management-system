<?php
  error_reporting(0);
	session_start();
	include("include/session.php");
	include("../include/function.php");
	$parentpage = "Records";
	$parentpage_link = "";
	$currentpage = "TOR";
	$page=$childpage = "TOR";
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
         table{
          border-collapse:collapse;
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
                       
                    ?>
                    <div class="card" style="">
            <!-- Card header -->
            <div class="card-header border-0">
              <div class="row">
                <div class="col-6">
                  <h3 class="mb-0"></h3>
                </div>
                
              </div>
            </div>
            <!-- Light table -->
            <?php

            ?>
            <style>
              table tr td span{
                font-size:12px;
                text-align:left;
                
              }

              .top-table tr td{
               /width:15%;
              }
              table{
                width:100%;
                /color:#000;
              }
              .tor{
                /background:url("../assets/img/brand/favicon.png");
                /background-repeat: no-repeat;
                /background-size: auto;
              }
              .table-header tr td{
                /margin-top:-10px;
                /border:1px solid red;
                padding:0 0;
                height:10px;
              }
              .top-table{
                margin-top:-20px;
              }
              .top-table tr td{
                margin-top:-10px;
                /border:1px solid red;
                padding:0 0;
                /border:collapse;
              }
              #grading-system tr td,#grading-system th{
                
                padding:0px 0px;
                top:0px;
              }
              #grading-system tr td small{
                
                padding:0px 0px;
                margin-top:-10px;
              }
              .table-footer tr td{
                width:20%;
                text-align:center;
                font-size:15px;
              }
              .space{
                width:90px
              }
              .data-table{
                /border:1px solid black;
              }
            </style>
            <div class="table-responsive">
              <div class="card-body tor" >
                  
                  <img scr="../assets/img/brand/favicon.png" width="100%">
                  
                  <table  style=" text-align:center;" class=" table-header  text-center  text-black;">
                  <tr>
                    <td colspan="4">
                     <label > Republic of the Philippines</label>
                    </td>
                  </th>
                  <tr>
                    <td colspan="4">
                    <label class=""style="margin-top:-15px;"><b>PHILIPPINE STATE COLLEGE OF AERONAUTICS<b></label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="4" style="margin-top:-15px;">
                      <span ><small>MACTAN CAMPUS</small></span>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="4">
                      <span style="margin-top:-15px;"> <small>Brig Gen Benito Ebuen Air Base, Lapu-Lapu City, Cebu</small></span>
                    </td>
                  </tr>
                
                  <tr>
                    <td colspan="4">
                        <label>OFFICE OF THE REGISTRAR</label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="4">
                      <label style="margin-top:-15px;"><b>OFFICIAL TRANSCIPT OF RECORDS</b></label>
                    </td>
                  </tr>
                  </table>
                <br>
                <table  class="top-table">
                  
                  <tr>
                    <td class="space">
                      <span></span>
                    </td>
                    <td>
                      <span>Name</span>
                    </td>
                    <td>
                    <span>: <b>No Data</b></span>
                    </td>
                    <td>
                      <span class="span">Sex</span>
                    </td>
                    <td>
                      <span>: No Data</span>
                    </td>
                    <td class="space">
                      <span></span>
                    </td>
                  </tr>
                  <tr>
                    <td class="space">
                      <span></span>
                    </td>
                    <td>
                      <span>Date of Birth</span>
                    </td>
                    <td>
                    <span>: No Data </span>
                    </td>
                    <td>
                      <span class="span">Parent Guuard</span>
                    </td>
                    <td>
                      <span>: No Data</span>
                    </td>
                    <td>
                      <span></span>
                    </td>
                  </tr>
                  <tr>
                    <td class="space">
                      <span></span>
                    </td>
                    <td>
                      <span>Place of Birth </span>
                    </td>
                    <td>
                    <span>: No Data</span>
                    </td>
                    <td>
                      <span>Address</span>
                    </td>
                    <td>
                      <span>: No Data</span>
                    </td>
                    <td class="space">
                      <span></span>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="6">
                      <label style="margin-left:130px;padding:0 0; font-size:12px;font-weight:bolder;">ENTRANCE DATA</label>
                    </td>
                  </tr>
                  <tr>
                    <td class="space">
                      <span></span>
                    </td>
                    <td>
                      <span>Basis of Admission</span>
                    </td>
                    <td>
                    <span>: No Data</span>
                    </td>
                    <td>
                      <span>Year Admitted</span>
                    </td>
                    <td>
                      <span>: No Data</span>
                    </td>
                    <td class="space">
                      <span></span>
                    </td>
                  </tr>
                  <tr>
                    <td class="space">
                      <span></span>
                    </td>
                    <td>
                      <span>Admitted to</span>
                    </td>
                    <td>
                      <span>: No Data</span>
                    <td>
                      <span>High School/College</span>
                    </td>
                    <td>
                      <span>: No Data</span>
                    </td>
                    <td class="space">
                      <span></span>
                    </td>
                  </tr>
                  <tr>
                    <td class="space">
                      <span></span>
                    </td>
                    <td>
                      <span>Course</span>
                    </td>
                    <td>
                    <span>: No Data</span>
                    </td>
                    <td>
                      <span>Address</span>
                    </td>
                    <td>
                      <span>: No Data</span>
                    </td>
                    <td class="space">
                      <span></span>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="6">
                      <label style="margin-left:130px;font-size:12px;font-weight:bolder;">RECORD OF GRADUATION</label>
                    </td>
                  </tr>
                  <tr>
                    <td class="space">
                      <span></span>
                    </td>
                    <td>
                      <span>Elementary</span>
                    </td>
                    <td>
                    <span>: No Data </span>
                    </td>
                    <td>
                      <span class="span">Year Graduated</span>
                    </td>
                    <td>
                      <span>: No Data</span>
                    </td>
                    <td class="space">
                      <span></span>
                    </td>
                  </tr>
                  <tr>
                    <td class="space">
                      <span></span>
                    </td>
                    <td>
                      <span>Secondary</span>
                    </td>
                    <td>
                    <span>: No Data</span>
                    </td>
                    <td>
                      <span> Year Graduated</span>
                    </td>
                    <td>
                      <span>: No Data</span>
                    </td>
                    <td class="space">
                      <span></span>
                    </td>
                  </tr>
                  <tr>
                    <td class="space">
                      <span></span>
                    </td>
                    <td >
                      <span>Major(s)</span>
                    </td>
                    <td >
                    <span>: No Data</span>
                    </td>
                      <span></span>
                    </td>
                    <td >
                      <span>Ninor(s)</span>
                    </td>
                    <td >
                    <span>: No Data</span>
                    </td>
                    <td class="space">
                      <span></span>
                    </td>
                  </tr>
                  <tr>
                    <td class="space">
                      <span></span>
                    </td>
                    <td>
                      <span>Date of Graduation</span>
                    </td>
                    <td>
                    <span>: No Data</span>
                    </td>
                    <td>
                      <span class="span">Honors/Distinction</span>
                    </td>
                    <td>
                      <span>: No Data</span>
                    </td>
                    <td class="space">
                      <span></span> 
                    </td>
                  </tr>
                  <tr>
                    <td class="space">
                      <span></span>
                    </td>
                    <td>
                      <span>Remarks</span>
                    </td>
                    <td colspan="3">
                    <span>: <b>No Data</b></span>
                    </td>
                    
                    <td class="space">
                      <span></span>
                    </td>
                  </tr>
                </table>
                <style>
                 .data-table{
                  border-bottom-style: none;
                  border-top-style: none;
                 }
                </style>
                <table class="data-table" border="1px" style="text-align:center;width:100%;">
                  <tr>
                    <td rowspan="2" style="width:10%;">Course Code</td>
                    <td rowspan="2" style="width:45%;">Descriptive Title</td>
                    <td colspan="2" style="width:20%;">Grades</td>
                    <td rowspan="2"style="width:10%;">Credits</td>
                  </tr>
                  <tr>
                        <td  style="width:10%;">Final</td>
                        <td    style="width:10%;">Re-Exam</td>
                  </tr>
                   <!-- DATA HERE-->
                  <tr >
                      <td class="data-table">No Data</td>
                      <td class="data-table"></td>
                      <td class="data-table"></td>
                      <td class="data-table"></td>
                      <td class="data-table"></td>
                  </tr>
                 
                  <tr>
                      <td class="data-table">No Data</td>
                      <td class="data-table">No Data</td>
                      <td class="data-table">No Data</td>
                      <td class="data-table"></td>
                      <td class="data-table">No Data</td>
                  </tr>

                  <!-- DATA HERE-->
                  <tr>
                    <td colspan="6">
                      <table id="grading-system" style="font-size:10px;text-align:center;border-top:none;">
                        <th colspan="9">GRADING SYSTEM</th>
                        <tr>
                          <td><small>Grade (Number)        </small></td>
                          <td><small>Percentage Equavalent </small></td>
                          <td><small>Genral Classification </small></td>

                          <td><small>Grade (Number)</td>
                          <td><small>Percentage Equavalent </small></td>
                          <td><small>Genral Classification </small></td>

                          <td><small>Grade (Number)        </small></td>
                          <td><small>Percentage Equavalent </small></td>
                          <td><small>Genral Classification </small></td>
                        </tr>

                        <tr>
                          <td> <small>1.00        </small></td>
                          <td> <small>97-100      </small></td>
                          <td> <small>Outstanding </small></td>

                          <td> <small>2.0         </small></td>
                          <td> <small>86-87       </small></td>
                          <td> <small>Good        </small></td>

                          <td> <small>3.0         </small></td>
                          <td> <small>75-79       </small></td>
                          <td> <small>Passing     </small></td>
                        </tr>
                        <tr>
                          <td> <small>1.25        </small></td>
                          <td> <small>94-96      </small></td>
                          <td> <small>Excellent </small></td>

                          <td> <small>2.25         </small></td>
                          <td> <small>84-85       </small></td>
                          <td> <small>Above Avereage        </small></td>

                          <td> <small>5.0         </small></td>
                          <td> <small>Below 75       </small></td>
                          <td> <small>Failed     </small></td>
                        </tr>
                        <tr>
                          <td> <small>1.5        </small></td>
                          <td> <small>91-93      </small></td>
                          <td> <small>Superior </small></td>

                          <td> <small>2.5         </small></td>
                          <td> <small>82-83       </small></td>
                          <td> <small>Avereage        </small></td>

                          <td> <small>Inc         </small></td>
                          <td> <small>        </small></td>
                          <td> <small>Incomplete     </small></td>
                        </tr>
                        <tr>
                          <td> <small>1.75        </small></td>
                          <td> <small>88-90      </small></td>
                          <td> <small>Very Good </small></td>

                          <td> <small>2.75         </small></td>
                          <td> <small>80-81       </small></td>
                          <td> <small>Fair        </small></td>

                          <td> <small>U.D         </small></td>
                          <td> <small>        </small></td>
                          <td> <small>Unofficialy Dropped     </small></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  
                </table>
                <div style="margin-top:0px;text-align:left;padding-left:60px;border:none;">
                      <span><small>ONE UNIT OF CREDIT is one hour lecture or recitation or three hours of labaratory drafting or shop work each weak for the perod of complete semester. </small><span><br>
                      <span> <small>NOTE: Any erasure or alteration on this transcript renders the whole transcript invalid unless initiated by the Registrar. </small><span>
                </div>
                <table class="table-footer" style="font-size:12px;">
                  <tr>
                    <td rowspan="6" style="border:1px solid grey">
                    </td>
                    <td>
                      <label>Prepared by:</label>
                    </td>
                    <td>
                      <label>Verified by:</label>
                    </td>
                    <td>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label><u>JACUELINE A. AEROLA</u></label>
                    </td>
                    <td>
                      <label><u>ARVELYN J. BOLAMBAO</u></label>
                    </td>
                    <td>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label><u></u></label>
                    </td>
                    <td>
                      <label>Certified Correct:</label>
                    </td>
                    <td>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label><u></u></label>
                    </td>
                    <td>
                      <label><u>ROWENA R. ALCABEDAS, LPT</u></label>
                    </td>
                    <td>
                    </td>
                  </tr>
                  <tr>
                    <td style="text-align:left;">
                      <small>Control Number: <i>32-7869</i></small>
                    </td>
                    <td>
                      <label><b>Registrar</b></label>
                    </td>
                    <td>
                    </td>
                  </tr>
                  <tr>
                    <td style="text-align:left;">
                      <small>O.R. No.: <i>0712869</i></small>
                    </td>
                    <td style="text-align:left;">
                      <small>Date: 01/05/2023</small>
                    </td>
                    <td>
                    </td>
                  </tr>
                  <tr>
                    <td style="" colspan="4">
                      <label>PHILLIPINE STATE COLLEGE OF AERONAUTICS-Mactan Benito Ebuen Air Base Lapu-Lapu City/philsca credential request@gmail.com</label>
                    </td>
                  </tr>
                  <tr>
                </table>
                <div class="" style="  text-align:center;opacity:0.3;margin-top:-500px;">
                  <img src="../img/favicon.png" width="30%;" >
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </body>
</html>
