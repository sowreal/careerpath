const nextBtn = document.getElementById('next-btn');
const backBtn = document.getElementById('back-btn');
const submitBtnStep4 = document.getElementById('submit-btn-step4');
const confirmBtnStep3 = document.getElementById('confirm-btn-step3'); // Added for step 3 confirm button

let currentStep = 1;
let returnToReviewStep = false; // Track if returning to the review step after editing

// Toggle button visibility based on the step
function toggleButtons(step) {
    backBtn.classList.toggle('d-none', step === 1 || step === 4); // Hide Back button on Step 1 and Step 4
    nextBtn.classList.toggle('d-none', step === 3 || step === 4); // Hide Next button in Step 3 and Step 4
    submitBtnStep4.classList.toggle('d-none', step !== 4);        // Show Verify button only in Step 4
    confirmBtnStep3.classList.toggle('d-none', step !== 3);       // Show Confirm button only in Step 3
}

// Function to populate the review step (Step 3)
function populateReviewStep() {
    const firstName = document.querySelector('input[name="first_name"]').value;
    const middleName = document.querySelector('input[name="middle_name"]').value || 'N/A';
    const lastName = document.querySelector('input[name="last_name"]').value;
    const employeeID = document.querySelector('input[name="employee_id"]').value;
    const role = document.querySelector('select[name="role"]').value;
    const department = document.querySelector('select[name="department"]').value;
    const email = document.querySelector('input[name="email"]').value;

    document.getElementById('reviewFirstName').textContent = firstName;
    document.getElementById('reviewMiddleName').textContent = middleName;
    document.getElementById('reviewLastName').textContent = lastName;
    document.getElementById('reviewEmployeeID').textContent = employeeID;
    document.getElementById('reviewRole').textContent = role;
    document.getElementById('reviewDepartment').textContent = department;
    document.getElementById('reviewEmail').textContent = email;

    console.log("Review Step - Data Collected:", { firstName, middleName, lastName, employeeID, role, department, email });
}

// Prevent form submission on Enter for all steps except the final one
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('signupForm').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent default form submission
            if (currentStep < 4) {
                nextBtn.click(); // Simulate clicking the "Next" button
            }
        }
    });
});

// Event listeners for the Next button (Steps 1-3)
nextBtn.addEventListener('click', function() {
    console.log("Current Step:", currentStep); // Log the current step

    // Handle Step 1 logic
    if (currentStep === 1) {
        if (!validateRequiredFields(1) || !validateEmployeeID() || !validateDropdowns()) {
            console.log("Validation failed in Step 1");
            return; // Prevent advancing if validation fails in Step 1
        }

        // Check if the user is returning to Step 3 after editing details in Step 1
        if (returnToReviewStep) {
            currentStep = 3; // Jump directly to Step 3
            returnToReviewStep = false; // Reset the flag
            populateReviewStep();  // Re-populate the fields in Step 3 after editing
        } else {
            currentStep++; // Proceed to Step 2
        }

        updateProgress(currentStep);
        toggleButtons(currentStep);
        return;
    }

    // Handle Step 2 logic
    if (currentStep === 2) {
        const email = document.querySelector('input[name="email"]').value;

        // Perform an AJAX request to check if the email already exists
        fetch('php/check_email.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'email=' + encodeURIComponent(email)
        })
        .then(response => response.json())  // Expect a JSON response
        .then(data => {
            if (data.exists) {
                document.getElementById('email-error').textContent = "This email is already registered. Please use another email.";
            } else {
                document.getElementById('email-error').textContent = "";  // Clear error message

                // Proceed to Step 3 and ensure the review section is updated
                if (!validateRequiredFields(2) || !validateEmail() || !validateTerms() || !validatePassword()) {
                    console.log("Validation failed in Step 2");
                    return; // Prevent advancing if validation fails in Step 2
                }

                console.log("Transitioning to Step 3 - Populating review...");
                populateReviewStep(); // Ensure review data is populated for Step 3
                currentStep++; // Move to Step 3
                updateProgress(currentStep);
                toggleButtons(currentStep);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('email-error').textContent = "An error occurred while checking the email. Please try again.";
        });
        return; // Prevent immediate advancing to Step 3 until email check completes
    }

    // Handle Step 3 and Step 4 logic
    if (currentStep < 4) {
        currentStep++;
    }

    console.log("Moving to Step:", currentStep); // Log the new step

    updateProgress(currentStep); // Move to the next step
    toggleButtons(currentStep);  // Adjust button visibility
});


// Event listener for the single Back button (all steps)
backBtn.addEventListener('click', function() {
    if (currentStep > 1) {
        currentStep--;
        updateProgress(currentStep); // Move to the previous step
        toggleButtons(currentStep);  // Adjust button visibility
    }
});

// Function to navigate to a specific step for editing (called from `registration_review.js`)
function editStep(stepNumber) {
    currentStep = stepNumber; // Set the current step to the one we are editing
    returnToReviewStep = true; // Set flag to true when user comes from the review step
    updateProgress(currentStep); // Update the progress bar
    toggleButtons(currentStep); // Show correct buttons
}

// Form submission handler for Step 4
let isSubmitListenerAttached = false;  // To track if the listener has already been attached

// Form submission handler for Step 4
function submitForm() {
    if (!isSubmitListenerAttached) {
        alert('Form submitted successfully!');
        document.getElementById('signupForm').submit();
        isSubmitListenerAttached = true; // Prevent multiple form submissions
    }
}

