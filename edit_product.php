<!DOCTYPE html>
<html>
<?php include 'includes/head.php'; ?>
<body>
    <?php include 'includes/topbar.php'; ?>
    <?php include 'includes/menu.php'; ?>

    <div class="container">
        <h2>Edit Product</h2>
        <?php
        include 'includes/config.php';
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $id = $_GET['id'];
        $sql = "SELECT id, name, description, sku, image, expiry_date FROM products WHERE id=$id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        ?>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Product</h5>
                <form action="update_product.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo $row['description']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="sku" class="form-label">SKU</label>
                        <input type="text" class="form-control" id="sku" name="sku" value="<?php echo $row['sku']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Product Image</label>
                        <input class="form-control" type="file" id="image" name="image">
                        <img src="<?php echo $row['image']; ?>" width="100" />
                    </div>
                    <div class="mb-3">
                        <label for="expiry_date" class="form-label">Expiry Date</label>
                        <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="<?php echo $row['expiry_date']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </form>
            </div>
        </div>
    </div>

    <?php
    $conn->close();
    include 'includes/footer.php';
    include 'includes/copyright.php';
    ?>
</body>
</html>
