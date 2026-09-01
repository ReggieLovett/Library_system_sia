// bryl-minimal — library system
// theme, mobile menu, entrance stagger, table search + status filter

(function () {
  'use strict';

  var root = document.documentElement;

  /* ---------- Theme ---------- */
  var THEME_KEY = 'library-theme';
  var SYSTEM_MEDIA = window.matchMedia('(prefers-color-scheme: dark)');

  function resolve(theme) {
    if (theme === 'dark') return 'dark';
    if (theme === 'light') return 'light';
    return SYSTEM_MEDIA.matches ? 'dark' : 'light';
  }

  function apply(theme) {
    var resolved = resolve(theme);
    root.setAttribute('data-theme', resolved);
    root.style.colorScheme = resolved;
    document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
      var label = btn.querySelector('[data-label]');
      var icon = btn.querySelector('[data-icon]');
      if (label) label.textContent = (resolved === 'dark' ? 'light' : 'dark');
      if (icon) icon.textContent = (resolved === 'dark' ? '☀' : '☾');
    });
  }

  var stored = null;
  try { stored = localStorage.getItem(THEME_KEY); } catch (e) { /* ignore */ }
  apply(stored || SYSTEM_MEDIA.matches ? 'system' : stored || 'system');

  function cycle() {
    var current = resolve(root.getAttribute('data-theme'));
    var next = current === 'dark' ? 'light' : 'dark';
    try { localStorage.setItem(THEME_KEY, next); } catch (e) { /* ignore */ }
    apply(next);
  }

  document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
    btn.addEventListener('click', cycle);
  });

  SYSTEM_MEDIA.addEventListener('change', function () {
    var s = null;
    try { s = localStorage.getItem(THEME_KEY); } catch (e) { /* ignore */ }
    if (!s) apply('system');
  });

  /* ---------- Mobile menu ---------- */
  var menu = document.querySelector('[data-menu]');
  var menuOpen = document.querySelector('[data-menu-open]');
  var menuClose = document.querySelector('[data-menu-close]');

  function closeMenu() { if (menu) menu.classList.remove('open'); }
  function openMenu() { if (menu) menu.classList.add('open'); }

  if (menuOpen) menuOpen.addEventListener('click', openMenu);
  if (menuClose) menuClose.addEventListener('click', closeMenu);
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeMenu();
  });
  if (menu) menu.addEventListener('click', function (e) {
    if (e.target.closest('.nav-link') || e.target.closest('[data-theme-toggle]')) closeMenu();
  });

  /* ---------- Entrance stagger ---------- */
  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (!reduced) {
    var reveals = document.querySelectorAll('.reveal');
    reveals.forEach(function (el, i) {
      el.style.transition = 'opacity 700ms cubic-bezier(0.16,1,0.3,1), transform 700ms cubic-bezier(0.16,1,0.3,1)';
    });
  }

  /* ---------- Table search + status filter ---------- */
  var search = document.querySelector('[data-filter]');
  var statusBtns = document.querySelectorAll('[data-filter-status]');
  var rows = Array.prototype.slice.call(document.querySelectorAll('[data-row]'));
  var currentStatus = '';
  var currentQuery = '';

  function applyFilters() {
    var empty = document.querySelector('[data-empty]');
    if (empty) {
      empty.style.display = rows.some(isVisible) ? 'none' : 'table-row';
    }
    rows.forEach(function (row) { row.style.display = isVisible(row) ? '' : 'none'; });

    statusBtns.forEach(function (btn) {
      if (btn.dataset.filterStatus === currentStatus) {
        btn.classList.add('btn-primary');
        btn.classList.remove('btn');
      } else {
        btn.classList.add('btn');
        btn.classList.remove('btn-primary');
      }
    });
  }

  function isVisible(row) {
    if (currentStatus && row.dataset.status !== currentStatus) return false;
    if (currentQuery) {
      var hay = (row.dataset.search || '').toLowerCase();
      if (hay.indexOf(currentQuery) === -1) return false;
    }
    return true;
  }

  if (search) {
    search.addEventListener('input', function () {
      currentQuery = this.value.trim().toLowerCase();
      applyFilters();
    });
  }

  statusBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      currentStatus = this.dataset.filterStatus;
      applyFilters();
    });
  });

  applyFilters();
})();
