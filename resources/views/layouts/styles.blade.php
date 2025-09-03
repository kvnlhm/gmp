<style>
    :root {
        /* Dark theme (default) */
        --primary-color: #00b894;
        --light-color: #f5f6fa;
        --dark-color: #1a1a1a;
        --grey-color: #636e72;
        --background-color: #2d3436;
        --card-bg: #1a1a1a;
        --text-color: #f5f6fa;
        --border-color: #636e72;
    }

    /* Light theme variables */
    [data-theme="light"] {
        --primary-color: #00b894;
        --light-color: #1a1a1a;
        --dark-color: #ffffff;
        --grey-color: #636e72;
        --background-color: #f5f6fa;
        --card-bg: #ffffff;
        --text-color: #2d3436;
        --border-color: #dee2e6;
    }

    /* Dark theme variables */
    [data-theme="dark"] {
        --primary-color: #00b894;
        --light-color: #f5f6fa;
        --dark-color: #1a1a1a;
        --grey-color: #636e72;
        --background-color: #2d3436;
        --card-bg: #1a1a1a;
        --text-color: #f5f6fa;
        --border-color: #636e72;
    }

    /* Theme switcher styles */
    .theme-switch {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
    }

    .theme-toggle, .theme-toggle-mobile {
        display: none;
    }

    .theme-label {
        cursor: pointer;
        padding: 10px;
        background-color: var(--card-bg);
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .theme-label i {
        font-size: 1.5rem;
        color: var(--primary-color);
    }

    .theme-toggle:checked ~ .theme-label .bx-sun,
    .theme-toggle:not(:checked) ~ .theme-label .bx-moon {
        display: none;
    }

    /* Update existing styles to use variables */
    body {
        background-color: var(--background-color);
        color: var(--text-color);
    }

    .card {
        background-color: var(--card-bg);
        color: var(--text-color);
    }

    .table {
        background-color: var(--card-bg);
        color: var(--text-color);
    }

    .sidebar {
        height: 100vh;
        background-color: var(--dark-color);
        color: var(--light-color);
        padding: 1.5rem;
        position: fixed;
        width: 250px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .sidebar .nav-link {
        color: var(--grey-color);
        padding: 0.8rem 1rem;
        margin-bottom: 0.5rem;
        border-radius: 8px;
        display: flex;
        align-items: center;
        transition: all 0.3s;
    }

    .sidebar .nav-link i {
        margin-right: 0.8rem;
        font-size: 1.2rem;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background-color: var(--background-color);
        color: var(--primary-color);
    }

    .content {
        margin-left: 270px;
        padding: 2rem;
        width: calc(100% - 270px);
    }

    .brand {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
    }

    .brand i {
        font-size: 2rem;
        margin-right: 0.5rem;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border: none;
    }

    .btn-primary:hover {
        background-color: #00a885;
    }

    h2 {
        color: var(--primary-color);
        font-weight: 500;
    }

    .card-title {
        color: var(--primary-color);
        font-weight: 500;
        margin-bottom: 1rem;
    }

    /* Form controls */
    .form-control, .form-select {
        background-color: var(--dark-color);
        border: 1px solid var(--background-color);
        color: var(--light-color);
    }

    .form-control:focus, .form-select:focus {
        background-color: var(--dark-color);
        border-color: var(--primary-color);
        color: var(--light-color);
        box-shadow: 0 0 0 0.25rem rgba(0, 184, 148, 0.25);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
        }
        
        .content {
            margin-left: 0;
            width: 100%;
        }
    }

    /* Tabel */
    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: var(--text-color) !important;
        vertical-align: top;
        border-color: var(--border-color) !important;
    }

    .table > :not(caption) > * > * {
        background-color: var(--card-bg) !important;
        color: var(--text-color) !important;
        padding: 0.75rem;
    }

    .table-bordered > :not(caption) > * {
        border-width: 1px 0;
    }

    .table-bordered > :not(caption) > * > * {
        border-width: 0 1px;
        border-color: var(--border-color) !important;
    }

    .table > thead {
        vertical-align: bottom;
    }

    .table > thead th {
        color: var(--primary-color) !important;
        font-weight: 600 !important;
        background-color: var(--card-bg) !important;
        border-bottom: 2px solid var(--border-color) !important;
        white-space: nowrap;
    }

    .table tbody tr:hover > * {
        background-color: var(--background-color) !important;
        color: var(--text-color) !important;
    }

    /* Untuk memastikan warna teks dalam tabel */
    .table td, .table th {
        color: var(--text-color) !important;
    }

    /* Untuk header kolom spesifik */
    .table th[colspan="9"],
    .table th:nth-child(n+10):nth-child(-n+18),
    .table th:nth-child(19) {
        color: var(--primary-color) !important;
        text-align: center;
        font-weight: 600 !important;
    }

    /* Style untuk baris genap/ganjil jika diperlukan */
    .table tbody tr:nth-of-type(odd) > * {
        background-color: var(--card-bg) !important;
    }

    .table tbody tr:nth-of-type(even) > * {
        background-color: var(--background-color) !important;
    }

    /* Card */
    .card {
        background-color: var(--card-bg) !important;
        border-color: var(--border-color) !important;
    }

    .card-body {
        color: var(--text-color) !important;
    }

    /* Form */
    .form-control, .form-select {
        background-color: var(--background-color) !important;
        border-color: var(--border-color) !important;
        color: var(--text-color) !important;
    }

    .form-control:focus, .form-select:focus {
        background-color: var(--background-color) !important;
        border-color: var(--primary-color) !important;
        color: var(--text-color) !important;
    }

    .form-label {
        color: var(--primary-color) !important;
    }

    /* Modal */
    .modal-content {
        background-color: var(--card-bg) !important;
        color: var(--text-color) !important;
    }

    .modal-header, .modal-footer {
        border-color: var(--border-color) !important;
    }

    /* Buttons */
    .btn-secondary {
        background-color: var(--grey-color) !important;
        border-color: var(--grey-color) !important;
        color: #ffffff !important;
    }

    .btn-primary {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        color: #ffffff !important;
    }

    /* Sidebar */
    .sidebar {
        background-color: var(--card-bg) !important;
    }

    .sidebar .nav-link {
        color: var(--grey-color) !important;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background-color: var(--background-color) !important;
        color: var(--primary-color) !important;
    }

    /* Alert */
    .alert-danger {
        background-color: var(--background-color) !important;
        border-color: #ff5252 !important;
        color: #ff5252 !important;
    }

    /* Body dan Content */
    body {
        background-color: var(--background-color) !important;
        color: var(--text-color) !important;
    }

    .content {
        background-color: var(--background-color) !important;
    }

    /* Headers */
    h1, h2, h3, h4, h5, h6 {
        color: var(--primary-color) !important;
    }

    /* Button styles */
    .btn-primary {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        color: #ffffff !important;
    }

    .btn-secondary {
        background-color: var(--grey-color) !important;
        border-color: var(--grey-color) !important;
        color: #ffffff !important;
    }

    .btn-primary:hover {
        background-color: #00a885 !important;
        border-color: #00a885 !important;
        color: #ffffff !important;
    }

    .btn-secondary:hover {
        background-color: #4d5559 !important;
        border-color: #4d5559 !important;
        color: #ffffff !important;
    }

    /* Khusus untuk tombol Filter dan Reset */
    .btn-primary, .btn-secondary {
        font-weight: 500;
    }

    /* Memastikan semua header tabel konsisten */
    .table thead th {
        font-weight: 600 !important;
        padding: 12px 8px;
        vertical-align: middle;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const themeToggle = document.getElementById('theme-toggle');
        
        function setTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            themeToggle.checked = theme === 'light';
        }

        themeToggle.addEventListener('change', function() {
            const theme = this.checked ? 'light' : 'dark';
            setTheme(theme);
        });

        // Set initial state
        const savedTheme = localStorage.getItem('theme') || 'dark';
        setTheme(savedTheme);
    });
</script> 