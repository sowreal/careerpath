const inputs = document.querySelectorAll('input');

// Function to update placeholder color
function updatePlaceholderColor(input) {
    if (input.value === '') {
        input.style.color = '#888'; // Placeholder color (gray)
    } else {
        input.style.color = '#000'; // Input text color (black)
    }
}

// Initialize placeholder colors on page load
inputs.forEach(input => {
    updatePlaceholderColor(input);
    input.addEventListener('input', function() {
        updatePlaceholderColor(input);
    });
    input.addEventListener('blur', function() {
        updatePlaceholderColor(input);
    });
});
