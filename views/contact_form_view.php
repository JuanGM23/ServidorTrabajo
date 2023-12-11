<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
</head>
<style>
body {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
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
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    color: white;
    text-align: center;
}
h2 {
    color: #333;
    text-align: center;
}

form {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    max-width: 400px;
    margin: auto;
    margin-top: 50px;
}

label {
    display: block;
    margin-bottom: 10px;
    color: #555;
}

input,
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    box-sizing: border-box;
}

button {
    background-color: #333;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #555;
}

</style>
<body>
    <header>
        <h1>CompetchStore</h1>
        <h1>Contact</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="about_us_view.php">About Us</a></li>
                <li><a href="../index.php">Products</a></li>
                <li><a href="services_view.php">Services</a></li>
                <li><a href="profile.php">View Profile</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Contact</h2>
        <form action="process_contact.php" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="message">Message:</label>
            <textarea name="message" rows="4" required></textarea>

            <button type="submit">Add Message</button>
        </form>
    </main>
    

    <footer>
        <!-- No incluir enlaces a registro e inicio de sesión en esta vista -->
    </footer>
</body>
</html>
