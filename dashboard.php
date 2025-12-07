<?php

require 'session_check.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BoyeLeeNaga Shop – Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="body">

<header class="site-header">
    <span class="brand">
        <span class="brand-mark"></span>
        <span class="brand-name">BoyeLeeNaga Shop</span>
    </span>

    <nav class="nav-links">
        <a href="dashboard.php" class="nav-link active">Home</a>
        <a href="catalog.php" class="nav-link">Catalog</a>
        <a href="suppliers.php" class="nav-link">Suppliers</a>
        <a href="users.php" class="nav-link">Users</a>
        <a href="logout.php" class="nav-link">Logout</a>
    </nav>
</header>

<main class="layout">

    <!-- LEFT SIDE: Welcome hero -->
    <section class="hero">
        <h1 class="hero-title">
            Welcome back,
            <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>!
        </h1>

        <p class="hero-subtitle">
            This is your internal dashboard for the BoyeLeeNaga mechanic shop.
            From here you can quickly jump into the parts catalog, view suppliers,
            or manage user accounts.
        </p>

        <section class="hero-actions">
            <a href="catalog.php" class="btn btn-primary">View Catalog</a>
            <a href="suppliers.php" class="btn btn-ghost">View Suppliers</a>
        </section>

        <section class="hero-stats">
            <section class="stat">
                <span class="stat-number">3</span>
                <span class="stat-label">Sample Parts</span>
            </section>
            <section class="stat">
                <span class="stat-number">2</span>
                <span class="stat-label">Suppliers</span>
            </section>
            <section class="stat">
                <span class="stat-number">Users</span>
                <span class="stat-label">Managed here</span>
            </section>
        </section>
    </section>

    <!-- RIGHT SIDE: Quick links panel -->
    <section class="panel panel-table parts-panel">
        <h2 class="panel-title">Quick actions</h2>
        <p class="panel-text">
            Use these shortcuts to move around the internal system.
        </p>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Description</th>
                        <th style="text-align:right;">Go</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Browse parts catalog</td>
                        <td>View all parts, quantities, and suppliers.</td>
                        <td style="text-align:right;">
                            <a href="catalog.php" class="link-button">Open catalog</a>
                        </td>
                    </tr>
                    <tr>
                        <td>View suppliers</td>
                        <td>See supplier contact info and part counts.</td>
                        <td style="text-align:right;">
                            <a href="suppliers.php" class="link-button">Open suppliers</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Manage users</td>
                        <td>Review internal accounts and roles.</td>
                        <td style="text-align:right;">
                            <a href="users.php" class="link-button">Open users</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

</main>

<footer class="site-footer">
    <span>© BoyeLeeNaga · CSS 305 Final Project ·</span>
</footer>

</body>
</html>
