<?php
include("dbconnection.php");
$con = dbconnection();

// Check if all necessary data is provided
if(isset($_POST["incident_type"]) && isset($_FILES["image"]) && isset($_POST["location"]))
{
    $incidentType = $_POST["incident_type"];
    $location = $_POST["location"];

    // Handle the uploaded image
    $image = $_FILES["image"];
    $imageName = $image["name"];
    $imageTmpName = $image["tmp_name"];

    // Validate and move the uploaded image to the desired directory
    $uploadPath = "upload/";
    $validImageTypes = ["jpg", "jpeg", "png", "gif"]; // Define allowed image file types
    $imageFileType = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

    if (!in_array($imageFileType, $validImageTypes)) {
        $response = ["success" => false, "message" => "Invalid image format"];
    } elseif (!move_uploaded_file($imageTmpName, $uploadPath . $imageName)) {
        $response = ["success" => false, "message" => "Failed to upload image"];
    } else {
        // Insert the incident report data into the database
        $query = "INSERT INTO `report`(`incident_type`, `image_path`, `location`) 
                  VALUES ('$incidentType', '$uploadPath$imageName', '$location')";
        $exe = mysqli_query($con, $query);

        if($exe) {
            $response = ["success" => true, "message" => "Report submitted successfully"];
        } else {
            $response = ["success" => false, "message" => "Failed to submit report"];
        }
    }
} else {
    $response = ["success" => false, "message" => "Incomplete data provided"];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
