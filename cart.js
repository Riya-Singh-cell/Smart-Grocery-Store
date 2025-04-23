// ✅ Run when the page loads
document.addEventListener("DOMContentLoaded", function () {
    displayCart();
    updateCartCount();

    let cartButton = document.getElementById("cart-btn");
    if (cartButton) {
        cartButton.addEventListener("click", function () {
            window.location.href = "cart.html"; // Redirect to cart page
        });
    }
});

// ✅ Function to Add Items to Cart
function addToCart(name, price, image) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    
    // Check if the item already exists
    let existingItem = cart.find(item => item.name === name);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({ name, price, image, quantity: 1 });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount();
    alert("Item added to cart! 🛒");

    console.log("Cart after adding:", cart); // Debugging log
}

// ✅ Function to Display Cart Items in cart.html
function displayCart() {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let cartItemsContainer = document.getElementById("cart-items");
    let totalPriceElement = document.getElementById("total-price");

    cartItemsContainer.innerHTML = "";
    let total = 0;

    cart.forEach((item, index) => {
        let subtotal = item.price * item.quantity;
        total += subtotal;

        let row = document.createElement("tr");
        row.innerHTML = `
            <td><img src="${item.image}" alt="${item.name}" width="50" onerror="this.onerror=null; this.src='default.jpg';"> ${item.name}</td>
            <td>₹${item.price.toFixed(2)}</td>
            <td>
                <button class="quantity-btn" data-index="${index}" data-change="-1">-</button>
                ${item.quantity}
                <button class="quantity-btn" data-index="${index}" data-change="1">+</button>
            </td>
            <td>₹${subtotal.toFixed(2)}</td>
            <td><button class="remove-btn" data-index="${index}">❌</button></td>
        `;

        cartItemsContainer.appendChild(row);
    });

    totalPriceElement.textContent = `₹${total.toFixed(2)}`;
    updateCartCount();
}

// ✅ Function to Change Item Quantity (+ or -)
document.addEventListener("click", function (event) {
    if (event.target.classList.contains("quantity-btn")) {
        let index = event.target.getAttribute("data-index");
        let change = parseInt(event.target.getAttribute("data-change"));
        changeQuantity(index, change);
    }
});

function changeQuantity(index, change) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    if (cart[index].quantity + change > 0) {
        cart[index].quantity += change;
    } else {
        cart.splice(index, 1);
    }
    localStorage.setItem("cart", JSON.stringify(cart));
    displayCart();
}

// ✅ Function to Remove Item
document.addEventListener("click", function (event) {
    if (event.target.classList.contains("remove-btn")) {
        let index = event.target.getAttribute("data-index");
        removeItem(index);
    }
});

function removeItem(index) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart.splice(index, 1);
    localStorage.setItem("cart", JSON.stringify(cart));
    displayCart();
}

// ✅ Function to Update Cart Count
function updateCartCount() {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let cartCountElement = document.querySelector(".cart-count");

    if (cartCountElement) {
        let totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartCountElement.textContent = totalQuantity;
    }
}

// ✅ Checkout Function
// Save cart data before redirecting
function proceedToCheckout() {
    // Optionally, you can check if the cart is empty
    const cartItems = document.getElementById("cart-items");
    if (cartItems.children.length === 0) {
        alert("Your cart is empty! 🛒 Add some goodies first.");
        return;
    }

    // Redirect to checkout page
    window.location.href = "checkout.html";
}


// ✅ Clear Cart Function
function clearCart() {
    localStorage.removeItem("cart");
    displayCart();
}

// ✅ Call updateCartCount() on page load
document.addEventListener("DOMContentLoaded", function () {
    updateCartCount();
});


