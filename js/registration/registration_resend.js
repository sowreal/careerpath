function resendCode() {

    // Disable the resend link to prevent multiple clicks
    const resendLink = document.getElementById('resend-link');
    resendLink.innerHTML = 'Resending...';
    resendLink.style.pointerEvents = 'none';  // Disable the link

    // Send an AJAX request to resend the verification code
    fetch('php/resend-verification.php')  // Make sure the correct path is used
        .then(response => response.text())
        .then(data => {
            console.log("Server Response:", data);

            // Check if the resend process succeeded
            if (data.includes('Verification code has been resent')) {
                alert("Verification code resent! Please check your inbox.");  // Same pop-up as Step 3
            } else {
                alert("Error: " + data);  // Show server error message
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while resending the verification code. Please try again.');
        })
        .finally(() => {
            // Re-enable the resend link after a short delay (optional)
            setTimeout(() => {
                resendLink.innerHTML = 'Didn\'t receive the code? Resend.';
                resendLink.style.pointerEvents = 'auto';  // Re-enable the link
            }, 2000);  // Delay of 5 seconds (you can adjust this time)
        });
}