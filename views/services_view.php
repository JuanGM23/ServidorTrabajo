<!-- services_view.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Servicios</title>
</head>
<style>
    /* styles.css */

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
        <h1>Services</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="about_us_view.php">About Us</a></li>
                <li><a href="../index.php">Products</a></li>
                <li><a href="contact_form_view.php">Contact</a></li>
                <li><a href="profile.php">View Profile</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Services</h1>
        <div>
            <?php
            require_once '../models/ServicesModel.php';

            $servicesModel = new ServicesModel();
            $services = $servicesModel->getAllServices();

            foreach ($services as $service): ?>
                <div class="card">
                    <h2><?= $service['name']; ?></h2>
                    <p><?= $service['description']; ?></p>
                    <p>Precio: <?= $service['price']; ?></p>
                    <!-- Add to Cart Button -->
                    <button class="add-to-cart-btn"
                            data-service-id="<?= $service['id']; ?>"
                            data-service-name="<?= $service['name']; ?>"
                            data-service-price="<?= $service['price']; ?>">
                        Add to Cart
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <!-- No incluir enlaces a registro e inicio de sesión en esta vista -->
    </footer>

    <script>
        // JavaScript for handling Add to Cart button click
document.addEventListener('DOMContentLoaded', function () {
    var addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

    addToCartButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var serviceId = button.getAttribute('data-service-id');
            var serviceName = button.getAttribute('data-service-name');
            var servicePrice = button.getAttribute('data-service-price');

            // AJAX request to routes.php
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../controllers/routes.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        try {
                            var response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                alert('Service added to cart successfully!');
                            } else {
                                alert('Failed to add service to cart.');
                            }
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                        }
                    } else {
                        console.error('Error:', xhr.status, xhr.statusText);
                    }
                }
            };
            // Sending data to routes.php
            xhr.send('action=addToCart&serviceId=' + serviceId +
                     '&serviceName=' + serviceName +
                     '&servicePrice=' + servicePrice);
        });
    });
});

    </script>
</body>
</html>
