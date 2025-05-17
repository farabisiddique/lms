<?php
include '../db.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle user search for the main table
    if (isset($_POST['search'])) {
        // Trim the search input to remove extra whitespace
        $search = trim($_POST['search']);
        $output = '';

        // Process search if a term is provided
        if (!empty($search)) {
            // Prepare SQL query to search users and their issued books (only unreturned books)
            $query = $conn->prepare("
                SELECT u.*, 
                       GROUP_CONCAT(CONCAT(b.books_name, ' (Issued: ', ib.issue_date, ')') SEPARATOR '||') as issued_books
                FROM users u
                LEFT JOIN issue_book ib ON u.id = ib.user_id AND ib.return_date IS NULL
                LEFT JOIN books b ON ib.book_id = b.id
                WHERE u.name LIKE ? OR 
                      u.username LIKE ? OR 
                      u.email LIKE ? OR 
                      u.phone LIKE ? OR 
                      u.uniqueid LIKE ? OR 
                      u.dept LIKE ? OR 
                      u.designation LIKE ?
                GROUP BY u.id
            ");
            
            // Bind search parameters to prevent SQL injection
            $searchParam = "%$search%";
            $query->bind_param("sssssss", $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam);
            $query->execute();
            $result = $query->get_result();

            // Generate table rows for search results
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $output .= '<tr>';
                    $output .= '<td>' . htmlspecialchars($row['uniqueid']) . '</td>';
                    $output .= '<td>' . htmlspecialchars($row['name']) . '</td>';
                    $output .= '<td>' . htmlspecialchars($row['email']) . '</td>';
                    $output .= '<td>' . htmlspecialchars($row['phone']) . '</td>';
                    $output .= '<td>' . htmlspecialchars($row['dept']) . '</td>';
                    $output .= '<td>' . htmlspecialchars($row['designation']) . '</td>';
                    $output .= '<td>';
                    if ($row['issued_books']) {
                        // Split issued books and display each on a new line
                        $books = explode('||', $row['issued_books']);
                        foreach ($books as $book) {
                            $output .= '<div>' . htmlspecialchars($book) . '</div>';
                        }
                    } else {
                        $output .= 'No books issued';
                    }
                    $output .= '</td>';
                    $output .= '<td>';
                    $output .= '<button class="btn btn-primary issue-book-btn mb-2" data-userid="' . $row['id'] . '">Check Issue Status</button>';
                    $output .= '<button class="btn btn-success issue-new-book-btn" data-userid="' . $row['id'] . '">Issue Book</button>';
                    $output .= '</td>';
                    $output .= '</tr>';
                }
            } else {
                $output .= '<tr><td colspan="8">No users found</td></tr>';
            }
        } else {
            $output .= '<tr><td colspan="8">Please enter a search term</td></tr>';
        }

        // Output the generated HTML table rows
        echo $output;
        $query->close();
    }
    // Handle request to fetch issue status for a user (Check Issue Status modal)
    elseif (isset($_POST['action']) && $_POST['action'] === 'get_issue_status' && isset($_POST['user_id'])) {
        // Get user ID and initialize output
        $user_id = intval($_POST['user_id']);
        $output = '';

        // Prepare SQL query to fetch unreturned issued books for the user
        $query = $conn->prepare("
            SELECT b.books_name, ib.issue_date, ib.last_date_to_return
            FROM issue_book ib
            JOIN books b ON ib.book_id = b.id
            WHERE ib.user_id = ? AND ib.return_date IS NULL
        ");
        $query->bind_param("i", $user_id);
        $query->execute();
        $result = $query->get_result();

        // Generate table rows for issued books
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $output .= '<tr>';
                $output .= '<td>' . htmlspecialchars($row['books_name']) . '</td>';
                $output .= '<td>' . htmlspecialchars($row['issue_date']) . '</td>';
                $output .= '<td>' . htmlspecialchars($row['last_date_to_return']) . '</td>';
                $output .= '</tr>';
            }
        } else {
            $output .= '<tr><td colspan="3">No books currently issued to this user</td></tr>';
        }

        // Output the generated HTML table rows
        echo $output;
        $query->close();
    }
    // Handle book search for issuing a new book (Issue Book modal)
    elseif (isset($_POST['action']) && $_POST['action'] === 'search_books' && isset($_POST['book_search'])) {
        // Trim the book search input and get user ID
        $search = trim($_POST['book_search']);
        $user_id = intval($_POST['user_id']);
        $output = '';

        // Process book search if a term is provided
        if (!empty($search)) {
            // Prepare SQL query to find books not currently issued to the user
            $query = $conn->prepare("
                SELECT b.id, b.books_name, b.books_author_name, b.books_publication_name, b.books_stock
                FROM books b
                LEFT JOIN issue_book ib ON b.id = ib.book_id AND ib.user_id = ? AND ib.return_date IS NULL
                WHERE (b.books_name LIKE ? OR 
                       b.books_author_name LIKE ? OR 
                       b.books_publication_name LIKE ?)
                AND ib.book_id IS NULL
            ");
            
            // Bind parameters to prevent SQL injection
            $searchParam = "%$search%";
            $query->bind_param("isss", $user_id, $searchParam, $searchParam, $searchParam);
            $query->execute();
            $result = $query->get_result();

            // Generate table rows for book search results
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $output .= '<tr>';
                    $output .= '<td>' . htmlspecialchars($row['books_name']) . '</td>';
                    $output .= '<td>' . htmlspecialchars($row['books_author_name']) . '</td>';
                    $output .= '<td>' . htmlspecialchars($row['books_publication_name']) . '</td>';
                    $output .= '<td>' . htmlspecialchars($row['books_stock']) . '</td>';
                    $output .= '<td>';
                    if ($row['books_stock'] > 0) {
                        $output .= '<button class="btn btn-primary issue-book-action-btn" data-bookid="' . $row['id'] . '">Issue</button>';
                    } else {
                        $output .= '<span class="text-danger">Out of stock</span>';
                    }
                    $output .= '</td>';
                    $output .= '</tr>';
                }
            } else {
                $output .= '<tr><td colspan="5">No available books found</td></tr>';
            }
        } else {
            $output .= '<tr><td colspan="5">Please enter a search term</td></tr>';
        }

        // Output the generated HTML table rows
        echo $output;
        $query->close();
    }
    // Handle book issuance request
    elseif (isset($_POST['action']) && $_POST['action'] === 'issue_book' && isset($_POST['book_id']) && isset($_POST['user_id'])) {
        // Get book ID and user ID
        $book_id = intval($_POST['book_id']);
        $user_id = intval($_POST['user_id']);
        $response = ['success' => false, 'message' => ''];

        // Check number of unreturned books for the user
        $query = $conn->prepare("
            SELECT COUNT(*) as unreturned_count
            FROM issue_book
            WHERE user_id = ? AND return_date IS NULL
        ");
        $query->bind_param("i", $user_id);
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();
        $unreturned_count = $row['unreturned_count'];
        $query->close();

        if ($unreturned_count >= 3) {
            $response['message'] = 'Please return previous books. Maximum 3 books allowed at a time.';
        } else {
            // Check if book is in stock
            $query = $conn->prepare("
                SELECT books_stock
                FROM books
                WHERE id = ?
            ");
            $query->bind_param("i", $book_id);
            $query->execute();
            $result = $query->get_result();
            $book = $result->fetch_assoc();
            $query->close();

            if ($book && $book['books_stock'] > 0) {
                // Begin transaction
                $conn->begin_transaction();
                try {
                    // Insert into issue_book table
                    $issue_date = date('Y-m-d');
                    $last_date_to_return = date('Y-m-d', strtotime('+1 month'));
                    $query = $conn->prepare("
                        INSERT INTO issue_book (book_id, user_id, issue_date, last_date_to_return, return_date)
                        VALUES (?, ?, ?, ?, NULL)
                    ");
                    $query->bind_param("iiss", $book_id, $user_id, $issue_date, $last_date_to_return);
                    $query->execute();
                    $query->close();

                    // Update book stock
                    $query = $conn->prepare("
                        UPDATE books
                        SET books_stock = books_stock - 1
                        WHERE id = ?
                    ");
                    $query->bind_param("i", $book_id);
                    $query->execute();
                    $query->close();

                    // Commit transaction
                    $conn->commit();
                    $response['success'] = true;
                } catch (Exception $e) {
                    // Rollback transaction on error
                    $conn->rollback();
                    $response['message'] = 'Error issuing book: ' . $e->getMessage();
                }
            } else {
                $response['message'] = 'Book is out of stock.';
            }
        }

        // Output JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
// Close the database connection
$conn->close();
?>