let isVerificationListenerAttached = false;  // To track if the listener has already been attached
let isFormSubmitting = false;  // Flag to prevent multiple submissions

// Handle Step 3: User clicks "Confirm and Submit"
document.getElementById('confirm-btn-step3').addEventListener('click', function () {
    if (isFormSubmitting) return;  // Prevent multiple submissions

    isFormSubmitting = true;  // Set flag to true to prevent resubmission

    const confirmBtn = document.getElementById('confirm-btn-step3');

    // Disable the button and change text to prevent multiple submissions
    confirmBtn.innerHTML = 'Submitting...';
    confirmBtn.disabled = true;

    // Collect form data
    const formData = new FormData(document.getElementById('signupForm'));

    // Send data via AJAX to register.php
    fetch('php/register.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        console.log("Server Response:", data);

        // Check if the email verification process succeeded
        if (data.includes('Verification email sent')) {
            alert("Verification email sent! Please check your inbox.");
            document.getElementById('step3').classList.add('d-none'); // Hide Step 3
            document.getElementById('step4').classList.remove('d-none'); // Show Step 4

            // Ensure the progress bar is updated for Step 4
            currentStep = 4;  // Update the step to 4
            updateProgress(currentStep);  // Call the progress bar update function

            // Attach the event listener to the verification form when Step 4 is shown (only once)
            if (!isVerificationListenerAttached) {
                const form = document.getElementById('verificationForm');
                if (form) {
                    form.addEventListener('submit', function (event) {
                        event.preventDefault();  // Prevent form from refreshing the page

                        const verificationCode = document.getElementById('verification_code').value;

                        // Send verification code via AJAX
                        fetch('php/verification.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: new URLSearchParams({
                                verification_code: verificationCode,
                            }),
                        })
                        .then(response => response.text())
                        .then(data => {
                            console.log("Verification Response:", data);

                            if (data.includes('Verification successful')) {
                                window.location.href = '../php/success.php';  // Redirect to success page
                            } else {
                                document.getElementById('verification-message').innerHTML = "<span style='color:red;'>" + data + "</span>";
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred during verification. Please try again.');
                        });

                        return false;  // Ensure the form doesn't submit the default way
                    });
                    isVerificationListenerAttached = true;  // Set flag to true to prevent multiple listeners
                } else {
                    console.error('Verification form not found.');
                }
            }

        } else {
            document.getElementById('step3-error').innerHTML = "Error: " + data;  // Show server error message in Step 3
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('step3-error').innerHTML = 'An error occurred while sending the verification email. Please try again.';  // Show error
    })
    .finally(() => {
        // Re-enable the "Confirm and Submit" button after a short delay
        setTimeout(() => {
            confirmBtn.innerHTML = 'Confirm';  // Reset the button text
            confirmBtn.disabled = false;  // Re-enable the button
            isFormSubmitting = false;  // Reset the flag after the process
        }, 2000);  // Optional delay of 2 seconds
    });
});


// Handle form submission on Step 4 (when the Verify button is clicked)
document.getElementById('signupForm').addEventListener('submit', function(event) {
    if (currentStep === 4) {  // Ensure it's the final step
        event.preventDefault();  // Prevent default form submission to avoid page reload

        // Get the verification code from the input
        const verificationCode = document.getElementById('verification_code').value;

        // Check if the verification code input is empty
        if (verificationCode === "") {
            document.getElementById('verification-message').innerHTML = "Please enter the verification code.";
            return;
        }

        // Prepare the form data for submission
        const formData = new FormData(this);  // This includes all form data

        // Send the data via AJAX to verification.php
        fetch('php/verification.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())  // Parse response as text
        .then(data => {
            document.getElementById('verification-message').innerHTML = data;

            if (data.includes('Verification successful')) {
                window.location.href = 'php/success.php';  // Redirect after success
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('verification-message').innerHTML = 'There was an error processing the verification. Please try again.';
        });
    }
});
