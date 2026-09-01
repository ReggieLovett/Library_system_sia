<?php
include '../connection/dbconn.php';

$query = "SELECT * FROM students";
$result = mysqli_query($conn, $query);
$rows = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) { $rows[] = $row; }
}
$count = count($rows);
?>
<!DOCTYPE html>
<html lang="en" data-theme="system">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>Library — Students</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600&family=Geist+Mono:wght@400;500&family=Source+Serif+4:opsz@8..60&display=swap" rel="stylesheet">
    <link href="../assets/css/bryl.css" rel="stylesheet">
</head>
<body>
    <div class="halftone"></div>

    <div class="app-shell">
        <aside class="sidebar">
            <a href="../index.php" class="brand">
                <span class="brand-mark">L</span>
                <span class="brand-name">library</span>
            </a>

            <nav class="nav-group">
                <span class="nav-label">Manage</span>
                <a href="../index.php" class="nav-link">New Transaction</a>
                <a href="transaction_display.php" class="nav-link">Transactions</a>
                <a href="student_display.php" class="nav-link active">Students</a>
            </nav>

            <div class="sidebar-footer">
                <hr class="divider">
                <button class="theme-toggle btn-link" type="button" data-theme-toggle>
                    <span class="icon" data-icon>⟡</span>
                    <span data-label>theme</span>
                </button>
            </div>
        </aside>

        <div class="topbar">
            <a href="../index.php" class="brand">
                <span class="brand-mark">L</span>
                <span class="brand-name">library</span>
            </a>
            <button class="icon-btn" data-menu-open aria-label="Open menu">☰</button>
        </div>

        <main class="content">
            <header class="page-head reveal">
                <span class="section-mark">03 — directory</span>
                <h1 class="page-title">students</h1>
                <p class="page-desc">Registered students and their programs.</p>
            </header>

            <div class="stat-grid reveal" style="animation-delay: 70ms">
                <div class="stat-cell">
                    <div class="stat-value"><?= (int)$count ?></div>
                    <div class="stat-label">Total students</div>
                </div>
                <div class="stat-cell">
                    <div class="stat-value"><?= (int)(mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT program FROM students"))) ?></div>
                    <div class="stat-label">Programs</div>
                </div>
                <div class="stat-cell">
                    <div class="stat-value"><?= count(array_column($rows, 'year_section') ?: []) ?></div>
                    <div class="stat-label">Enrolled records</div>
                </div>
            </div>

            <section class="card table-card reveal" style="animation-delay: 140ms">
                <div class="toolbar" style="padding: 1.25rem 1.25rem 0;">
                    <div class="search-wrap">
                        <input class="input" type="text" id="searchInput" placeholder="search students…" data-filter>
                    </div>
                </div>
                <div class="table-scroll">
                    <table data-table>
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Program</th>
                                <th>Year / Section</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($count > 0): foreach ($rows as $i => $row): ?>
                                <tr data-row>
                                    <td class="mono serial"><?= htmlspecialchars($row['id']) ?></td>
                                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                                    <td class="muted"><?= htmlspecialchars($row['program']) ?></td>
                                    <td><span class="pill"><?= htmlspecialchars($row['year_section']) ?></span></td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr data-empty>
                                    <td colspan="4" class="empty-state">
                                        <div class="dash">—</div>
                                        No students found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <footer class="footer">
                <span>library · bryl-minimal</span>
                <span><?= (int)$count ?> rows</span>
            </footer>
        </main>
    </div>

    <div class="mobile-menu" data-menu>
        <button class="icon-btn menu-close" data-menu-close aria-label="Close menu">✕</button>
        <nav class="nav-group">
            <span class="nav-label">Manage</span>
            <a href="../index.php" class="nav-link">New Transaction</a>
            <a href="transaction_display.php" class="nav-link">Transactions</a>
            <a href="student_display.php" class="nav-link active">Students</a>
        </nav>
        <button class="theme-toggle btn-link" type="button" data-theme-toggle>
            <span class="icon" data-icon>⟡</span>
            <span data-label>theme</span>
        </button>
    </div>

    <script src="../assets/js/bryl.js" defer></script>
</body>
</html>
