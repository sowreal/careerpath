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
