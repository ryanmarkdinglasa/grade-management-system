<?php
  include '../include/conn.php';
	include("include/session.php");
?>
  <!-- Topnav -->
  <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Search form -->
        <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
          <div class="form-group mb-0">
            <div class="input-group input-group-alternative input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
              </div>
              <input class="form-control" placeholder="Search Page ..." onkeyup="showResult(this.value)" type="text">
            </div>
          </div>
          <div id="livesearch"></div>
          <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </form>
        <!-- Navbar links -->
        <ul class="navbar-nav align-items-center ml-md-auto">
          <li class="nav-item dropdown">
            <p class="nav-link mb-0 text-sm  font-weight-bold text-white" href="#">
              <i class="ni ni-calendar-grid-58"></i>
              <?php
                try {
                    $query = "SELECT * FROM `period` WHERE `status` = '1' LIMIT 1";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['academic-year']=$result['id'];
                    if ($result) {
                        echo $result['year'] . " ";
                        if ($result['term'] == '1') echo "1st Semester";
                        else if ($result['term'] == '2') echo "2nd Semester";
                        else if ($result['term'] == '3') echo "Summer";
                        else echo "Unknown Term";
                    } else  echo "No active period found."; // Handle the case when no active period is found.
                } catch (PDOException $e) {  echo "Error: " . $e->getMessage(); }
              ?>
            </p>
          </li>
        </ul>
        <ul class="navbar-nav align-items-center ml-auto ml-md-0">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle">
                    <?php $userphoto = $user['profileImage']; //user's photo
                    if ($userphoto == "") :
                    ?>
                      <img src="img/profile.png" alt="Image placeholder">
                    <?php else : ?>
                      <img alt="Image placeholder" src="img/<?php echo htmlentities($userphoto); ?>" style="width:40px;height:35px;border-radius:50%;">
                    <?php endif; ?>
                  </span>
                 
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-header noti-title">
                <div class="media-body ml-2 d-none d-lg-block">
                  <h5 class=" m-0 text-sm  font-weight-bold">
                     <?php echo  htmlentities($user['firstname'].' '.$user['lastname']); //user's name ?>
                  </h5>
                  <h6 class="text-overflow m-0" data-toggle="tooltip" data-placement="left" title="Username">
                    <?php 
                    if($user['position_id']=='2'){
                      $position="Course Coordinator";
                    }else if($user['position_id']=='3'){
                      $position="Teacher";
                    } echo htmlentities($position); //position ?>
                  </h6>
                </div>
            </div>

			  <div class="dropdown-divider"></div>
          <a href="profile.php" class="dropdown-item">
            <i class="ni ni-single-02 text-primary"></i>
          <span>Profile</span>
          </a>
          <a href="logout.php" class="dropdown-item">
            <i class="ni ni-user-run text-primary"></i>
            <span>Logout</span>
          </a>	
          </li>
        </ul>
      </div>
    </div>
  </nav>