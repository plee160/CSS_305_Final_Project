<?php
/*
I certify that the PHP file I am submitting is all my own work.
None of it is copied from any source or any person.
Signed: Samuel Boye
Date: 12/06/2025
Class: CSS 305
File Name: suppliers.php
Assignment: Final Project – Car Parts Catalog
Description: Lists all suppliers with basic information.
*/

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'session_check.php';
require 'db.php';

$sql = "SELECT s.id,
               s.name,
               s.contact_name,
               s.phone,
               s.email,
               COUNT(p.id) AS part_count
        FROM suppliers s
        LEFT JOIN parts p ON p.supplier_id = s.id
        GROUP BY s.id, s.name, s.contact_name, s.phone, s.email
        ORDER BY s.name";

$result    = $conn->query($sql);
$suppliers = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $suppliers[] = $row;
    }
} else {
    die('Query error: ' . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BoyeLeeNaga Shop – Suppliers</title>
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
        <a href="suppliers.php" class="nav-link active">Suppliers</a>
        <a href="logout.php" class="nav-link">Logout</a>
    </nav>

</header>

<main class="layout">

    <!-- Left: title / description -->
    <section class="hero">
        <h1 class="hero-title">Suppliers</h1>

        <p class="hero-subtitle">
            View all suppliers that provide parts to the shop. From here you can
            see who supplies which parts and jump into the catalog filtered by
            a specific supplier.
        </p>
    </section>

    <!-- Right: suppliers table in a panel -->
    <!-- NOTE: added suppliers-panel class here -->
    <section class="panel panel-table suppliers-panel">

        <h2 class="panel-title">Supplier list</h2>
        <p class="panel-text">
            Select “View catalog” to see all parts from a single supplier.
        </p>

        <?php if (empty($suppliers)): ?>

            <p>No suppliers found.</p>

        <?php else: ?>

            <section class="panel panel">
                <table>
                    <thead>
                    <tr>
                        <th>Supplier</th>
                        <th>Contact</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th># of Parts</th>
                        <th>Catalog</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($suppliers as $supplier): ?>
                        <tr>
                            <td><?= htmlspecialchars($supplier['name']) ?></td>
                            <td><?= htmlspecialchars($supplier['contact_name']) ?></td>
                            <td><?= htmlspecialchars($supplier['phone']) ?></td>
                            <td><?= htmlspecialchars($supplier['email']) ?></td>
                            <td><?= (int)$supplier['part_count'] ?></td>
                            <td>
                                <a href="catalog.php?supplier_id=<?= (int)$supplier['id'] ?>"
                                   class="link-button">
                                    View catalog
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
