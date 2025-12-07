<?php
/*
I certify that the PHP file I am submitting is all my own work.
None of it is copied from any source or any person.
Signed: Samuel Boye
Date: 12/06/2025
Class: CSS 305
File Name: catalog.php
Assignment: Final Project – Car Parts Catalog
Description: Main catalog page listing all car parts with search and filtering.
*/

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'session_check.php';
require 'db.php';

// Read optional supplier filter
$supplierId = isset($_GET['supplier_id']) ? (int) $_GET['supplier_id'] : 0;

// Read search value
$search = isset($_GET['search']) ? trim($_GET['search']) : "";

// Base SQL
$sql = "
    SELECT p.id,
           p.part_name,
           p.price,
           p.quantity,
           c.name AS category_name,
           s.name AS supplier_name
    FROM parts p
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN suppliers s ON p.supplier_id = s.id
    WHERE 1=1
";

// Add supplier filter if provided
$params = [];
$types  = "";

if ($supplierId > 0) {
    $sql .= " AND p.supplier_id = ?";
    $params[] = $supplierId;
    $types   .= "i";
}

// Add search filter if not empty
if ($search !== "") {
    $sql .= " AND p.part_name LIKE ?";
    $params[] = "%" . $search . "%";
    $types   .= "s";
}

$sql .= " ORDER BY p.part_name";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$parts = [];

while ($row = $result->fetch_assoc()) {
    $parts[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BoyeLeeNaga Shop – Catalog</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="body">

<header class="site-header">
    <span class="brand">
        <span class="brand-mark"></span>
        <span class="brand-name">BoyeLeeNaga Shop</span>
    </span>

    <nav class="nav-links">
        <a href="dashboard.php" class="nav-link">Home</a>
        <a href="catalog.php" class="nav-link active">Catalog</a>
        <a href="suppliers.php" class="nav-link">Suppliers</a>
        <a href="users.php" class="nav-link">Users</a>
        <a href="logout.php" class="nav-link">Logout</a>
    </nav>
</header>


<main class="layout">

    <!-- LEFT: page intro -->
    <section class="hero">
        <h1 class="hero-title">Parts Catalog</h1>
        <p class="hero-subtitle">
            Browse all available parts for the shop. Select a part to see more details,
            including price, quantity, supplier, and category.
        </p>
    </section>

    <!-- RIGHT: dashboard-style card with table -->
    <section class="panel panel-table parts-panel">

        <h2 class="panel-title">Available Parts</h2>
        <p class="panel-text">Click "Details" to view full information.</p>

        <!-- 🔍 SEARCH BAR + CLEAR BUTTON -->
        <form method="get" action="catalog.php"
              style="margin-bottom: 1rem; display:flex; gap:0.6rem; align-items:center;">

            <!-- Keep supplier filter if applied -->
            <?php if ($supplierId > 0): ?>
                <input type="hidden" name="supplier_id" value="<?= (int)$supplierId ?>">
            <?php endif; ?>

            <input type="text"
                   name="search"
                   placeholder="Search parts..."
                   value="<?= htmlspecialchars($search) ?>"
                   style="padding:0.55rem 1rem; border-radius:10px;
                          border:1px solid #d1d5db; width:240px; background:white;">

            <button type="submit" class="btn btn-primary small">Search</button>

            <!-- RESET SEARCH & SUPPLIER FILTER -->
            <a href="catalog.php" class="btn btn-ghost small">Clear</a>
        </form>


        <!-- TABLE -->
        <section class="table-wrapper">
            <table>
                <thead>
                <tr>
                    <th>Part</th>
                    <th>Category</th>
                    <th>Supplier</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Details</th>
                </tr>
                </thead>

                <tbody>
                <?php if (empty($parts)): ?>
                    <tr>
                        <td colspan="6">No parts found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($parts as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['part_name']) ?></td>
                            <td><?= htmlspecialchars($row['category_name']) ?></td>
                            <td><?= htmlspecialchars($row['supplier_name']) ?></td>
                            <td>$<?= number_format($row['price'], 2) ?></td>
                            <td><?= (int)$row['quantity'] ?></td>
                            <td>
                                <a href="parts-details.php?id=<?= (int)$row['id'] ?>"
                                   class="link-button">Details</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </section>

    </section>

</main>

<footer class="site-footer">
    <span>© <?= date('Y') ?> AutoCore · CSS 305 Final Project</span>
</footer>

</body>
</html>
