<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'db.php';
/*
  Simple query to show users.
  Make sure the column names match your REAL table:
  e.g. users(username, email, role)
*/
$sql = "SELECT username, email, role FROM users ORDER BY username";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BoyeLeeNaga Shop – Users</title>
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
        <a href="suppliers.php" class="nav-link">Suppliers</a>
        <a href="users.php" class="nav-link active">Users</a>
        <a href="logout.php" class="nav-link">Logout</a>
    </nav>
</header>

<main class="layout">

    <!-- LEFT HERO SECTION -->
    <section class="hero">
        <h1 class="hero-title">Users</h1>
        <p class="hero-subtitle">
            View all internal user accounts for the mechanic shop system,
            including username, email, and role.
        </p>
    </section>

    <!-- RIGHT USERS TABLE CARD -->
    <section class="panel-table">
        <h2 class="panel-title">User list</h2>
        <p class="panel-text">
            This table shows all users who can sign in to manage parts and suppliers.
        </p>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['role']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No users found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

</main>

<footer class="site-footer">
    <span>© BoyeLeeNaga · CSS 305 Final Project · Samuel Boye</span>
</footer>

</body>
</html>
<?php
$conn->close();
?>
