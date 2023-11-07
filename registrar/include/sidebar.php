<body>
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
          line-height:-150px;
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
        <a class="navbar-brand" href="./" style="width:">
          <h4 class="text-primary fontweight-bolder">Online Grade Management</h4>
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
                <?php echo htmlentities($_SESSION['type']); //position ?>
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
              <a class="nav-link <?php echo ($parentpage == "dashboard" ? "text-primary bg-green" : "") ?>" href="./">
                <i class="ni ni-shop text-primary"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link <?php echo ($page == "Student" ? "text-primary bg-green" : "") ?>" href="student.php">
                <i class="ni ni-hat-3 text-primary"></i>
                <span class="nav-link-text">Student</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link <?php echo ($parentpage == "Records" ? "text-primary bg-green" : "") ?>" href="#navbar-account" data-toggle="collapse" role="button" aria-expanded="<?php echo ($parentpage == "account" ? "true" : "false") ?>" aria-controls="navbar-dataaccount">
                <i class="ni ni-single-copy-04 text-primary"></i>
                <span class="nav-link-text">Student Records</span>
              </a>
              <div class="collapse <?php echo ($parentpage == "Records" ? "show" : "") ?>" id="navbar-account">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="grade.php" class="nav-link  <?php echo ($childpage == "Grade" ? "text-primary bg-green" : "") ?>">Periodical Grade</a>
                  </li>
                  <li class="nav-item">
                    <a href="grading_sheet.php" class="nav-link <?php echo ($childpage == "Grading Sheet" ? "text-primary bg-green" : "") ?>">Grading Sheet</a>
                  </li>
                  <li class="nav-item">
                    <a href="tor.php" class="nav-link <?php echo ($childpage == "TOR" ? "text-primary bg-green" : "") ?>">TOR</a>
                  </li>
                  <li class="nav-item">
                    <a href="student_list.php" class="nav-link <?php echo ($childpage == "Student_list" ? "text-primary bg-green" : "") ?>">Student List</a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link <?php echo ($parentpage == "school_record" ? "text-primary bg-green" : "") ?>" href="#navbar-data" data-toggle="collapse" role="button" aria-expanded="<?php echo ($parentpage == "Data" ? "true" : "false") ?>" aria-controls="navbar-data">
                <i class="ni ni-single-copy-04 text-primary"></i>
                <span class="nav-link-text">School Records</span>
              </a>
              <div class="collapse <?php echo ($parentpage == "school_record" ? "show" : "") ?>" id="navbar-data">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="course.php" class="nav-link  <?php echo ($childpage == "Course" ? "text-primary bg-green" : "") ?>">Course</a>
                  </li>
                  <li class="nav-item">
                    <a href="program.php" class="nav-link <?php echo ($childpage == "Program" ? "text-primary bg-green" : "") ?>">Program</a>
                  </li>
                  <li class="nav-item">
                    <a href="institute.php" class="nav-link <?php echo ($childpage == "Institute" ? "text-primary bg-green" : "") ?>">Institute</a>
                  </li>
                </ul>
              </div>
            </li>


			      <li class="nav-item">
              <a class="nav-link <?php echo ($page == "announcement" ? "text-primary bg-green" : "") ?>" href="announcement.php">
                <i class="ni ni-notification-70 text-primary"></i>
                <span class="nav-link-text">Announcement</span>
              </a>
            </li>

          </ul>
          <!-- Divider -->
        </div>
      </div>
    </div>
  </nav>