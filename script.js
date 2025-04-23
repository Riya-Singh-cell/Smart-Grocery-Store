document.addEventListener("DOMContentLoaded", function () {
    
    hideElement("location-modal");
    hideElement("item-modal");
    hideElement("auth-modal");

    let savedLocation = localStorage.getItem("userLocation");
    let locationBtn = document.querySelector(".location-btn");
    if (savedLocation && locationBtn) {
        locationBtn.textContent = savedLocation;
    }

    addClickListener(".close-location", closeLocationModal);

    document.querySelectorAll('.product').forEach(item => {
        item.addEventListener('click', function () {
            let modalImg = document.getElementById('modal-img');
            let modalName = document.getElementById('modal-name');
            
            if (modalImg) modalImg.src = item.getAttribute('data-image');
            if (modalName) modalName.textContent = item.getAttribute('data-name');
        });
    });

    window.addEventListener('click', function (event) {
        if (event.target === document.getElementById("location-modal")) closeLocationModal();
        if (event.target === document.getElementById("item-modal")) hideElement("item-modal");
        if (event.target === document.getElementById("auth-modal")) hideElement("auth-modal");
    });

    updateCartCount();
    updateAuthStatus();
});

function hideElement(id) {
    let element = document.getElementById(id);
    if (element) element.style.display = "none";
}

function addClickListener(selector, callback) {
    let element = document.querySelector(selector);
    if (element) element.addEventListener("click", callback);
}

function openLocationModal() { document.getElementById("location-modal").style.display = "block"; }
function closeLocationModal() { hideElement("location-modal"); }

function fetchDistrict() {
    let pincodeInput = document.getElementById("pincode").value.trim();
    let districtText = document.getElementById("district-name");

    if (!pincodeInput.match(/^\d{6}$/)) {
        districtText.innerHTML = "⚠️ Invalid PIN Code!";
        return;
    }

    fetch(`https://api.postalpincode.in/pincode/${pincodeInput}`)
        .then(response => response.json())
        .then(data => {
            if (data[0] && data[0].Status === "Success") {
                let district = data[0].PostOffice[0].District;
                let fullLocation = `📍 ${district}, ${pincodeInput}`;
                localStorage.setItem("userLocation", fullLocation);
                districtText.innerHTML = `📍 Your District: <b>${district}</b>`;
                document.querySelector(".location-btn").textContent = fullLocation;
                closeLocationModal();
            } else {
                districtText.innerHTML = "⚠️ PIN Code not found!";
            }
        })
        .catch(error => {
            console.error("Error fetching district:", error);
            districtText.innerHTML = "⚠️ Error fetching district!";
        });
}

function updateCartCount() {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let totalItems = cart.reduce((sum, item) => sum + (item.quantity || 0), 0);
    let cartCountElement = document.querySelector(".cart-count");
    if (cartCountElement) cartCountElement.textContent = totalItems;
}

function openAuthModal() { document.getElementById("auth-modal").style.display = "block"; }
function closeAuthModal() { hideElement("auth-modal"); }

function switchToSignup() {
    document.getElementById("auth-form").innerHTML = `
        <input type="text" id="signup-name" placeholder="Full Name" required>
        <input type="email" id="signup-email" placeholder="Enter Email" required>
        <input type="password" id="signup-password" placeholder="Create Password" required>
        <button type="submit" onclick="handleSignup(event)">Sign Up</button>
    `;
}

function handleSignup(event) {
    event.preventDefault();

    let email = document.getElementById("signup-email").value.trim();
    let password = document.getElementById("signup-password").value.trim();

    if (!email || !password) {
        alert("⚠️ Please fill in all fields!");
        return;
    }

    localStorage.setItem("userEmail", email);
    localStorage.setItem("userPassword", password);
    alert("✅ Account created successfully!");
    window.location.href = "SmartGroceryStore.html";
}
function addToCart(name, price, image) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    let existingItem = cart.find(item => item.name === name);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({ name, price, image, quantity: 1 });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount();
    alert("Item added to cart! 🛒");
}

function goToCart() {
    window.location.href = "cart.html"; // Ensure you have a cart.html file
}
let cart = []; // Array to store cart items

function addToCart(itemName, price) {
    // Check if item already exists in the cart
    let existingItem = cart.find(item => item.name === itemName);

    if (existingItem) {
        existingItem.quantity += 1; // Increase quantity
    } else {
        cart.push({ name: itemName, price: price, quantity: 1 }); // Add new item
    }

    updateCartCount(); // Update UI
    saveCartToLocalStorage(); // Save data persistently
}

function updateCartCount() {
    let cartCount = cart.reduce((total, item) => total + item.quantity, 0); // Sum all quantities
    document.getElementById("cart-count").innerText = cartCount;
}

function saveCartToLocalStorage() {
    localStorage.setItem("cart", JSON.stringify(cart)); // Store cart data in local storage
}

// Load cart data when page reloads
window.onload = function () {
    let storedCart = localStorage.getItem("cart");
    if (storedCart) {
        cart = JSON.parse(storedCart);
        updateCartCount();
    }
};
function handleSearch(event) {
    event.preventDefault(); // stop form from reloading page

    const query = document.getElementById('search-input').value.trim().toLowerCase();

    if (query) {
        // Redirect to search results or filter products
        window.location.href = `search.html?query=${encodeURIComponent(query)}`;
    } else {
        alert("Please type something to search!");
    }

    return false;
}



