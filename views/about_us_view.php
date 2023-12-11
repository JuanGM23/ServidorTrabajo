<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<style>
    body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
}

header {
    background-color: #333;
    color: #fff;
    padding: 10px;
    text-align: center;
}

nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

nav ul li {
    display: inline;
    margin-right: 20px;
}

nav a {
    text-decoration: none;
    color: #fff;
    font-weight: bold;
}

main {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    padding: 20px;
}

.card {
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 10px;
    padding: 10px;
    width: 200px;
    text-align: center;
}

.card img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}

footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 10px;
}

footer button {
    background-color: #fff;
    color: #333;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

footer button:hover {
    background-color: #ddd;
}


</style>
<body>
<header>
    <h1>CompetchStore</h1>
        <h1>About Us</h1>

        <nav>
        <ul>
            <!-- Otros elementos de navegación -->
            <li><a href="../index.php">Home</a></li>
            <li><a href="../index.php">Products</a></li>
            <li><a href="services_view.php">Services</a></li>
            <li><a href="contact_form_view.php">Contact</a></li>
            <li><a href="profile.php">View Profile</a></li>
        </ul>
    </nav>
    </header>

    <main>
        <h1>About Us</h1>
        <div>
            <?php
            require_once '../models/AboutUsModel.php';

            $aboutUsModel = new AboutUsModel();
            $roles = $aboutUsModel->getRoles();

            foreach ($roles as $role): ?>
                <div class="card">
                    <h2><?= $role['role']; ?></h2>
                    <p><?= $role['description']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <!-- No incluir enlaces a registro y inicio de sesión en esta vista -->
    </footer>
</body>
</html>
