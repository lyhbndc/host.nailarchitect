<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Database connection
$conn = mysqli_connect("localhost", "u283492965_nailarchitect", "WrongDirection432!", "u283492965_nailarchidb");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get current admin's role
$current_admin_id = $_SESSION['admin_id'];
$role_query = "SELECT role FROM admin_users WHERE id = ?";
$stmt = mysqli_prepare($conn, $role_query);
mysqli_stmt_bind_param($stmt, "i", $current_admin_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$current_admin = mysqli_fetch_assoc($result);

// Get admin ID from query parameter
$admin_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Check permissions: super admin can view all, regular admin can only view self
$is_super_admin = ($current_admin['role'] === 'super_admin');
if (!$is_super_admin && $admin_id != $current_admin_id) {
    http_response_code(403);
    echo json_encode(['error' => 'Permission denied - You can only view your own profile']);
    exit();
}

if ($admin_id > 0) {
    $query = "SELECT * FROM admin_users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $admin_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);
        
        // Remove password from response for security
        unset($admin['password']);
        
        // Return as JSON
        header('Content-Type: application/json');
        echo json_encode($admin);
    } else {
        // Admin not found
        http_response_code(404);
        echo json_encode(['error' => 'Admin not found']);
    }
} else {
    // Invalid ID
    http_response_code(400);
    echo json_encode(['error' => 'Invalid admin ID']);
}

mysqli_close($conn);
?>