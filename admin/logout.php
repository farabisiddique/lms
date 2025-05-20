<?php
session_start();

// Assuming you have a database connection set up
include './db.php';
$type_of_user = $_GET['type'];

$user_id = $_SESSION['user_id'] ?? null; // Get the user ID from the session

// if ($user_id) {
//     $deleteToken = $conn->prepare("DELETE FROM user_tokens WHERE user_id = ?");
//     $deleteToken->bind_param("i", $user_id);
//     $deleteToken->execute();
// }

// Clear the $_SESSION array
$_SESSION = array();

// Destroy the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Clear remember-me cookie
setcookie("rememberMe", "", time() - 3600, "/");

// Redirect to the login page
if($type_of_user == 'staff') {
    $redirect_url = '../stafflogin.php';
} else  {
    $redirect_url = '../studentlogin.php';
} 
header("Location: $redirect_url");
exit();
?>
