<nav class="app-header navbar navbar-expand bg-body">
    <!--begin::Container-->
    <div class="container-fluid"> 
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="bi bi-list"></i> </a> </li>
            <li class="nav-item d-none d-md-block"> <a href="#" class="nav-link">Home</a> </li>
            <li class="nav-item d-none d-md-block"> <a href="#" class="nav-link">Contact</a> </li>
        </ul> <!--end::Start Navbar Links--> <!--begin::End Navbar Links-->
        
        <ul class="navbar-nav ms-auto"> 
            <!--begin::Notifications Dropdown Menu-->
            <li class="nav-item dropdown"> <a class="nav-link" data-bs-toggle="dropdown" href="#"> <i class="bi bi-bell-fill"></i> <span class="navbar-badge badge text-bg-warning">15</span> </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div> <a href="<?php echo BASE_URL ?>/php/dashboard/notifications.php#" class="dropdown-item"> <i class="bi bi-envelope me-2"></i> 4 new messages
                        <span class="float-end text-secondary fs-7">3 mins</span> </a>
                    <div class="dropdown-divider"></div> <a href="<?php echo BASE_URL ?>/php/dashboard/notifications.php" class="dropdown-item"> <i class="bi bi-people-fill me-2"></i> 8 friend requests
                        <span class="float-end text-secondary fs-7">12 hours</span> </a>
                    <div class="dropdown-divider"></div> <a href="<?php echo BASE_URL ?>/php/dashboard/notifications.php" class="dropdown-item"> <i class="bi bi-file-earmark-fill me-2"></i> 3 new reports
                        <span class="float-end text-secondary fs-7">2 days</span> </a>
                    <div class="dropdown-divider"></div> <a href="<?php echo BASE_URL ?>/php/dashboard/notifications.php" class="dropdown-item dropdown-footer">
                        See All Notifications
                    </a>
                </div>
            </li> <!--end::Notifications Dropdown Menu--> <!--begin::Fullscreen Toggle-->
            <li class="nav-item"> <a class="nav-link" href="#" data-lte-toggle="fullscreen"> <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i> <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i> </a> </li> <!--end::Fullscreen Toggle--> <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu"> 
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"> 
                    <img src="<?php echo (!empty($_SESSION['profile_picture'])) ?  BASE_URL . '/' . 'uploads/' . $_SESSION['profile_picture'] : BASE_URL . '/img/cropped-SLSU_Logo-1.png'; ?>" class="user-image rounded-circle shadow" alt="User Image"> 
                    <span class="d-none d-md-inline"><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> 
                    <!--begin::User Image-->
                    <li class="user-header text-bg-success"> <img src="<?php echo (!empty($_SESSION['profile_picture'])) ? BASE_URL . '/' . 'uploads/' . $_SESSION['profile_picture'] : BASE_URL . '/img/cropped-SLSU_Logo-1.png'; ?>" class="rounded-circle shadow" alt="User Image">
                        <p>
                        <h4><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];?></h4> 
                            <?php echo $_SESSION['faculty_rank'] . '<br>' . $_SESSION['department'];?>
                        </p>
                        <small>Member since <?php echo $formattedCreatedAt; ?></small>
                    </li> 
                    <!--end::User Image--> 

                    <!--begin::Menu Body-->
                    <!-- <li class="user-body"> 
                        <div class="row">
                            <div class="col-4 text-center"> <a href="#">Followers</a> </div>
                            <div class="col-4 text-center"> <a href="#">Sales</a> </div>
                            <div class="col-4 text-center"> <a href="#">Friends</a> </div>
                        </div> 
                    </li>  -->
                    <!--end::Menu Body--> 
                    
                    <!--begin::Menu Footer-->
                    <li class="user-footer"> <a href="<?php echo BASE_URL ?>/php/dashboard/profile_management.php" class="btn btn-default btn-flat">Profile</a> 
                    <a href="<?php echo BASE_URL ?>/php/logout.php" class="btn btn-default btn-flat float-end">Sign out</a> </li> <!--end::Menu Footer-->
                </ul>
            </li> 
            <!--end::User Menu Dropdown-->

            <!-- TOGGLE DARK MODE START -->
            <li class="nav-item dropdown">
                <button
                    class="btn btn-link nav-link py-2 px-0 px-lg-2 dropdown-toggle d-flex align-items-center"
                    id="bd-theme"
                    type="button"
                    aria-expanded="false"
                    data-bs-toggle="dropdown"
                    data-bs-display="static"
                    >
                    <span class="theme-icon-active">
                        <i class="my-1"></i>
                    </span>
                    <span class="d-lg-none ms-2" id="bd-theme-text"></span>
                </button>
                <ul
                    class="dropdown-menu dropdown-menu-end"
                    aria-labelledby="bd-theme-text"
                    style="--bs-dropdown-min-width: 8rem;"
                    >
                    <li>
                        <button
                        type="button"
                        class="dropdown-item d-flex align-items-center active"
                        data-bs-theme-value="light"
                        aria-pressed="false"
                        >
                        <i class="bi bi-sun-fill me-2"></i>
                        Light
                        <i class="bi bi-check-lg ms-auto d-none"></i>
                        </button>
                    </li>
                    <li>
                        <button
                        type="button"
                        class="dropdown-item d-flex align-items-center"
                        data-bs-theme-value="dark"
                        aria-pressed="false"
                        >
                        <i class="bi bi-moon-fill me-2"></i>
                        Dark
                        <i class="bi bi-check-lg ms-auto d-none"></i>
                        </button>
                    </li>
                    <li>
                        <button
                        type="button"
                        class="dropdown-item d-flex align-items-center"
                        data-bs-theme-value="auto"
                        aria-pressed="true"
                        >
                        <i class="bi bi-circle-fill-half-stroke me-2"></i>
                        Auto
                        <i class="bi bi-check-lg ms-auto d-none"></i>
                        </button>
                    </li>
                </ul>
            </li>
            <!-- TOGGLE DARK MODE END -->
        </ul> 
        <!--end::End Navbar Links-->
    </div> 
    <!--end::Container-->
</nav>