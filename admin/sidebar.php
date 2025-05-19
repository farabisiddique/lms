<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="./index.php" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="./dist/assets/img/bookicon.jpg"
              alt="Book Icon"
              class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">LMS</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="menu"
              data-accordion="false"
            >
              <li class="nav-item">
                <a href="./index.php" class="nav-link">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./profile.php" class="nav-link">
                  <i class="nav-icon bi bi-person"></i>
                  <p>Profile</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./displaybooks.php" class="nav-link">
                  <i class="nav-icon bi bi-card-list"></i>
                  <p>All Books</p>
                </a>
              </li>
              <?php 
                if($user_type == 'staff') {
              ?>
              <li class="nav-item">
                <a href="./stdinfo.php" class="nav-link">
                  <i class="nav-icon bi bi-mortarboard"></i>
                  <p>All Student Information</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./tinfo.php" class="nav-link">
                  <i class="nav-icon bi bi-person-video3"></i>
                  <p>All Teacher Information</p>
                </a>
              </li>
              
              <li class="nav-item menu-open">
                <a href="#" class="nav-link ">
                  <i class="nav-icon bi bi-book"></i>
                  <p>
                    Manage Books
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./addbooks.php" class="nav-link ">
                      <i class="nav-icon bi bi-plus-square"></i>
                      <p>Add Books</p>
                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a href="./issuebooks.php" class="nav-link">
                      <i class="nav-icon bi bi-box-arrow-in-up-right"></i>
                      <p>Issue Books</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./returnbooks.php" class="nav-link">
                      <i class="nav-icon bi bi-arrow-down-left-circle"></i>
                      <p>Return Books</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item menu-open">
                <a href="#" class="nav-link ">
                  <i class="nav-icon bi bi-person"></i>
                  <p>
                    Manage Users
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./addstudent.php" class="nav-link ">
                      <i class="nav-icon bi bi-person-add"></i>
                      <p>Add Student</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./addteacher.php" class="nav-link">
                      <i class="nav-icon bi bi-house-add-fill"></i>
                      <p>Add Teacher</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./addstaff.php" class="nav-link">
                      <i class="nav-icon bi bi-building-fill-add"></i>
                      <p>Add Staff</p>
                    </a>
                  </li>
                </ul>
              </li>
              <?php
                }
                if($user_type == 'student' || $user_type == 'teacher') {

              ?>
              <li class="nav-item">
                <a href="./viewissued.php" class="nav-link">
                  <i class="nav-icon bi bi-person"></i>
                  <p>View Issued Books</p>
                </a>
              </li>
              <?php
                }
              ?>
              
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->

      <script src="./sidebar-active.js"></script>