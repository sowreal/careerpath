<?php
// Determine if any of the Career Progress Tracking pages are active
$isCPTActive = in_array($activePage, ['CPT', 'CPT_Request', 'CPT_Teaching', 'CPT_Research', 'CPT_Extension', 'CPT_Professional']);
?>

<aside class="app-sidebar sidebar-bg" data-bs-theme="dark"> 
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand sidebar-bg-top"> 
        <!--begin::Brand Link--> 
        <a href="<?php echo BASE_URL; ?>php/dashboard/dashboard_faculty.php" class="brand-link"> 
            <!--begin::Brand Image--> 
            <img src="<?php echo BASE_URL; ?>img/cropped-SLSU_Logo-1.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow"> <!--end::Brand Image--> 

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
                <li class="nav-item"> <a href="<?php echo BASE_URL; ?>php/dashboard/dashboard_faculty.php" class="nav-link <?php echo ($activePage == 'Dashboard') ? 'active' : ''; ?>"> <i class="nav-icon bi bi-speedometer2"></i>
                        <p><strong>Dashboard</strong>
                        <!-- <i class="nav-arrow bi bi-chevron-right"></i> -->
                        </p>
                    </a>
                </li>

                <li class="nav-item"> <a href="<?php echo BASE_URL; ?>php/dashboard/profile_management.php" class="nav-link <?php echo ($activePage == 'Profile') ? 'active' : ''; ?>"> <i class="nav-icon bi bi-person-circle active"></i>
                        <p><strong>Profile Management</strong></p>
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
                            <a href="<?php echo BASE_URL; ?>php/dashboard/career_progress_tracking/career_progress_request.php" class="nav-link <?php echo ($activePage == 'CPT_Request') ? 'active' : ''; ?>">
                                <i class="nav-icon bi bi-file-earmark-text"></i> 
                                <p>Request Form</p>
                            </a>
                        </li>
                        <li class="nav-item ms-3">
                            <a href="<?php echo BASE_URL; ?>php/dashboard/career_progress_tracking/career_progress_teaching.php" class="nav-link <?php echo ($activePage == 'CPT_Teaching') ? 'active' : ''; ?>">
                                <i class="nav-icon bi bi-journal-text"></i> 
                                <p>Teaching</p>
                            </a>
                        </li>
                        <li class="nav-item ms-3">
                            <a href="<?php echo BASE_URL; ?>php/dashboard/career_progress_tracking/career_progress_research.php" class="nav-link <?php echo ($activePage == 'CPT_Research') ? 'active' : ''; ?>">
                                <i class="nav-icon bi bi-journal-medical"></i> 
                                <p>Research, Innovation, and Creative Works</p>
                            </a>
                        </li>
                        <li class="nav-item ms-3">
                            <a href="<?php echo BASE_URL; ?>php/dashboard/career_progress_tracking/career_progress_extension.php" class="nav-link <?php echo ($activePage == 'CPT_Extension') ? 'active' : ''; ?>">
                                <i class="nav-icon bi bi-people"></i>
                                <p>Extension Services</p>
                            </a>
                        </li>
                        <li class="nav-item ms-3">
                            <a href="<?php echo BASE_URL; ?>php/dashboard/career_progress_tracking/career_progress_professional.php" class="nav-link <?php echo ($activePage == 'CPT_Professional') ? 'active' : ''; ?>">
                                <i class="nav-icon bi bi-award"></i> 
                                <p>Professional Development</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item"> <a href="<?php echo BASE_URL; ?>php/dashboard/performance_summary_report.php" class="nav-link <?php echo ($activePage == 'PSR') ? 'active' : ''; ?>"> <i class="nav-icon bi bi-bar-chart"></i>
                        <p><strong>Performance Summary Reports</strong>
                        </p>
                    </a>
                </li>
                
                <li class="nav-item"> <a href="<?php echo BASE_URL; ?>php/dashboard/document_management.php" class="nav-link <?php echo ($activePage == 'Documents') ? 'active' : ''; ?>"> <i class="nav-icon bi bi-folder"></i>
                        <p><strong>Document Management</strong></p>
                    </a>
                </li>

                <li class="nav-item"> <a href="<?php echo BASE_URL; ?>php/dashboard/notifications.php" class="nav-link <?php echo ($activePage == 'Notifs') ? 'active' : ''; ?>"> <i class="nav-icon bi bi-bell"></i>
                        <p><strong>Notifications</strong>
                        </p>
                    </a>
                    <!-- <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="./UI/general.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>General</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./UI/icons.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Icons</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./UI/timeline.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Timeline</p>
                            </a> </li>
                    </ul> -->
                </li>

                <li class="nav-item"> <a href="<?php echo BASE_URL; ?>php/dashboard/opportunities.php" class="nav-link <?php echo ($activePage == 'Opportunities') ? 'active' : ''; ?>"> <i class="nav-icon bi bi-briefcase"></i>
                        <p><strong>Job/Promotion Opportunities</strong>
                        </p>
                    </a>
                </li>

                <li class="nav-item"> <a href="<?php echo BASE_URL; ?>php/dashboard/resources_training.php" class="nav-link <?php echo ($activePage == 'Training') ? 'active' : ''; ?>"> <i class="nav-icon bi bi-book"></i>
                        <p><strong>Resources and Training</strong></p>
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
                        <p><strong>Settings</strong>
                        </p><i class="nav-arrow bi bi-chevron-right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="#" class="nav-link <?php echo ($activePage == 'Account Settings') ? 'active' : ''; ?>"> <i class="nav-icon bi bi-box-arrow-in-right"></i>
                                <p>
                                Account Settings
                                </p>
                            </a>
                        </li>
                        <li class="nav-item"> <a href="#" class="nav-link <?php echo ($activePage == 'Privacy Settings') ? 'active' : ''; ?>"> <i class="nav-icon bi bi-box-arrow-in-right"></i>
                                <p>
                                Privacy Settings
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item"> <a href="<?php echo BASE_URL; ?>php/logout.php" class="nav-link"> <i class="nav-icon bi bi-box-arrow-right"></i>
                        <p><strong>Sign Out</strong></p> </a>
                </li>
            </ul>
        </nav>
    </div>

</aside> 