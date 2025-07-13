<!DOCTYPE html>
<html>
<?php include 'includes/head.php'; ?>
<body>
    <?php include 'includes/topbar.php'; ?>
    <?php include 'includes/menu.php'; ?>

    <div class="container">
        <h2>Inventory</h2>
        <!-- Add Inventory Form -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add Inventory</h5>
                <form action="add_inventory.php" method="post">
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product</label>
                        <select class="form-select" id="product_id" name="product_id" required>
                            <option selected>Choose...</option>
                            <?php
                            include 'includes/config.php';
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $sql = "SELECT id, name FROM products";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                                }
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <select class="form-select" id="location" name="location" required>
                            <option selected>Choose...</option>
                            <option value="shelf">Shelf</option>
                            <option value="warehouse">Warehouse</option>
                            <option value="transit">In Transit</option>
                            <option value="delivery">On Delivery</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Inventory</button>
                </form>
            </div>
        </div>

        <!-- Inventory List -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Inventory List</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Location</th>
                            <th scope="col">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT inventory.id, products.name, inventory.quantity, inventory.location, inventory.created_at
                                FROM inventory
                                JOIN products ON inventory.product_id = products.id
                                ORDER BY inventory.created_at DESC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $row["id"] . "</th>";
                                echo "<td>" . $row["name"] . "</td>";
                                echo "<td>" . $row["quantity"] . "</td>";
                                echo "<td>" . $row["location"] . "</td>";
                                echo "<td>" . $row["created_at"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No inventory found</td></tr>";
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
