<!DOCTYPE html>
<html>
<?php include 'includes/head.php'; ?>
<body>
    <?php include 'includes/topbar.php'; ?>
    <?php include 'includes/menu.php'; ?>

    <div class="container">
        <h2>Reports</h2>

        <!-- Expiring Products -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Expiring Soon</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product</th>
                            <th scope="col">Expiry Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT id, name, expiry_date
                                FROM products
                                WHERE expiry_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
                                ORDER BY expiry_date ASC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $row["id"] . "</th>";
                                echo "<td>" . $row["name"] . "</td>";
                                echo "<td>" . $row["expiry_date"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No expiring products found</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Shortage Alerts -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Shortage Alerts</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product</th>
                            <th scope="col">Message</th>
                            <th scope="col">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'includes/config.php';
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT alerts.id, products.name, alerts.message, alerts.created_at
                                FROM alerts
                                JOIN products ON alerts.product_id = products.id
                                ORDER BY alerts.created_at DESC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $row["id"] . "</th>";
                                echo "<td>" . $row["name"] . "</td>";
                                echo "<td>" . $row["message"] . "</td>";
                                echo "<td>" . $row["created_at"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No alerts found</td></tr>";
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
