<?php
session_start();
include 'db_connection.php';

// Fetch menu items from database
$sql = "SELECT * FROM menu";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Menu</title>
        <link rel="stylesheet" href="../../Styles/menu.css">
    </head>
<body>

    <?php include 'header.php'; ?>

    <main>

        <section id="Canteen-buttons">
            <button class="Canteen-button" onclick="filterItems('Canteen 1')">Canteen 1</button>
            <button class="Canteen-button" onclick="filterItems('Canteen 2')">Canteen 2</button>
            <button class="Canteen-button" onclick="filterItems('Canteen 3')">Canteen 3</button>
        </section>

        <section id="category-buttons">
            <button class="category-button" onclick="filterItems('all')">All</button>
            <button class="category-button" onclick="filterItems('meals')">Meals</button>
            <button class="category-button" onclick="filterItems('snacks')">Snacks</button>
            <button class="category-button" onclick="filterItems('drinks')">Drinks</button>
        </section>

        <section id="menu-items">
            <div class="container">
                <h2>Our Menu</h2>
                <div class="menu-grid">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="menu-item">
                            <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                            <p><?php echo htmlspecialchars($row['description']); ?></p>
                            <p class="price">$<?php echo number_format($row['price'], 2); ?></p>
                            <a href="cart.php?id=<?php echo $row['id']; ?>" class="btn">Add to Cart</a>
                        </div>
                    <?php endwhile; ?>
                </div>
                    <p>Check out our delicious menu!</p>

                <div class="menu-list">
                    <!-- Menu Item 1 -->
                    <div class="menu-item">
                        <img src="https://leitesculinaria.com/wp-content/uploads/2021/05/perfect-hot-dog.jpg" alt="Hot Dog" class="menu-img">
                        <div class="menu-details">
                            <h3>Hot Dog</h3>
                            <p class="description">A delicious grilled hot dog served with your choice of toppings.</p>
                            <p class="price">$5.99</p>
                        </div>
                    </div>

                    <!-- Menu Item 2 -->
                    <div class="menu-item">
                        <img src="https://images.unsplash.com/photo-1603064752734-4c48eff53d05?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8YnVyZ2VyfGVufDB8fDB8fHww" alt="Burger" class="menu-img">
                            <div class="menu-details">
                            <h3>Burger</h3>
                            <p class="description">A juicy beef burger with cheese, lettuce, and tomato on a fresh bun.</p>
                            <p class="price">$8.49</p>
                        </div>
                    </div>

                    <!-- Menu Item 3 -->
                    <div class="menu-item">
                        <img src="https://thumbs.dreamstime.com/b/pizza-slices-flying-black-background-delicious-peperoni-pieces-melting-cheese-ingredients-generated-ai-330564445.jpg" alt="Pizza" class="menu-img">
                        <div class="menu-details">
                            <h3>Pizza</h3>
                            <p class="description">A classic pizza with pepperoni, cheese, and a delicious tomato sauce.</p>
                            <p class="price">$12.99</p>
                        </div>
                    </div>

                    <!-- Menu Item 4 -->
                    <div class="menu-item">
                        <img src="https://media.istockphoto.com/id/157560786/photo/maki-sushi-california.jpg?s=612x612&w=0&k=20&c=4MYZwHh6wmb4cVh37aVTC81dEhO9ReMFVEFjaZpi7is=" alt="Sushi" class="menu-img">
                        <div class="menu-details">
                            <h3>Sushi</h3>
                            <p class="description">Fresh sushi rolls with a variety of seafood and veggies.</p>
                            <p class="price">$14.99</p>
                        </div>
                    </div>

                    <!-- Menu Item 5 -->
                    <div class="menu-item">
                        <img src="https://www.shutterstock.com/image-photo/vegetarian-tacos-sweet-corn-purple-260nw-2055440705.jpg" alt="Tacos" class="menu-img">
                        <div class="menu-details">
                            <h3>Tacos</h3>
                            <p class="description">Soft tacos with a choice of beef, chicken, or veggies, topped with fresh salsa.</p>
                            <p class="price">$7.99</p>
                        </div>
                    </div>

                    <div class="menu-item" data-category="snacks" data-canteen="Canteen 1">
                    <img src="https://insanelygoodrecipes.com/wp-content/uploads/2020/05/Burger-with-cheese.jpg" alt="Burger">
                    <h3>Burger</h3>
                    <p>Price: ₱30</p>
                    <div class="cart-controls">
                        <input type="number" class="quantity-input" value="1" min="1">
                        <form action="cart.php" method="POST">
                            <input type="hidden" name="food_name" value="Burger">
                            <input type="hidden" name="food_price" value="30">
                            <input type="hidden" name="food_quantity" class="hidden-quantity" value="1">
                            <button type="submit" class="add-to-cart">Add to Cart</button>
                        </form>
                        </div>
                    </div>


                    <div class="menu-item">
                        <img src="https://leitesculinaria.com/wp-content/uploads/2021/05/perfect-hot-dog.jpg" alt="Hot Dog" class="menu-img">
                        <div class="menu-details">
                            <h3>Hot Dog</h3>
                            <p class="description">A delicious grilled hot dog served with your choice of toppings.</p>
                            <p class="price">$5.99</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <script>
    function redirectToCart(event) {
        // Prevent redirection if clicking the input or button
        if (event.target.classList.contains('add-to-cart') || event.target.classList.contains('quantity-input')) {
            return;
        }
        window.location.href = 'cart.php';
    }

    function addToCart(item, price, button) {
        // Your existing "Add to Cart" function logic here
        alert(item + " added to cart!");
    }
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>
