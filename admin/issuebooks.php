
<?php
session_start();
include '../db.php'; 

if (isset($_COOKIE['rememberMe'])) {
  $token = $_COOKIE['rememberMe'];
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
              <div class="col-sm-6"><h3 class="mb-0">Issue Books</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Issue Books</li>
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
                    <h3 class="card-title">Search Users</h3>
                  </div>
                  <div class="card-body">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" id="userSearch" placeholder="Search by name, email, phone, or unique ID">
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="searchBtn">Search</button>
                      </div>
                    </div>
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Unique ID</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Department</th>
                          <th>Designation</th>
                          <th>Issued Books</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody id="searchResults"></tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--end::App Content-->
      </main>

      <!-- Issue Status Modal -->
      <div class="modal fade" id="issueStatusModal" tabindex="-1" aria-labelledby="issueStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="issueStatusModalLabel">Issue Status</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Book Name</th>
                    <th>Issue Date</th>
                    <th>Last Date to Return</th>
                  </tr>
                </thead>
                <tbody id="issueStatusContent"></tbody>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Issue Book Modal -->
      <div class="modal fade" id="issueBookModal" tabindex="-1" aria-labelledby="issueBookModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="issueBookModalLabel">Issue Book for User ID: <span id="issueBookUserId"></span></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="input-group mb-3">
                <input type="text" class="form-control" id="bookSearch" placeholder="Search by book name, author, or publication">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" id="bookSearchBtn">Search</button>
                </div>
              </div>
              <div id="issueMessage" class="alert" style="display: none;"></div>
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Book Name</th>
                    <th>Author</th>
                    <th>Publication</th>
                    <th>Stock</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="bookSearchResults"></tbody>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      
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

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

    <script>
      $(document).ready(function() {
        function searchUsers(query) {
          $.ajax({
            url: 'search_users.php',
            type: 'POST',
            data: { search: query },
            success: function(response) {
              $('#searchResults').html(response);
            },
            error: function() {
              $('#searchResults').html('<tr><td colspan="8">Error loading results</td></tr>');
            }
          });
        }

        $('#searchBtn').click(function() {
          var query = $('#userSearch').val();
          searchUsers(query);
        });

        $('#userSearch').on('keyup', function(e) {
          if (e.key === 'Enter') {
            searchUsers($(this).val());
          }
        });

        $(document).on('click', '.issue-book-btn', function() {
          var userId = $(this).data('userid');
          $('#modalUserId').text(userId);
          
          // AJAX call to fetch issue status
          $.ajax({
            url: 'search_users.php',
            type: 'POST',
            data: { user_id: userId, action: 'get_issue_status' },
            success: function(response) {
              $('#issueStatusContent').html(response);
            },
            error: function() {
              $('#issueStatusContent').html('<tr><td colspan="3">Error loading issue status</td></tr>');
            }
          });
          
          $('#issueStatusModal').modal('show');
        });

        $(document).on('click', '.issue-new-book-btn', function() {
          var userId = $(this).data('userid');
          $('#issueBookUserId').text(userId);
          $('#bookSearchResults').html('');
          $('#bookSearch').val('');
          $('#issueMessage').hide();
          $('#issueBookModal').modal('show');
        });

        $('#bookSearchBtn').click(function() {
          var query = $('#bookSearch').val();
          var userId = $('#issueBookUserId').text();
          searchBooks(query, userId);
        });

        $('#bookSearch').on('keyup', function(e) {
          if (e.key === 'Enter') {
            var query = $(this).val();
            var userId = $('#issueBookUserId').text();
            searchBooks(query, userId);
          }
        });

        function searchBooks(query, userId) {
          $.ajax({
            url: 'search_users.php',
            type: 'POST',
            data: { book_search: query, user_id: userId, action: 'search_books' },
            success: function(response) {
              $('#bookSearchResults').html(response);
              $('#issueMessage').hide();
            },
            error: function() {
              $('#bookSearchResults').html('<tr><td colspan="5">Error loading book results</td></tr>');
            }
          });
        }

        $(document).on('click', '.issue-book-action-btn', function() {
          var bookId = $(this).data('bookid');
          var userId = $('#issueBookUserId').text();
          
          $.ajax({
            url: 'search_users.php',
            type: 'POST',
            data: { book_id: bookId, user_id: userId, action: 'issue_book' },
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                $('#issueMessage').removeClass('alert-danger').addClass('alert-success')
                  .text('Book issued successfully!').show();
                $('#bookSearchResults').html('');
                $('#bookSearch').val('');
              } else {
                $('#issueMessage').removeClass('alert-success').addClass('alert-danger')
                  .text(response.message).show();
              }
            },
            error: function() {
              $('#issueMessage').removeClass('alert-success').addClass('alert-danger')
                .text('Error issuing book').show();
            }
          });
        });
      });
    </script>
  
    
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
