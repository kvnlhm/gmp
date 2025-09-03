<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GMP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="icon" href="{{ asset('public/images/logo.png') }}">
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

        /* Light theme */
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

        body {
            background-color: var(--background-color);
            font-family: 'Inter', sans-serif;
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 2rem;
            background-color: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .brand {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--primary-color);
        }

        .brand i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .form-control {
            background-color: var(--background-color);
            border-color: var(--border-color);
            color: var(--text-color);
            border-radius: 8px;
            padding: 0.8rem 1rem;
        }

        .form-control:focus {
            background-color: var(--background-color);
            border-color: var(--primary-color);
            color: var(--text-color);
            box-shadow: 0 0 0 0.25rem rgba(0, 184, 148, 0.25);
        }

        .form-label {
            color: var(--primary-color);
            font-weight: 500;
        }

        .form-check-label {
            color: var(--text-color);
        }

        .form-check-input {
            background-color: var(--background-color);
            border-color: var(--border-color);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 0.8rem;
            font-weight: 500;
            width: 100%;
            color: #ffffff !important;
        }

        .btn-primary:hover {
            background-color: #00a885;
        }

        .alert {
            background-color: var(--background-color);
            border-color: #ff5252;
            color: #ff5252;
            border-radius: 8px;
        }

        .alert ul {
            margin-bottom: 0;
        }

        /* Theme switcher styles */
        .theme-switch {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        .theme-toggle {
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
            width: 40px;
            height: 40px;
        }

        .theme-label i {
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        .theme-toggle:checked ~ .theme-label .bx-sun,
        .theme-toggle:not(:checked) ~ .theme-label .bx-moon {
            display: none;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="brand">
            <i class='bx bx-building-house'></i>
            <h4>GMP - Gatha Monitoring Pancang</h4>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    @include('components.theme-switcher')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>