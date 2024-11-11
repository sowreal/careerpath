// Function to toggle password visibility
function togglePassword(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const icon = passwordField.nextElementSibling.querySelector('i');

    if (passwordField.type === "password") {
        passwordField.type = "text"; // Show the password
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = "password"; // Hide the password
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Show/Hide Password Icon Handling
const passwordField = document.getElementById('password');
const confirmPasswordField = document.getElementById('confirmPassword');
const passwordIcon = passwordField.nextElementSibling;
const confirmPasswordIcon = confirmPasswordField.nextElementSibling;

function showIcon(inputField, iconElement) {
    if (inputField.value !== '') {
        iconElement.style.display = 'inline'; // Show the icon
    } else {
        iconElement.style.display = 'none'; // Hide the icon if empty
    }
}

// Event listeners for password fields
passwordField.addEventListener('input', function() {
    showIcon(passwordField, passwordIcon);
});
confirmPasswordField.addEventListener('input', function() {
    showIcon(confirmPasswordField, confirmPasswordIcon);
});
