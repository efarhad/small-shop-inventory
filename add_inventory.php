<?php
include 'includes/config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];
$location = $_POST['location'];

$sql = "INSERT INTO inventory (product_id, quantity, location)
VALUES ('$product_id', '$quantity', '$location')";

if ($conn->query($sql) === TRUE) {
    // Check for low stock
    $sql_check_stock = "SELECT SUM(quantity) as total_quantity FROM inventory WHERE product_id = $product_id";
    $result = $conn->query($sql_check_stock);
    $row = $result->fetch_assoc();
    $total_quantity = $row['total_quantity'];

    if ($total_quantity < 10) {
        $message = "Low stock for product ID $product_id";
        $sql_alert = "INSERT INTO alerts (product_id, message) VALUES ('$product_id', '$message')";
        $conn->query($sql_alert);
    }

    header("Location: inventory.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
