<?php
/*
I certify that the PHP file I am submitting is all my own work.
None of it is copied from any source or any person.
Signed: Samuel Boye
Date: 12/06/2025
Class: CSS 305
File Name: catalog.php
Assignment: Final Project – Car Parts Catalog
Description: Main catalog page that lists all car parts.
*/

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'session_check.php';
require 'db.php';

// Optional filter by supplier_id from query string
$supplierId = isset($_GET['supplier_id']) ? (int) $_GET['supplier_id'] : 0;
$parts      = [];

if ($supplierId > 0) {
    $sql = "SELECT p.id,
                   p.part_name,
                   p.price,
                   p.quantity,
                   c.name AS category_name,
                   s.name AS supplier_name
            FROM parts p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN suppliers s ON p.supplier_id = s.id
            WHERE p.supplier_id = ?
            ORDER BY p.part_name";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT p.id,
                   p.part_name,
                   p.price,
                   p.quantity,
                   c.name AS category_name,
                   s.name AS supplier_name
            FROM parts p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN suppliers s ON p.supplier_id = s.id
            ORDER BY p.part_name";

    $result = $conn->query($sql);
}

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $parts[] = $row;
    }
} else {
    die('Query error: ' . $conn->error);
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
        <a href="index.html" class="nav-link">Home</a>
        <a href="catalog.php" class="nav-link active">Catalog</a>
        <a href="suppliers.php" class="nav-link">Suppliers</a>
        <a href="logout.php" class="nav-link">Logout</a>
    </nav>

</header>

<main class="layout">

    <!-- Left: page title and description -->
    <section class="hero">
        <h1 class="hero-title">Parts catalog</h1>

        <p class="hero-subtitle">
            Browse all available parts for the shop. Select a part to see more
            details including description, price, quantity, and supplier.
        </p>

        <?php if ($supplierId > 0): ?>
            <p class="hero-subtitle">
                Showing parts from a specific supplier.
                <a href="catalog.php" class="link-button">Clear filter</a>
            </p>
        <?php endif; ?>
    </section>

    <!-- Right: table of parts inside a panel-style card -->
    <section class="panel panel-table parts-panel">

        <h2 class="panel-title">Available parts</h2>
        <p class="panel-text">
            Click “Details” on any item to view full information.
        </p>

        <?php if (empty($parts)): ?>
            <p>No parts found in the catalog.</p>
        <?php else: ?>

            <section class="panel panel-table parts-panel">
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
                    <?php foreach ($parts as $part): ?>
                        <tr>
                            <td><?= htmlspecialchars($part['part_name']) ?></td>
                            <td><?= htmlspecialchars($part['category_name'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($part['supplier_name'] ?? '—') ?></td>
                            <td>$<?= number_format((float)$part['price'], 2) ?></td>
                            <td><?= (int)$part['quantity'] ?></td>
                            <td>
                                <a href="parts-details.php?id=<?= (int)$part['id'] ?>"
                                   class="link-button">
                                    Details
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </section>

        <?php endif; ?>

    </section>

</main>

<footer class="site-footer">
    <span>© <?php echo date('Y'); ?> AutoCore · CSS 305 Final Project ·</span>
</footer>

</body>
</html>
