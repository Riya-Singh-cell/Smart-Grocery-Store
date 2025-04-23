// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.0/firebase-app.js";
import { getAuth, signInWithPopup, GoogleAuthProvider, signOut } from "https://www.gstatic.com/firebasejs/11.6.0/firebase-auth.js";

// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyBrQMTZgOZ6j4qatryzWwAAEq9ptM9acW4",
  authDomain: "smart-grocery-store-b1436.firebaseapp.com",
  projectId: "smart-grocery-store-b1436",
  storageBucket: "smart-grocery-store-b1436.firebasestorage.app",
  messagingSenderId: "996674024401",
  appId: "1:996674024401:web:93d5a283a90aa3dae1a6f0",
  measurementId: "G-VLMKVXH664"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

// Initialize Firebase Authentication
const auth = getAuth(app);
const provider = new GoogleAuthProvider();

// Function to handle Google Sign-In
export function signInWithGoogle() {
  signInWithPopup(auth, provider)
    .then((result) => {
      const user = result.user;
      localStorage.setItem("user", JSON.stringify(user));
      alert(`Welcome, ${user.displayName}!`);
      updateAuthStatus();
    })
    .catch((error) => {
      console.error("Error during sign-in:", error);
      alert("Failed to sign in. Please try again.");
    });
}

// Function to handle Sign-Out
export function signOutUser() {
  signOut(auth)
    .then(() => {
      alert("You have signed out.");
      localStorage.removeItem("user");
      updateAuthStatus();
    })
    .catch((error) => {
      console.error("Error during sign-out:", error);
      alert("Failed to sign out. Please try again.");
    });
}

// Function to update authentication status
export function updateAuthStatus() {
  const user = JSON.parse(localStorage.getItem("user"));
  const authButton = document.getElementById("auth-btn");
  if (user) {
    authButton.textContent = `Welcome, ${user.displayName}`;
    authButton.onclick = signOutUser;
  } else {
    authButton.textContent = "Login / Sign Up";
    authButton.onclick = signInWithGoogle;
  }
}
