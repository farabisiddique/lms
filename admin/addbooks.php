
<?php
session_start();
include '../db.php'; 

if (isset($_COOKIE['rememberMe'])) {
  $token = $_COOKIE['rememberMe'];
  $userid = $_SESSION['user_id'];
  
  $userid = $_SESSION['user_id']; 

  $userQuery = $conn->prepare("SELECT * FROM users 
                              WHERE id = ? ");

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

  $message = '';
  $message_type = '';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $books_name = $_POST['books_name'];
      $books_author_name = $_POST['books_author_name'];
      $books_publication_name = $_POST['books_publication_name'];
      $books_price = $_POST['books_price'];
      $books_quantity = $_POST['books_quantity'];
      $books_stock = $books_quantity;

      // Handle file upload
      $upload_dir = '../upload/books/';
      $books_image = '';

      // Create upload directory if it doesn't exist
      if (!is_dir($upload_dir)) {
          mkdir($upload_dir, 0777, true);
      }

      if (isset($_FILES['books_image']) && $_FILES['books_image']['error'] == UPLOAD_ERR_OK) {
          $file = $_FILES['books_image'];
          $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
          $max_size = 5 * 1024 * 1024; // 5MB

          // Validate file type and size
          if (!in_array($file['type'], $allowed_types)) {
              $message = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
              $message_type = "danger";
          } elseif ($file['size'] > $max_size) {
              $message = "File size exceeds 5MB limit.";
              $message_type = "danger";
          } else {
              $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
              $filename = uniqid('book_') . '.' . $ext;
              $destination = $upload_dir . $filename;

              if (move_uploaded_file($file['tmp_name'], $destination)) {
                  $books_image = 'upload/books/' . $filename; // Store relative path
              } else {
                  $message = "Failed to upload image.";
                  $message_type = "danger";
              }
          }
      } else {
          $message = "Please upload an image.";
          $message_type = "danger";
      }

      // If no errors, proceed with database insertion
      if (!$message && $books_image) {
          $stmt = $conn->prepare("INSERT INTO books (books_name, books_image, books_author_name, books_publication_name, books_price, books_quantity, books_stock) VALUES (?, ?, ?, ?, ?, ?, ?)");
          $stmt->bind_param("ssssdii", $books_name, $books_image, $books_author_name, $books_publication_name, $books_price, $books_quantity, $books_stock);

          if ($stmt->execute()) {
              $message = "Book added successfully!";
              $message_type = "success";
          } else {
              $message = "Error adding book: " . $stmt->error;
              $message_type = "danger";
          }

          $stmt->close();
      }
  }



?>
<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Library Management System</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="LMS | Dashboard" />
    
    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="./dist/css/adminlte.css" />
    <!--end::Required Plugin(AdminLTE)-->
    <!-- apexcharts -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />
    <!-- jsvectormap -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
      integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
      crossorigin="anonymous"
    />
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <?php include './header.php'; ?>
      <?php include './sidebar.php'; ?>
      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Add A New Book</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Add A New Book</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-md-6"> 
                <div class="card">
                  <div class="card-header">
                    <h5 class="card-title">Add A New Book</h5>
                  </div>
                  <div class="card-body">
                    <p class="card-text">Fill in the details of the book you want to add.</p>
                    <?php if ($message): ?>
                      <div class="alert alert-<?php echo $message_type; ?> alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <?php echo $message; ?>
                      </div>
                    <?php endif; ?>
                    <form action="" method="POST" enctype="multipart/form-data">
                      <div class="mb-3">
                        <label for="books_name" class="form-label">Book Name</label>
                        <input type="text" class="form-control" id="books_name" name="books_name" required>
                      </div>
                      
                      <div class="mb-3">
                        <label for="books_author_name" class="form-label">Author Name</label>
                        <input type="text" class="form-control" id="books_author_name" name="books_author_name" required>
                      </div>
                      <div class="mb-3">
                        <label for="books_publication_name" class="form-label">Publication Name</label>
                        <input type="text" class="form-control" id="books_publication_name" name="books_publication_name" required>
                      </div>
                      <div class="mb-3">
                        <label for="books_price" class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" id="books_price" name="books_price" required>
                      </div>
                      <div class="mb-3">
                        <label for="books_quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="books_quantity" name="books_quantity" required>
                      </div>
                      
                      <div class="mb-3">
                        <label for="books_image" class="form-label">Book Image</label>
                        <input type="file" class="form-control" id="books_image" name="books_image" accept="image/jpeg,image/png,image/gif" required>
                      </div>
                      <button type="submit" class="btn btn-primary">Add Book</button>
                    </form>
                  </div>
                </div>
              </div>  
            </div>
            <!--end::Row-->
            
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
      <?php include './footer.php'; ?>
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
      integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="./dist/js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
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
    <!--end::OverlayScrollbars Configure-->
    <!-- OPTIONAL SCRIPTS -->
    <!-- sortablejs -->
    <script
      src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
      integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ="
      crossorigin="anonymous"
    ></script>
    
    
    
    <!-- jsvectormap -->
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
    
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
<?php
} else {
  // Redirect to login page if the user is not authenticated
  header("Location: ../index.php");
}
?>
