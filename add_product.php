<?php
include 'includes/config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$description = $_POST['description'];
$sku = $_POST['sku'];
$expiry_date = $_POST['expiry_date'];

// File upload handling
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$image = $target_file;

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        echo "File is not an image.";
        exit();
    }
}


$sql = "INSERT INTO products (name, description, sku, image, expiry_date)
VALUES ('$name', '$description', '$sku', '$image', '$expiry_date')";

if ($conn->query($sql) === TRUE) {
    header("Location: products.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
