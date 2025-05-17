<?php
session_start();
include './db.php'; 

// Redirect if already logged in
if (isset($_COOKIE['rememberMe'])) {
  header("Location: admin/index.php");
  exit;
}

// Handle form submission
$message = '';
$uniqueid = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $dept = trim($_POST['dept']);
    
    // Handle photo upload
    $photo_path = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $upload_dir = 'upload/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $photo_name = time() . '_' . basename($_FILES['photo']['name']);
        $photo_path = $upload_dir . $photo_name;
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path)) {
            $photo_path = '';
        }
    }
    
    // Generate unique ID
    $lastUserQuery = $conn->query("SELECT MAX(id) as max_id FROM users");
    $lastUser = $lastUserQuery->fetch_assoc();
    $new_id = $lastUser['max_id'] ? $lastUser['max_id'] + 1 : 1;
    $uniqueid = '12000' . $new_id;
    
    // Insert student
    $insertQuery = $conn->prepare("INSERT INTO users (name, username, pass, email, user_type, phone, address, photo, dept, designation, uniqueid) VALUES (?, ?, ?, ?, 'student', ?, ?, ?, ?, 'Student', ?)");
    $insertQuery->bind_param("sssssssss", $name, $username, $password, $email, $phone, $address, $photo_path, $dept, $uniqueid);
    
    if ($insertQuery->execute()) {
        $message = "Signup successful! Your Unique ID is: $uniqueid";
    } else {
        $message = "Error during signup: " . $conn->error;
    }
    $insertQuery->close();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Library Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE 4 | Signup Page" />
    <meta name="author" content="Umme Aiman Mahima, Fahima Khanam Borsha, Anika Shormila" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."
    />
    <meta
      name="keywords"
      content="Library, Management, System, Library Management System, Library Management"
    />

    <style>
      body{
        background: url('./bg.jpg') no-repeat center center fixed;
        background-size: cover;
      }
    </style>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="./admin/dist/css/adminlte.css" />
  </head>
  <body class="login-page bg-body-secondary">
    <div class="login-box">
      <div class="login-logo">
        <a href="./index.php" class="text-light">Library Management System</a>
      </div>
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign up as a student</p>
          <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
          <?php endif; ?>
          <form id="signup-form" method="post" enctype="multipart/form-data">
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Full Name" id="name" name="name" required />
              <div class="input-group-text"><span class="bi bi-person"></span></div>
            </div>
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Username" id="username" name="username" required />
              <div class="input-group-text"><span class="bi bi-person-circle"></span></div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" placeholder="Password" id="password" name="password" required />
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>
            <div class="input-group mb-3">
              <input type="email" class="form-control" placeholder="Email" id="email" name="email" required />
              <div class="input-group-text"><span class="bi bi-envelope"></span></div>
            </div>
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Phone" id="phone" name="phone" required />
              <div class="input-group-text"><span class="bi bi-phone"></span></div>
            </div>
            <div class="input-group mb-3">
              <textarea class="form-control" placeholder="Address" id="address" name="address" required></textarea>
              <div class="input-group-text"><span class="bi bi-geo-alt"></span></div>
            </div>
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Department" id="dept" name="dept" required />
              <div class="input-group-text"><span class="bi bi-building"></span></div>
            </div>
            <div class="mb-3">
              <label for="photo" class="form-label">Photo</label>
              <input type="file" class="form-control" id="photo" name="photo" accept="image/*" />
            </div>
            <div class="row">
              <div class="col-8">
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary" id="signUpBtn">Sign Up</button>
                </div>
              </div>
            </div>
          </form>
          <p class="mt-4 mb-1">
            <a href="index.php" class="text-center">Already have an account? Sign in here</a>
          </p>
        </div>
      </div>
    </div>

    <!--begin::Footer-->
    <footer class="app-footer mt-4">
            <!--begin::Copyright-->
            <strong>
              Developed by Umme Aiman Mahima, Fahima Khanam Borsha, Anika Shormila.
            </strong>
            <!--end::Copyright-->
    </footer>
      <!--end::Footer-->
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
  </body>
</html>
<?php
$conn->close();
?>