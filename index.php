<?php
    include './db.php'; 

?>
<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Library Student Portal - Books</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" />
    <style>
      body {
        background: linear-gradient(90deg, #1a1a1a 50%, #a100ff 50%);
        min-height: 100vh;
        padding-top: 70px;
      }
      .books-container {
        /* max-width: 900px; */
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
      }
      .navbar {
        z-index: 1000;
      }
      .table {
        background-color: #2d2d2d;
        color: #fff;
      }
      .table th {
        background-color: #1a1a1a;
        color: #fff;
      }
      .table td {
        color: #000;
      }
      .table-hover tbody tr:hover {
        background-color: #3a3a3a;
      }
      .book-image {
        width: 50px;
        height: auto;
        object-fit: cover;
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
              <a class="nav-link active" href="./index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./stafflogin.php">Staff Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./studentlogin.php">Student Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./register.php">Student Signup</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="books-container container-fluid container-md p-0 my-3">
      <div class="row g-0 h-100">
        <div class="col-md-12 bg-dark text-white p-4 p-md-5 d-flex flex-column justify-content-center">
          <h2 class="mb-4">All Books List</h2>
          <p class="mb-4">Browse available books in the library</p>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Book Name</th>
                  <th>Author</th>
                  <th>Publication</th>
                  <th>Quantity</th>
                  <th>Available At Library</th>
                  <th>Image</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $bookQuery = $conn->prepare("SELECT * FROM books");
                  $bookQuery->execute();
                  $bookResult = $bookQuery->get_result();

                  if ($bookResult->num_rows > 0) {
                    while ($book = $bookResult->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . htmlspecialchars($book['books_name']) . "</td>";
                      echo "<td>" . htmlspecialchars($book['books_author_name']) . "</td>";
                      echo "<td>" . htmlspecialchars($book['books_publication_name']) . "</td>";
                      echo "<td>" . htmlspecialchars($book['books_quantity']) . "</td>";
                      echo "<td>" . htmlspecialchars($book['books_stock']) . "</td>";
                      echo "<td>";
                      if (!empty($book['books_image']) && file_exists("../" . $book['books_image'])) {
                        echo "<img src='../" . htmlspecialchars($book['books_image']) . "' alt='Book Image' class='book-image'>";
                      } else {
                        echo "No image";
                      }
                      echo "</td>";
                      echo "</tr>";
                    }
                  } else {
                    echo "<tr><td colspan='9' class='text-center'>No books found</td></tr>";
                  }
                  $bookQuery->close();
                ?>
              </tbody>
            </table>
          </div>
        </div>
        
      </div>
    </div>

    <footer class="text-white text-center mt-4">
      <strong>Developed by Umme Aiman Mahima, Fahima Khanam Borsha, Anika Shormila.</strong>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  </body>
</html>
