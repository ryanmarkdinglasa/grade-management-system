<body>
  <?php
    include '../include/conn.php';
    include("include/session.php");
  ?>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white text-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <style>
        .brand:hover{
          opacity:0.9;
          transition:0.3s;
        }
        .sidebar-user{
          /border:1px solid red;
          border-radius: 5px;
          width:100%;
          height:50px;
          position:absolute;
          padding:10px 10px;
          line-height:50px;
          margin-top:100px;
        }
        .sidebar-user:hover{
          background:rgb(246,249,252);
        }
        .sidebar-user span{
          float:left;
          margin:-17px 5px; 
          /border:1px solid red;

        }
      </style>  
      <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand " href="./" style="width:">
          <h4 class="text-primary fonr-weight-bolder">Online Grade Management</h4>
        </a>
          <div class="navbar-brand sidebar-user text-left">
            <a href="profile.php">
            <span class="avatar avatar-sm rounded-circle" >
              <?php $userphoto = $user['profileImage']; //user's photo
                if ($userphoto == "") :
              ?>
              <img src="img/profile.png" alt="Image placeholder">
              <?php else : ?>
                <img alt="Image placeholder" src="img/<?php echo htmlentities($userphoto); ?>" style="width:40px;height:35px;border-radius:50%;">
              <?php endif; ?>
            </span>
            <span>
              <h5 class=" m-0 text-sm  font-weight-bold">
                <?php echo  htmlentities($user['firstname'].' '.$user['lastname']); //user's name ?>
              </h5>
              <h6 class="text-overflow m-0" data-toggle="tooltip" data-placement="left" title="User">
                
                <?php 
                if($user['position_id']=='2'){
                  $position="Program Coordinator";
                }else if($user['position_id']=='3'){
                  $position="Teacher";
                }
               
                echo htmlentities($position); //position ?>
              </h6>
            </span>
            </a>
          </div>
        

        <div class="ml-auto">
          <!-- Sidenav toggler -->
          <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </div>
      </div>
      <br>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link <?php echo ($parentpage == "dashboard" ? " bg-green text-primary" : "") ?>" href="./">
                <i class="ni ni-shop text-primary"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            <?php
                if($user['position_id']=='2'){
              ?>
            <li class="nav-item">
              <a class="nav-link <?php echo ($page == "Student" ? "bg-green  text-primary" : "") ?>" href="student.php">
                <i class="ni ni-hat-3 text-primary"></i>
                <span class="nav-link-text">Student</span>
              </a>
            </li>
              <?php
               }else if($user['position_id']=='3'){
              ?>
              <li class="nav-item">
              <a class="nav-link <?php echo ($page  == "Student" ? "bg-green  text-primary" : "") ?>" href="#navbar-account" data-toggle="collapse" role="button" aria-expanded="<?php echo ($page == "Student" ? "true" : "false") ?>" aria-controls="navbar-dataaccount">
                <i class="ni ni-hat-3 text-primary"></i>
                <span class="nav-link-text">Student</span>
              </a>
              <div class="collapse <?php echo ($page == "Student" ? "show" : "") ?>" id="navbar-account">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="student_list.php" class="nav-link  <?php echo ($childpage == "Student" ? "bg-green  text-primary" : "") ?>">Student List</a>
                  </li>
                  <li class="nav-item">
                    <a href="print_list.php" class="nav-link <?php echo ($childpage == "Print" ? "bg-green  text-primary" : "") ?>">Print List</a>
                  </li>
                </ul>
              </div>
            </li>
              <?php
                }
                if($user['position_id']=='2'){
              ?>
            <li class="nav-item">
              <a class="nav-link <?php echo ($page == "Class" ? "bg-green  text-primary" : "") ?>" href="class.php">
                <i class="ni ni-folder-17  text-primary"></i>
                <span class="nav-link-text">Class</span>
              </a>
            </li>
            <?php
               }else if($user['position_id']=='3'){
              ?>
              <a class="nav-link <?php echo ($page == "Class" ? "bg-green  text-primary" : "") ?>" href="class_course.php">
                <i class="ni ni-folder-17  text-primary"></i>
                <span class="nav-link-text">Class</span>
              </a>
              <?php
               }
             ?>
            <?php
                if($user['position_id']=='2'){
              ?>
              <li class="nav-item">
                <a class="nav-link <?php echo ($page == "Grade" ? "bg-green  text-primary" : "") ?>" href="grade.php">
                  <i class="ni ni-archive-2  text-primary"></i>
                  <span class="nav-link-text">Grade</span>
                </a>
              </li>
            <?php
               }else if($user['position_id']=='3'){
              ?>
                <li class="nav-item">
                  <a class="nav-link <?php echo ($page == "Grade" ? "bg-green  text-primary" : "") ?>" href="grading_sheet.php">
                    <i class="ni ni-archive-2  text-primary"></i>
                    <span class="nav-link-text">Grading Sheet</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?php echo ($page == "Grades" ? "bg-green  text-primary" : "") ?>" href="grades.php">
                    <i class="ni ni-archive-2  text-primary"></i>
                    <span class="nav-link-text">Grades</span>
                  </a>
                </li>
               <?php
               }
             ?>
            <?php
                if($user['position_id']=='2'){
              ?>
            <li class="nav-item">
              <a class="nav-link <?php echo ($page == "Course" ? "bg-green  text-primary" : "") ?>" href="course.php">
                <i class="ni ni-books text-primary"></i>
                <span class="nav-link-text">Course</span>
              </a>
            </li>
              <?php
               }else if($user['position_id']=='3'){
              ?>
              <li class="nav-item">
                <a class="nav-link <?php echo ($page == "Course" ? "bg-green  text-primary" : "") ?>" href="course_schedule.php">
                  <i class="ni ni-books text-primary"></i>
                  <span class="nav-link-text">Course</span>
                </a>
              </li>
              
              <?php
               }
             ?>
              <?php
                if($user['position_id']=='2'){
              ?>
			      <li class="nav-item">
              <a class="nav-link <?php echo ($page == "announcement" ? "bg-green  text-primary" : "") ?>" href="announcement.php">
                <i class="ni ni-notification-70 text-primary"></i>
                <span class="nav-link-text">Announcement</span>
              </a>
            </li>
              <?php
               }
             ?>
          </ul>
          <!-- Divider -->
        </div>
      </div>
    </div>
  </nav>