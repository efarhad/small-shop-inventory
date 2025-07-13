<!DOCTYPE html>
<html>
<?php include 'includes/head.php'; ?>
<body>
    <?php include 'includes/topbar.php'; ?>
    <?php include 'includes/menu.php'; ?>

    <div class="container">
        <h2>Products</h2>
        <!-- Add Product Form -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add New Product</h5>
                <form action="add_product.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="sku" class="form-label">SKU</label>
                        <input type="text" class="form-control" id="sku" name="sku" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Product Image</label>
                        <input class="form-control" type="file" id="image" name="image">
                    </div>
                    <div class="mb-3">
                        <label for="expiry_date" class="form-label">Expiry Date</label>
                        <input type="date" class="form-control" id="expiry_date" name="expiry_date">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
            </div>
        </div>

        <!-- Product List -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Product List</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">SKU</th>
                            <th scope="col">Expiry Date</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'includes/config.php';
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT id, name, sku, expiry_date FROM products";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $row["id"] . "</th>";
                                echo "<td>" . $row["name"] . "</td>";
                                echo "<td>" . $row["sku"] . "</td>";
                                echo "<td>" . $row["expiry_date"] . "</td>";
                                echo "<td>";
                                echo "<a href='edit_product.php?id=" . $row["id"] . "' class='btn btn-primary btn-sm'>Edit</a>";
                                echo "<a href='delete_product.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm'>Delete</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No products found</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/copyright.php'; ?>
</body>
</html>
