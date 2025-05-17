<?php
include '../db.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle book return request
    if (isset($_POST['action']) && $_POST['action'] === 'return_book' && isset($_POST['issue_id'])) {
        // Get issue ID
        $issue_id = intval($_POST['issue_id']);
        $response = ['success' => false, 'message' => ''];

        // Begin transaction
        $conn->begin_transaction();
        try {
            // Get book ID for stock update
            $query = $conn->prepare("
                SELECT book_id
                FROM issue_book
                WHERE issue_id = ?
            ");
            $query->bind_param("i", $issue_id);
            $query->execute();
            $result = $query->get_result();
            $row = $result->fetch_assoc();
            $book_id = $row['book_id'];
            $query->close();

            // Update issue_book to set return_date
            $return_date = date('Y-m-d');
            $query = $conn->prepare("
                UPDATE issue_book
                SET return_date = ?
                WHERE issue_id = ?
            ");
            $query->bind_param("si", $return_date, $issue_id);
            $query->execute();
            $query->close();

            // Update book stock
            $query = $conn->prepare("
                UPDATE books
                SET books_stock = books_stock + 1
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
            $response['message'] = 'Error returning book: ' . $e->getMessage();
        }

        // Output JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
// Close the database connection
$conn->close();
?>