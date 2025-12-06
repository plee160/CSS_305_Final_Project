<?php
/*
I certify that the PHP file I am submitting is all my own work.
None of it is copied from any source or any person.
Signed: Samuel Boye
Date: 12/06/2025
Class: CSS 305
File Name: parts-details.php
Assignment: Final Project – Car Parts Catalog
Description: Shows full details for a single part.
*/

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'session_check.php';
require 'db.php';

$partId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$part   = null;
$error  = null;

if ($partId <= 0) {
    $error = 'Invalid part ID.';
} else {

    $sql = "SELECT p.id,
                   p.part_name,
                   p.description,
                   p.price,
                   p.quantity,
                   p.image_path,
                   c.name  AS category_name,
                   s.name  AS supplier_name,
                   s.phone AS supplier_phone,
                   s.email AS supplier_email
            FROM parts p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN suppliers s ON p.supplier_id = s.id
            WHERE p.id = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param('i', $partId);
    $stmt->execute();
    $result = $stmt->get_result();
    $part   = $result->fetch_assoc();

    if (!$part) {
        $error = 'Part not found.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BoyeLeeNaga Shop – Part Details</title>
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
        <a href="catalog.php" class="nav-link">Catalog</a>
        <a href="suppliers.php" class="nav-link">Suppliers</a>
        <a href="logout.php" class="nav-link">Logout</a>
    </nav>

</header>

<main class="layout">

    <!-- Left: title / back link -->
    <section class="hero">
        <h1 class="hero-title">Part details</h1>

        <p class="hero-subtitle">
            View specific information about a single part, including category,
            supplier contact, and current quantity in stock.
        </p>

        <p>
            <a href="catalog.php" class="btn btn-ghost">← Back to catalog</a>
        </p>
    </section>

    <!-- Right: detail card -->
    <section class="panel panel-table suppliers-panel">

        <?php if ($error): ?>

            <h2 class="panel-title">Error</h2>
            <p class="panel-text"><?= htmlspecialchars($error) ?></p>
            <p><a href="catalog.php" class="link-button">Return to catalog</a></p>

        <?php else: ?>

            <h2 class="panel-title"><?= htmlspecialchars($part['part_name']) ?></h2>

            <p class="panel-text">
                <strong>Category:</strong>
                <?= htmlspecialchars($part['category_name'] ?? '—') ?>
            </p>

            <?php if (!empty($part['image_path'])): ?>
                <p>
                    <img src="images/<?= htmlspecialchars($part['image_path']) ?>"
                         alt="<?= htmlspecialchars($part['part_name']) ?>"
                         style="max-width: 320px; border-radius: 18px;">
                </p>
            <?php endif; ?>

            <section>
                <h3>Description</h3>
                <p><?= nl2br(htmlspecialchars($part['description'])) ?></p>
            </section>

            <section>
                <h3>Inventory &amp; Pricing</h3>
                <p>
                    <strong>Price:</strong>
                    $<?= number_format((float)$part['price'], 2) ?><br>
                    <strong>Quantity in stock:</strong>
                    <?= (int)$part['quantity'] ?>
                </p>
            </section>

            <section>
                <h3>Supplier</h3>
                <?php if ($part['supplier_name']): ?>
                    <p>
                        <strong>Name:</strong>
                        <?= htmlspecialchars($part['supplier_name']) ?><br>
                        <strong>Phone:</strong>
                        <?= htmlspecialchars($part['supplier_phone']) ?><br>
                        <strong>Email:</strong>
                        <?= htmlspecialchars($part['supplier_email']) ?>
                    </p>
                <?php else: ?>
                    <p>No supplier information available for this part.</p>
                <?php endif; ?>
            </section>

        <?php endif; ?>

    </section>

</main>

<footer class="site-footer">
    <span>© <?php echo date('Y'); ?> AutoCore · CSS 305 Final Project ·</span>
</footer>

</body>
</html>
