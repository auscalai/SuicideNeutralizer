const sliders = document.querySelectorAll(".toggle");
const balls = document.querySelectorAll(".toggle-ball");
const items = document.querySelectorAll(".content-container, .toggle, .single, span, label, .btn-primary, .profile-info, .close, .close-modal, .custom-file-upload, .consultant-info, .consultant-btn, .intro, .intro-section, #quotes-text");
const contentContainer = document.querySelector(".content-container");

// Function to set a cookie
function setCookie(name, value, days) {
  const expires = new Date();
  expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
  document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/`;
}

// Function to get a cookie by name
function getCookie(name) {
  const keyValue = document.cookie.match(`(^|;) ?${name}=([^;]*)(;|$)`);
  return keyValue ? keyValue[2] : null;
}

// Function to toggle dark mode
function toggleDarkMode() {
  items.forEach(item => {
    item.classList.toggle("active");
  });
  balls.forEach(ball => {
    ball.classList.toggle("active");
  });

  // Store the dark mode preference in a cookie
  const newDarkModeState = balls[0].classList.contains("active"); // Use the state of the first toggle
  setCookie("darkMode", newDarkModeState.toString(), 365); // Store for 1 year
}

// Check if dark mode preference is stored in cookies
const isDarkMode = getCookie("darkMode") === "true";

// Set initial dark mode state based on cookies
if (isDarkMode) {
  toggleDarkMode();
}

// Add click event listeners to all toggle buttons
sliders.forEach(slider => {
  slider.addEventListener("click", toggleDarkMode);
});
