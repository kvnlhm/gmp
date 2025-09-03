<style>
    :root {
        --primary-color: #4723D9;
        --light-color: #f8f9fa;
        --dark-color: #343a40;
        --grey-color: #6c757d;
    }

    body {
        background-color: var(--light-color);
        font-family: 'Inter', sans-serif;
    }

    .sidebar {
        height: 100vh;
        background-color: white;
        color: var(--dark-color);
        padding: 1.5rem;
        position: fixed;
        width: 250px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        background-color: var(--primary-color);
        color: white;
    }

    .content {
        margin-left: 270px;
        padding: 2rem;
        width: calc(100% - 270px);
    }

    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
    }

    .table {
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .table thead th {
        background-color: var(--light-color);
        border-bottom: none;
        padding: 1rem;
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
        background-color: #3a1bb3;
    }

    h2 {
        color: var(--dark-color);
        font-weight: 600;
    }

    .card-title {
        color: var(--dark-color);
        font-weight: 600;
        margin-bottom: 1rem;
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
</style> 