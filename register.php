<?php
session_start();
include './db.php'; 

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
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
    <title>Library Student Portal - Signup</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" />
    <style>
      body {
        background: linear-gradient(90deg, #1a1a1a 50%, #a100ff 50%);
        min-height: 100vh;
        padding-top: 70px;
      }
      .signup-container {
        max-width: 900px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
      }
      .form-control, .form-control-file {
        background-color: #2d2d2d;
        border: none;
        color: #fff;
      }
      .form-control::placeholder, .form-control-file::placeholder {
        color: #ccc;
      }
      .input-group-text {
        background-color: #2d2d2d;
        color: #fff;
        border: none;
      }
      .navbar {
        z-index: 1000;
      }
      textarea.form-control {
        resize: vertical;
        min-height: 100px;
      }
      .form-label {
        color: #fff;
      }
    </style>
  </head>
  <body class="d-flex flex-column justify-content-center align-items-center">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="./index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./stafflogin.php">Staff Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./studentlogin.php">Student Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="./register.php">Student Signup</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="signup-container container-fluid container-md p-0 my-3">
      <div class="row g-0 h-100">
        <div class="col-md-6 bg-dark text-white p-4 p-md-5 d-flex flex-column justify-content-center">
          <h2 class="mb-4">Student Signup</h2>
          <p class="mb-4">Create your student account</p>
          <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
          <?php endif; ?>
          <form id="signup-form" method="post" enctype="multipart/form-data">
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Full Name" id="name" name="name" required />
              <span class="input-group-text"><i class="bi bi-person"></i></span>
            </div>
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Username" id="username" name="username" required />
              <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" placeholder="Password" id="password" name="password" required />
              <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
            </div>
            <div class="input-group mb-3">
              <input type="email" class="form-control" placeholder="Email" id="email" name="email" required />
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            </div>
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Phone" id="phone" name="phone" required />
              <span class="input-group-text"><i class="bi bi-phone"></i></span>
            </div>
            <div class="input-group mb-3">
              <textarea class="form-control" placeholder="Address" id="address" name="address" required></textarea>
              <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
            </div>
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Department" id="dept" name="dept" required />
              <span class="input-group-text"><i class="bi bi-building"></i></span>
            </div>
            <div class="mb-3">
              <label for="photo" class="form-label">Photo</label>
              <input type="file" class="form-control form-control-file" id="photo" name="photo" accept="image/*" />
            </div>
            <button type="submit" class="btn btn-primary w-100" style="background-color: #a100ff; border: none;" id="signUpBtn">Sign Up</button>
            <p class="mt-3 text-center">
              Already have an account? <a href="./studentlogin.php" class="text-primary" style="color: #a100ff !important;">Sign in</a>
            </p>
          </form>
        </div>
        <div class="col-md-6 bg-primary text-white p-4 p-md-5 d-none d-md-flex flex-column justify-content-center align-items-center" style="background-color: #a100ff;">
          <h1 class="fs-1 fw-bold mb-3 text-center">Welcome to Library Student Portal</h1>
          <p class="fs-6 opacity-75 text-center">Sign up to create your account</p>
          <img src="./std.png" class="img-fluid mt-3" style="max-width: 200px;" alt="Student illustration">
        </div>
      </div>
    </div>

    <footer class="text-white text-center mt-4 mb-4">
      <strong>Developed by Umme Aiman Mahima, Fahima Khanam Borsha, Anika Shormila.</strong>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  </body>
</html>
<?php
$conn->close();
?>