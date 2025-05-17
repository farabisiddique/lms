<?php
session_start();
include '../db.php'; 

if (isset($_COOKIE['rememberMe'])) {
  $token = $_COOKIE['rememberMe'];
  $userid = $_SESSION['user_id'];
  
  $userQuery = $conn->prepare("SELECT * FROM users WHERE id = ?");
  $userQuery->bind_param("i", $userid);
  $userQuery->execute();
  $userResult = $userQuery->get_result();
  if ($userResult->num_rows == 1) {
    $userHere = $userResult->fetch_assoc();
    $fullname = $userHere['name'];
    $username = $userHere['username'];
    $user_type = $userHere['user_type'];
    $designation = $userHere['designation'];
    $photo = $userHere['photo'];
  }

  // Handle form submission
  $message = '';
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = $_POST['name'];
      $username = $_POST['username'];
      $password = $_POST['password'];
      $email = $_POST['email'];
      $phone = $_POST['phone'];
      $address = $_POST['address'];
      $dept = 'Library'; // Fixed department
      $designation = $_POST['designation'];
      
      // Handle photo upload
      $photo_path = '';
      if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
          $upload_dir = 'upload/';
          $photo_name = time() . '_' . basename($_FILES['photo']['name']);
          $photo_path = $upload_dir . $photo_name;
          move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
      }
      
      // Generate unique ID
      $lastUserQuery = $conn->query("SELECT MAX(id) as max_id FROM users");
      $lastUser = $lastUserQuery->fetch_assoc();
      $new_id = $lastUser['max_id'] + 1;
      $uniqueid = 'S3000' . $new_id;
      
      // Insert staff
      $insertQuery = $conn->prepare("INSERT INTO users (name, username, pass, email, user_type, phone, address, photo, dept, designation, uniqueid) VALUES (?, ?, ?, ?, 'staff', ?, ?, ?, ?, ?, ?)");
      $insertQuery->bind_param("ssssssssss", $name, $username, $password, $email, $phone, $address, $photo_path, $dept, $designation, $uniqueid);
      
      if ($insertQuery->execute()) {
          $message = "Staff added successfully! Unique ID: $uniqueid";
      } else {
          $message = "Error adding staff: " . $conn->error;
      }
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Library Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="LMS | Dashboard" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="./dist/css/adminlte.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
      integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
      crossorigin="anonymous"
    />
  </head>
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
      <?php include './header.php'; ?>
      <?php include './sidebar.php'; ?>
      <main class="app-main">
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Add Staff</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Add Staff</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div class="app-content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-8 offset-md-2">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Staff Information</h3>
                  </div>
                  <div class="card-body">
                    <?php if ($message): ?>
                      <div class="alert alert-info"><?php echo $message; ?></div>
                    <?php endif; ?>
                    <form method="POST" enctype="multipart/form-data">
                      <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                      </div>
                      <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                      </div>
                      <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                      </div>
                      <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                      </div>
                      <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                      </div>
                      <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" required></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="dept" class="form-label">Department</label>
                        <input type="text" class="form-control" id="dept" name="dept" value="Library" readonly>
                      </div>
                      <div class="mb-3">
                        <label for="designation" class="form-label">Designation</label>
                        <select class="form-control" id="designation" name="designation" required>
                          <option value="">Select Designation</option>
                          <option value="Librarian">Librarian</option>
                          <option value="Assistant Librarian">Assistant Librarian</option>
                          <option value="Library Clerk">Library Clerk</option>
                          <option value="Library Technician">Library Technician</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                      </div>
                      <button type="submit" class="btn btn-primary">Add Staff</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
      <?php include './footer.php'; ?>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
      integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <script src="./dist/js/adminlte.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
      integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
      integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
      integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY="
      crossorigin="anonymous"
    ></script>
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
  </body>
</html>
<?php
} else {
  header("Location: ../index.php");
}
?>