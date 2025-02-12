// Array of slider images to cycle through
const sliders = [
    '../../Images/resized2.jpg', // Image 1
    'https://scontent.fmnl4-2.fna.fbcdn.net/v/t39.30808-6/366296558_801504765097907_8954442280322709254_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=f727a1&_nc_ohc=h8MaPEh3sIQQ7kNvgEb6ryK&_nc_oc=AdihkDfGNZEbJvcHAVV6OdaeMFWvXS7MiPGYhFo1almaWDEQQqKzzfXnKsaKkK5wpFY&_nc_zt=23&_nc_ht=scontent.fmnl4-2.fna&_nc_gid=ALr-V5QYfWEAqc4NruLqcg5&oh=00_AYCT5qrZVvkhvSaOZORhWrkDPlz5iftu7xMKS6uzn5T54Q&oe=67AD3965', // Image 2
    'https://i.pinimg.com/736x/9a/ab/65/9aab65b25a374e772841081c38d74d6a.jpg', // Image 3
];

const circles = document.querySelectorAll('.circle');
const sliderImage = document.getElementById('slider-image');

// Function to change the image based on the selected circle
function changeSlider(index) {
    // Ensure we have a valid image at the given index
    if (sliders[index]) {
        sliderImage.src = sliders[index]; // Update the image src
    }

    // Remove the active class from all circles
    circles.forEach(circle => circle.classList.remove('active'));

    // Add the active class to the clicked circle
    circles[index].classList.add('active');
}

// Add event listeners to each circle to trigger the image change
circles.forEach(circle => {
    circle.addEventListener('click', () => {
        const index = circle.getAttribute('data-index');
        changeSlider(index);
    });
});

// Optionally, set the initial image
changeSlider(0);

let cart = [];

document.addEventListener('DOMContentLoaded', function () {
    const headerContainer = document.querySelector('.top-header');
    const authContainer = document.getElementById("auth-container");

    if (localStorage.getItem("username")) {
        displayLoggedInState();
    } else {
        displayLoginAndRegisterButtons();
    }

    window.addToCart = function (itemName, itemPrice) {
        if (!localStorage.getItem("username")) {
            alert("You need an account to add items to the cart.");
            openBox('register');
            return;
        }

        let existingItem = cart.find(item => item.name === itemName);

        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({ name: itemName, price: itemPrice, quantity: 1 });
        }

        updateCartDisplay();
    };

    const cartItems = [];
    const cartList = document.querySelectorAll('#cart-items li');
    cartList.forEach(item => {
        const name = item.getAttribute('data-name');
        const price = parseFloat(item.getAttribute('data-price'));
        const quantity = parseInt(item.getAttribute('data-quantity'));
        const canteen = item.getAttribute('data-canteen');
        cartItems.push({ name, price, quantity, canteen});
    });

    // Create a hidden form to submit the order
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = formAction; // Set the form action dynamically

    const cartInput = document.createElement('input');
    cartInput.type = 'hidden';
    cartInput.name = 'cart_items';
    cartInput.value = JSON.stringify(cartItems);
    form.appendChild(cartInput);

    const canteenInput = document.createElement('input');
    canteenInput.type = 'hidden';
    canteenInput.name = 'canteen';
    canteenInput.value = currentCanteen; // Include the selected canteen
    form.appendChild(canteenInput);

    const paymentMethodInput = document.createElement('input');
    paymentMethodInput.type = 'hidden';
    paymentMethodInput.name = 'payment_method'; // Ensure this matches the key in PHP
    paymentMethodInput.value = selectedPaymentMethod;
    form.appendChild(paymentMethodInput);

    const totalAmountInput = document.createElement('input');
    totalAmountInput.type = 'hidden';
    totalAmountInput.name = 'total_amount';
    totalAmountInput.value = totalAmount.toFixed(2);
    form.appendChild(totalAmountInput);

    document.body.appendChild(form);
    form.submit();


    function updateCartDisplay() {
        const cartItemsContainer = document.getElementById("cart-items");
        const cartTotal = document.getElementById("cart-total");

        if (!cartItemsContainer || !cartTotal) {
            console.error("Cart items container or cart total element is missing in the HTML.");
            return;
        }

        cartItemsContainer.innerHTML = "";
        let total = 0;

        cart.forEach(item => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;

            const listItem = document.createElement("li");
            listItem.textContent = `${item.name} (x${item.quantity}) - ₱${itemTotal.toFixed(2)}`;
            cartItemsContainer.appendChild(listItem);
        });

        cartTotal.textContent = `₱${total.toFixed(2)}`;
    }

    window.clearCart = function () {
        cart = [];
        updateCartDisplay();
    };

    window.placeOrder = function () {
        if (!localStorage.getItem("username")) {
            alert("You need to be logged in to place an order.");
            openBox('register');
            return;
        }

        if (cart.length === 0) {
            alert("Your cart is empty.");
            return;
        }

        alert("Order placed successfully! Staff has been notified.");
        clearCart();
    };

    function displayLoginAndRegisterButtons() {
        const authContainer = document.getElementById("auth-container"); // Ensure this element exists
        authContainer.innerHTML = `
            <button class="login-btn" onclick="location.href='login.php'">Login</button>
        `;
    }   
});
