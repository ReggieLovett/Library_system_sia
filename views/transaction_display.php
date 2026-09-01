<?php
include '../connection/dbconn.php';

$query = "SELECT * FROM library ORDER BY trans_id DESC";
$result = mysqli_query($conn, $query);
$rows = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) { $rows[] = $row; }
}
$total = count($rows);
$borrowed = 0; $returned = 0; $overdue = 0;
foreach ($rows as $r) {
    $s = strtolower($r['status']);
    if ($s === 'borrowed') $borrowed++;
    elseif ($s === 'returned') $returned++;
    elseif ($s === 'overdue') $overdue++;
}
function status_pill($s) {
    $lower = strtolower($s);
    $extra = ($lower === 'returned') ? ' class="pill champion"' : ' class="pill"';
    return '<span' . $extra . '>' . htmlspecialchars($s) . '</span>';
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="system">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>Library — Transactions</title>

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
                <a href="transaction_display.php" class="nav-link active">Transactions</a>
                <a href="student_display.php" class="nav-link">Students</a>
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
                <span class="section-mark">02 — ledger</span>
                <h1 class="page-title">transactions</h1>
                <p class="page-desc">All library borrowing records, newest first.</p>
            </header>

            <div class="stat-grid reveal" style="animation-delay: 70ms">
                <div class="stat-cell">
                    <div class="stat-value"><?= (int)$total ?></div>
                    <div class="stat-label">Total transactions</div>
                </div>
                <div class="stat-cell">
                    <div class="stat-value"><?= (int)$borrowed ?></div>
                    <div class="stat-label">Borrowed</div>
                </div>
                <div class="stat-cell">
                    <div class="stat-value"><?= (int)$returned ?></div>
                    <div class="stat-label">Returned</div>
                </div>
            </div>

            <section class="card table-card reveal" style="animation-delay: 140ms">
                <div class="toolbar" style="padding: 1.25rem 1.25rem 0;">
                    <div class="search-wrap">
                        <input class="input" type="text" id="searchInput" placeholder="search book, status, librarian…" data-filter>
                    </div>
                    <button class="btn" type="button" data-filter-status="" data-current>all</button>
                    <button class="btn" type="button" data-filter-status="Borrowed">borrowed</button>
                    <button class="btn" type="button" data-filter-status="Returned">returned</button>
                    <button class="btn" type="button" data-filter-status="Overdue">overdue</button>
                </div>
                <div class="table-scroll">
                    <table data-table>
                        <thead>
                            <tr>
                                <th>Trans ID</th>
                                <th>Book</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Librarian</th>
                                <th>Student</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($total > 0): foreach ($rows as $row): ?>
                                <tr data-row data-search="<?= htmlspecialchars(strtolower($row['trans_id'] . ' ' . $row['book_burrowed'] . ' ' . $row['status'] . ' ' . $row['librarian_incharge'] . ' ' . $row['student_id'])) ?>" data-status="<?= htmlspecialchars($row['status']) ?>">
                                    <td class="mono serial">#<?= htmlspecialchars($row['trans_id']) ?></td>
                                    <td><?= htmlspecialchars($row['book_burrowed']) ?></td>
                                    <td class="mono muted"><?= htmlspecialchars($row['date_burrowed']) ?></td>
                                    <td><?= status_pill($row['status']) ?></td>
                                    <td class="muted"><?= htmlspecialchars($row['librarian_incharge']) ?></td>
                                    <td class="mono"><?= htmlspecialchars($row['student_id']) ?></td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr data-empty>
                                    <td colspan="6" class="empty-state">
                                        <div class="dash">—</div>
                                        No transactions found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <footer class="footer">
                <span>library · bryl-minimal</span>
                <span><?= (int)$total ?> rows</span>
            </footer>
        </main>
    </div>

    <div class="mobile-menu" data-menu>
        <button class="icon-btn menu-close" data-menu-close aria-label="Close menu">✕</button>
        <nav class="nav-group">
            <span class="nav-label">Manage</span>
            <a href="../index.php" class="nav-link">New Transaction</a>
            <a href="transaction_display.php" class="nav-link active">Transactions</a>
            <a href="student_display.php" class="nav-link">Students</a>
        </nav>
        <button class="theme-toggle btn-link" type="button" data-theme-toggle>
            <span class="icon" data-icon>⟡</span>
            <span data-label>theme</span>
        </button>
    </div>

    <script src="../assets/js/bryl.js" defer></script>
</body>
</html>
