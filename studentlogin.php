<?php
session_start();
include './db.php';

if (isset($_SESSION['user_id'])) {
  header("Location: admin/index.php");
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Library Student Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" />
    <style>
      body {
        background: linear-gradient(90deg, #1a1a1a 50%, #a100ff 50%);
        min-height: 100vh;
        padding-top: 70px; /* Add padding to prevent content overlap with fixed navbar */
      }
      .login-container {
        max-width: 900px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
      }
      .form-control {
        background-color: #2d2d2d;
        border: none;
        color: #fff;
      }
      .form-control::placeholder {
        color: #ccc;
      }
      .input-group-text {
        background-color: #2d2d2d;
        color: #fff;
        border: none;
      }
      .navbar {
        z-index: 1000; /* Ensure navbar stays above other content */
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
              <a class="nav-link" aria-current="page" href="./index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./stafflogin.php">Staff Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="./studentlogin.php">Student Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./register.php">Student Signup</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="login-container container-fluid container-md p-0 my-3">
      <div class="row g-0 h-100">
        <div class="col-md-6 bg-dark text-white p-4 p-md-5 d-flex flex-column justify-content-center">
          <h2 class="mb-4">Login</h2>
          <p class="mb-4">Student, Enter your account details</p>
          <form id="login-form" method="post">
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Username" id="username" required>
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" placeholder="Password" id="password" required>
              <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
            </div>
            <button type="submit" class="btn btn-primary w-100" style="background-color: #a100ff; border: none;" id="signInBtn">Login</button>
            <p class="mt-3 text-center">
              Don't have an account? <a href="./register.php" class="text-primary" style="color: #a100ff !important;">Sign up</a>
            </p>
          </form>
        </div>
        <div class="col-md-6 bg-primary text-white p-4 p-md-5 d-none d-md-flex flex-column justify-content-center align-items-center" style="background-color: #a100ff;">
          <h1 class="fs-1 fw-bold mb-3 text-center">Welcome to Library Student Portal</h1>
          <p class="fs-6 opacity-75 text-center">Login to access your account</p>
          <img src="./std.png" class="img-fluid mt-3" style="max-width: 200px;" alt="Student illustration">
        </div>
      </div>
    </div>

    <footer class="text-white text-center mt-4 mb-4">
      <strong>Developed by Umme Aiman Mahima, Fahima Khanam Borsha, Anika Shormila.</strong>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="./stdloginajax.js"></script>
  </body>
</html>