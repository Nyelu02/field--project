<?php
include("dbconnection.php");

// Retrieve action and reportId from the request
$data = json_decode(file_get_contents('php://input'), true);
$action = $data['action'];
$reportId = $data['reportId'];

try {
    // Establish a database connection
    $con = dbconnection();

    // Prepare the SQL statement
    $sql = "UPDATE report SET status=? WHERE id=?";
    $stmt = mysqli_prepare($con, $sql);

    // Bind parameters and execute the statement
    mysqli_stmt_bind_param($stmt, 'si', $action, $reportId);
    $success = mysqli_stmt_execute($stmt);

    // Check if the statement execution was successful
    if (!$success) {
        throw new Exception(mysqli_error($con));
    }

    // Close the statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($con);

    // Return a response to indicate success
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Return an error response if something goes wrong
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
