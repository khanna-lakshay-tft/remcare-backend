<!-- resources/views/home.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <!-- Add CSS files here -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>Welcome to My Homepage</h1>
        <!-- Navigation links, etc. -->
    </header>

    <main>
        <section>
            <h2>About Us</h2>
            <p>This is a sample homepage created using Laravel and Blade templating engine.</p>
        </section>

        <section>
            <h2>Contact Us</h2>
            <p>Email: example@example.com</p>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 My Website</p>
    </footer>

    <!-- Add JavaScript files here -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
