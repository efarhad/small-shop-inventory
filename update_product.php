<?php
include 'includes/config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];
$sku = $_POST['sku'];
$expiry_date = $_POST['expiry_date'];

$sql = "UPDATE products SET name='$name', description='$description', sku='$sku', expiry_date='$expiry_date' WHERE id=$id";

if ($_FILES['image']['name']) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $image = $target_file;

    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        } else {
            echo "File is not an image.";
            exit();
        }
    }
    $sql = "UPDATE products SET name='$name', description='$description', sku='$sku', image='$image', expiry_date='$expiry_date' WHERE id=$id";
}

if ($conn->query($sql) === TRUE) {
    header("Location: products.php");
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
