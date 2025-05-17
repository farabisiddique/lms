
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


?>
<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Library Management System</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    
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
              <div class="col-sm-6"><h3 class="mb-0">Return Books</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Return Books</li>
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
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Issued Books So Far</h3>
                  </div>
                  <div class="card-body">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" id="bookSearch" placeholder="Search by book name, author, user name, unique ID, designation, department, or dates">
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="searchBtn">Search</button>
                      </div>
                    </div>
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Book Name</th>
                          <th>Author</th>
                          <th>User Name</th>
                          <th>Unique ID</th>
                          <th>Designation</th>
                          <th>Department</th>
                          <th>Issue Date</th>
                          <th>Last Date to Return</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody id="unreturnedBooks">
                        <?php
                        $query = $conn->prepare("
                            SELECT b.books_name, b.books_author_name, u.name, u.uniqueid, u.designation, u.dept, ib.issue_date, ib.last_date_to_return, ib.issue_id as issue_id
                            FROM issue_book ib
                            JOIN books b ON ib.book_id = b.id
                            JOIN users u ON ib.user_id = u.id
                            WHERE ib.return_date IS NULL
                            ORDER BY ib.issue_date
                        ");
                        $query->execute();
                        $result = $query->get_result();
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['books_name']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['books_author_name']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['uniqueid']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['designation']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['dept']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['issue_date']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['last_date_to_return']) . '</td>';
                            echo '<td><button class="btn btn-primary return-book-btn" data-issueid="' . $row['issue_id'] . '">Return To Library</button></td>';
                            echo '</tr>';
                        }
                        $query->close();
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
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

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

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

    <script>
      $(document).ready(function() {
        function searchBooks(query) {
          $.ajax({
            url: 'return_book_process.php',
            type: 'POST',
            data: { search: query, action: 'search_unreturned_books' },
            success: function(response) {
              $('#unreturnedBooks').html(response);
            },
            error: function() {
              $('#unreturnedBooks').html('<tr><td colspan="9">Error loading results</td></tr>');
            }
          });
        }

        $('#searchBtn').click(function() {
          var query = $('#bookSearch').val();
          searchBooks(query);
        });

        $('#bookSearch').on('keyup', function(e) {
          // if (e.key === 'Enter') {
            searchBooks($(this).val());
          // }
        });

        $(document).on('click', '.return-book-btn', function() {
          var issueId = $(this).data('issueid');
          
          $.ajax({
            url: 'return_book_process.php',
            type: 'POST',
            data: { issue_id: issueId, action: 'return_book' },
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                alert('Book returned successfully!');
                location.reload(); // Refresh the table
              } else {
                alert('Error returning book: ' + response.message);
              }
            },
            error: function() {
              alert('Error processing return request');
            }
          });
        });
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
