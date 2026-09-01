<!DOCTYPE html>
<html lang="en" data-theme="system">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>Library — New Transaction</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600&family=Geist+Mono:wght@400;500&family=Source+Serif+4:opsz@8..60&display=swap" rel="stylesheet">
    <link href="assets/css/bryl.css" rel="stylesheet">
</head>
<body>
    <div class="halftone"></div>

    <div class="app-shell">
        <aside class="sidebar">
            <a href="index.php" class="brand">
                <span class="brand-mark">L</span>
                <span class="brand-name">library</span>
            </a>

            <nav class="nav-group">
                <span class="nav-label">Manage</span>
                <a href="index.php" class="nav-link active">New Transaction</a>
                <a href="views/transaction_display.php" class="nav-link">Transactions</a>
                <a href="views/student_display.php" class="nav-link">Students</a>
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
            <a href="index.php" class="brand">
                <span class="brand-mark">L</span>
                <span class="brand-name">library</span>
            </a>
            <button class="icon-btn" data-menu-open aria-label="Open menu">☰</button>
        </div>

        <main class="content">
            <header class="page-head reveal">
                <span class="section-mark">01 — new record</span>
                <h1 class="page-title">borrow</h1>
                <p class="page-desc">Record a library transaction. Transaction ID is left blank to auto-generate.</p>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert success">Transaction saved successfully.</div>
                <?php elseif (isset($_GET['error'])): ?>
                    <div class="alert error">Please fill in all required fields.</div>
                <?php endif; ?>
            </header>

            <section class="card form-card reveal" style="animation-delay: 70ms">
                <form action="functions/transaction_add.php" method="POST" id="trans-form" novalidate>
                    <div class="form-grid">
                        <div class="field">
                            <label class="field-label" for="trans_id">Trans ID</label>
                            <input class="input mono" type="number" name="trans_id" id="trans_id" placeholder="auto">
                            <span class="field-hint">Leave blank to auto-generate.</span>
                        </div>

                        <div class="field">
                            <label class="field-label" for="student_id">Student ID</label>
                            <input class="input mono" type="number" name="student_id" id="student_id" required>
                            <span class="field-error" data-error-for="student_id"></span>
                        </div>

                        <div class="field col-span">
                            <label class="field-label" for="book_burrowed">Book Borrowed</label>
                            <input class="input" type="text" name="book_burrowed" id="book_burrowed" placeholder="e.g. The Design of Everyday Things" required>
                            <span class="field-error" data-error-for="book_burrowed"></span>
                        </div>

                        <div class="field">
                            <label class="field-label" for="date_burrowed">Date Borrowed</label>
                            <input class="input mono" type="date" name="date_burrowed" id="date_burrowed" required>
                            <span class="field-error" data-error-for="date_burrowed"></span>
                        </div>

                        <div class="field">
                            <label class="field-label" for="status">Status</label>
                            <div class="select-wrap">
                                <select class="input mono" name="status" id="status" required>
                                    <option value="">select…</option>
                                    <option value="Borrowed">Borrowed</option>
                                    <option value="Returned">Returned</option>
                                    <option value="Overdue">Overdue</option>
                                </select>
                            </div>
                            <span class="field-error" data-error-for="status"></span>
                        </div>

                        <div class="field col-span">
                            <label class="field-label" for="librarian_incharge">Librarian Incharge</label>
                            <input class="input" type="text" name="librarian_incharge" id="librarian_incharge" placeholder="Full name" required>
                            <span class="field-error" data-error-for="librarian_incharge"></span>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button class="btn btn-primary" type="submit">Save Transaction</button>
                        <a class="btn-link" href="views/transaction_display.php">view all <span class="arrow">↗</span></a>
                    </div>
                </form>
            </section>
        </main>
    </div>

    <div class="mobile-menu" data-menu>
        <button class="icon-btn menu-close" data-menu-close aria-label="Close menu">✕</button>
        <nav class="nav-group">
            <span class="nav-label">Manage</span>
            <a href="index.php" class="nav-link active">New Transaction</a>
            <a href="views/transaction_display.php" class="nav-link">Transactions</a>
            <a href="views/student_display.php" class="nav-link">Students</a>
        </nav>
        <button class="theme-toggle btn-link" type="button" data-theme-toggle>
            <span class="icon" data-icon>⟡</span>
            <span data-label>theme</span>
        </button>
    </div>

    <script src="assets/js/bryl.js" defer></script>
    <script>
        document.querySelectorAll('[data-error-for]').forEach(function (el) {
            const id = el.dataset.errorFor;
            const input = document.getElementById(id);
            if (!input) return;
            input.addEventListener('input', function () {
                if (input.validity.valid) { el.textContent = ''; input.classList.remove('invalid'); }
            });
            input.addEventListener('blur', function () {
                if (input.hasAttribute('required') && !input.value) {
                    el.textContent = 'required';
                    input.classList.add('invalid');
                } else if (input.value && !input.validity.valid) {
                    el.textContent = input.validationMessage;
                    input.classList.add('invalid');
                } else {
                    el.textContent = '';
                    input.classList.remove('invalid');
                }
            });
        });
        document.getElementById('trans-form').addEventListener('submit', function (e) {
            const reqs = this.querySelectorAll('[required]');
            let firstInvalid = null;
            reqs.forEach(function (r) {
                if (!r.value) {
                    const err = document.querySelector('[data-error-for="' + r.id + '"]');
                    if (err) { err.textContent = 'required'; r.classList.add('invalid'); }
                    if (!firstInvalid) firstInvalid = r;
                }
            });
            if (firstInvalid) { e.preventDefault(); firstInvalid.focus(); }
        });
    </script>
</body>
</html>
