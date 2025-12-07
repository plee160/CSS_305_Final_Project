<?php
/*
I certify that the PHP file I am submitting is all my own work.
None of it is copied from any source or any person.
Signed:
Date: 12/06/2025
Class: CSS 305
File Name: suppliers.php
Assignment: Final Project – Car Parts Catalog
Description: Suppliers CRUD page (create, list, delete) with CSRF protection.
*/

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'session_check.php';
require 'db.php';

// Ensure session exists for CSRF token
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}

$flash_msg  = null;
$flash_error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $csrf  = $_POST['csrf_token'] ?? '';

    // CSRF check
    if (!hash_equals($_SESSION['csrf_token'], $csrf)) {
        $flash_error = 'Invalid request token. Please try again.';
    } else {

        /* CREATE SUPPLIER */
        if ($action === 'create') {
            $name         = trim($_POST['name'] ?? '');
            $contact_name = trim($_POST['contact_name'] ?? '');
            $phone        = trim($_POST['phone'] ?? '');
            $email_raw    = trim($_POST['email'] ?? '');
            $email        = $email_raw !== '' ? filter_var($email_raw, FILTER_VALIDATE_EMAIL) : null;

            if ($name === '') {
                $flash_error = 'Supplier name is required.';
            } elseif ($email_raw !== '' && $email === false) {
                $flash_error = 'Email address is not valid.';
            } else {
                $dup = $conn->prepare('SELECT COUNT(*) AS cnt FROM suppliers WHERE name = ?');
                $dup->bind_param('s', $name);
                $dup->execute();
                $dup_res = $dup->get_result()->fetch_assoc();
                $dup->close();

                if (!empty($dup_res['cnt']) && (int)$dup_res['cnt'] > 0) {
                    $flash_error = 'A supplier with that name already exists.';
                } else {
                    $stmt = $conn->prepare(
                        'INSERT INTO suppliers (name, contact_name, phone, email)
                         VALUES (?, ?, ?, ?)'
                    );
                    $stmt->bind_param('ssss', $name, $contact_name, $phone, $email);

                    if ($stmt->execute()) {
                        $flash_msg = 'Supplier created successfully.';
                        $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
                    } else {
                        $flash_error = 'Failed to create supplier: '
                                     . htmlspecialchars($stmt->error);
                    }
                    $stmt->close();
                }
            }
        }

        /* DELETE SUPPLIER */
        if ($action === 'delete') {
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

            if ($id <= 0) {
                $flash_error = 'Invalid supplier ID.';
            } else {
                $check = $conn->prepare(
                    'SELECT COUNT(*) AS cnt FROM parts WHERE supplier_id = ?'
                );
                $check->bind_param('i', $id);
                $check->execute();
                $cnt = $check->get_result()->fetch_assoc()['cnt'] ?? 0;
                $check->close();

                if ((int)$cnt > 0) {
                    $flash_error = 'Cannot delete supplier: parts are linked to this supplier.';
                } else {
                    $del = $conn->prepare('DELETE FROM suppliers WHERE id = ?');
                    $del->bind_param('i', $id);

                    if ($del->execute()) {
                        $flash_msg = 'Supplier deleted.';
                        $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
                    } else {
                        $flash_error = 'Delete failed: '
                                     . htmlspecialchars($del->error);
                    }
                    $del->close();
                }
            }
        }
    }
}

/* FETCH SUPPLIERS WITH PART COUNTS */
$sql = "
    SELECT s.id,
           s.name,
           s.contact_name,
           s.phone,
           s.email,
           COUNT(p.id) AS part_count
    FROM suppliers s
    LEFT JOIN parts p ON p.supplier_id = s.id
    GROUP BY s.id, s.name, s.contact_name, s.phone, s.email
    ORDER BY s.name ASC
";

$result    = $conn->query($sql);
$suppliers = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $suppliers[] = $row;
    }
} else {
    $flash_error = 'Query error: ' . htmlspecialchars($conn->error);
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
        <a href="dashboard.php" class="nav-link">Home</a>
        <a href="catalog.php" class="nav-link">Catalog</a>
        <a href="suppliers.php" class="nav-link active">Suppliers</a>
        <a href="users.php" class="nav-link">Users</a>
        <a href="logout.php" class="nav-link">Logout</a>
    </nav>
</header>

<main class="layout">

    <!-- Left side: title / description -->
    <section class="hero">
        <h1 class="hero-title">Suppliers</h1>
        <p class="hero-subtitle">
            Add new suppliers, view details, and remove suppliers not in use.
        </p>

        <?php if ($flash_msg): ?>
            <p class="alert success"><?= htmlspecialchars($flash_msg) ?></p>
        <?php endif; ?>

        <?php if ($flash_error): ?>
            <p class="alert error"><?= htmlspecialchars($flash_error) ?></p>
        <?php endif; ?>
    </section>

    <!-- Right side: supplier table + form -->
    <section class="panel panel-table suppliers-panel">

        <h2 class="panel-title">Supplier list</h2>
        <p class="panel-text">
            Select "View catalog" to see parts from a supplier.
        </p>

        <?php if (empty($suppliers)): ?>
            <p>No suppliers found.</p>
        <?php else: ?>

            <!-- Scrollable table, no div -->
            <section class="panel table-wrapper">
                <table>
                    <thead>
                    <tr>
                        <th>Supplier</th>
                        <th>Contact</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th># of Parts</th>
                        <th>Catalog</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($suppliers as $supplier): ?>
                        <tr>
                            <td><?= htmlspecialchars($supplier['name']) ?></td>
                            <td><?= htmlspecialchars($supplier['contact_name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($supplier['phone'] ?? '') ?></td>
                            <td><?= htmlspecialchars($supplier['email'] ?? '') ?></td>
                            <td><?= (int)$supplier['part_count'] ?></td>
                            <td>
                                <a href="catalog.php?supplier_id=<?= (int)$supplier['id'] ?>"
                                   class="link-button">
                                    View catalog
                                </a>
                            </td>
                            <td>
                                <form method="post"
                                      action="suppliers.php"
                                      onsubmit="return confirm('Delete this supplier?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= (int)$supplier['id'] ?>">
                                    <input type="hidden" name="csrf_token"
                                           value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                    <button type="submit" class="btn btn-danger small">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        <?php endif; ?>

        <!-- Create supplier form -->
        <section class="panel" style="margin-top: 1.5rem;">
            <h3 class="panel-title">Add a new supplier</h3>
            <form method="post" action="suppliers.php">
                <input type="hidden" name="action" value="create">
                <input type="hidden" name="csrf_token"
                       value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                <label class="field">
                    <span class="field-label">Supplier Name *</span>
                    <input type="text" name="name" required maxlength="100">
                </label>

                <label class="field">
                    <span class="field-label">Contact Name</span>
                    <input type="text" name="contact_name" maxlength="100">
                </label>

                <label class="field">
                    <span class="field-label">Phone</span>
                    <input type="text" name="phone" maxlength="30">
                </label>

                <label class="field">
                    <span class="field-label">Email</span>
                    <input type="email" name="email" maxlength="120">
                </label>

                <section class="form-actions">
                    <button type="submit" class="btn btn-primary">Create Supplier</button>
                </section>
            </form>
        </section>

    </section>
</main>

<footer class="site-footer">
    <span>© <?= date('Y'); ?> AutoCore · CSS 305 Final Project</span>
</footer>

</body>
</html>
