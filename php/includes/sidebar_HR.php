<aside class="app-sidebar sidebar-bg" data-bs-theme="dark"> 
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand sidebar-bg-top"> 
        <!--begin::Brand Link--> 
        <a href="../dashboard_HR/dashboard_HR.php" class="brand-link"> 
            <!--begin::Brand Image--> 
            <img src="../../img/cropped-SLSU_Logo-1.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow"> <!--end::Brand Image--> 

            <!--begin::Brand Text--> 
            <span class="brand-text fw-light">SLSU Career Path</span>
            <!--end::Brand Text--> 
        </a><!--end::Brand Link--> 
    </div><!--end::Sidebar Brand--> 
    
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2"> 
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item"> <a href="../dashboard_HR/dashboard_HR.php" class="nav-link <?php echo ($activePage == 'DashboardHR') ? 'active' : ''; ?>"> 
                    <i class="nav-icon bi bi-speedometer2"></i>
                        <p><strong>Dashboard</strong></p>
                    </a>
                </li>

                <li class="nav-item"> <a href="../dashboard_HR/faculty_management.php" class="nav-link <?php echo ($activePage == 'Faculty Management') ? 'active' : ''; ?>"> 
                    <i class="nav-icon bi bi-person-badge"></i>
                        <p><strong>Faculty Management</strong></p>
                    </a>
                </li>

                <li class="nav-item has-treeview <?php echo $isCPTActive ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?php echo $isCPTActive ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-box-seam"></i>
                        <p><strong>Career Progress Tracking</strong></p>
                        <i class="nav-arrow bi bi-chevron-right"></i> 
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ms-3">
                            <a href="<?php echo BASE_URL ?>/php/dashboard/career_progress_tracking/career_progress_request.php" class="nav-link <?php echo ($activePage == 'CPT_Request') ? 'active' : ''; ?>">
                                <i class="nav-icon bi bi-file-earmark-text"></i> 
                                <p>Request Form</p>
                            </a>
                        </li>
                        <li class="nav-item ms-3">
                            <a href="<?php echo BASE_URL ?>/php/dashboard/career_progress_tracking/career_progress_teaching.php" class="nav-link <?php echo ($activePage == 'CPT_Teaching') ? 'active' : ''; ?>">
                                <i class="nav-icon bi bi-journal-text"></i> 
                                <p>Teaching</p>
                            </a>
                        </li>
                        <li class="nav-item ms-3">
                            <a href="<?php echo BASE_URL ?>/php/dashboard/career_progress_tracking/career_progress_research.php" class="nav-link <?php echo ($activePage == 'CPT_Research') ? 'active' : ''; ?>">
                                <i class="nav-icon bi bi-journal-medical"></i> 
                                <p>Research, Innovation, and Creative Works</p>
                            </a>
                        </li>
                        <li class="nav-item ms-3">
                            <a href="<?php echo BASE_URL ?>/php/dashboard/career_progress_tracking/career_progress_extension.php" class="nav-link <?php echo ($activePage == 'CPT_Extension') ? 'active' : ''; ?>">
                                <i class="nav-icon bi bi-people"></i>
                                <p>Extension Services</p>
                            </a>
                        </li>
                        <li class="nav-item ms-3">
                            <a href="<?php echo BASE_URL ?>/php/dashboard/career_progress_tracking/career_progress_professional.php" class="nav-link <?php echo ($activePage == 'CPT_Professional') ? 'active' : ''; ?>">
                                <i class="nav-icon bi bi-award"></i> 
                                <p>Professional Development</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item"> <a href="../dashboard_HR/document_management.php" class="nav-link <?php echo ($activePage == 'Document Management') ? 'active' : ''; ?>"> 
                    <i class="nav-icon bi bi-file-earmark-text"></i>
                        <p><strong>Document Management</strong></p>
                    </a>
                </li>

                <li class="nav-item"> <a href="../dashboard_HR/announcements.php" class="nav-link <?php echo ($activePage == 'Announcements') ? 'active' : ''; ?>"> 
                    <i class="nav-icon bi bi-megaphone"></i>
                        <p><strong>Announcements</strong></p>
                    </a> </li>

                <li class="nav-item"> <a href="../dashboard_HR/notifications.php" class="nav-link <?php echo ($activePage == 'Notifications') ? 'active' : ''; ?>"> 
                    <i class="nav-icon bi bi-graph-up"></i>
                        <p><strong>Notifications</strong></i></p>
                    </a>
                </li>
            </ul> <!--end::Sidebar Menu-->
        </nav>
    </div> <!--end::Sidebar Wrapper-->

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-gear"></i>
                        <p><strong>Settings</strong></p><i class="nav-arrow bi bi-chevron-right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="../dashboard/profile_management.php" class="nav-link <?php echo ($activePage == 'Profile') ? 'active' : ''; ?>"> <i class="nav-icon bi bi-box-arrow-in-right"></i>
                                <p>Account Settings</p>
                            </a>
                        </li>
                        <li class="nav-item"> <a href="#" class="nav-link <?php echo ($activePage == 'Privacy Settings') ? 'active' : ''; ?>"> <i class="nav-icon bi bi-box-arrow-in-right"></i>
                                <p>Privacy Settings</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item"> <a href="../logout.php" class="nav-link"> <i class="nav-icon bi bi-box-arrow-right"></i>
                        <p><strong>Sign Out</strong></p> </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
