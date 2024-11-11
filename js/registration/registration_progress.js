
// Function to update progress bar and form visibility
function updateProgress(step) {
    const steps = document.querySelectorAll('#progressbar .step');
    steps.forEach((stepElement, index) => {
        stepElement.classList.toggle('active', index < step);
    });

    const formSections = document.querySelectorAll('.step-form');
    formSections.forEach((form, index) => {
        form.classList.toggle('d-none', index !== step - 1);
    });

    toggleButtons(step);
}

// Function to move to Step 4 after verification is sent
function moveToStep4() {
    currentStep = 4;  // Ensure current step is updated to 4 when transitioning to Step 4
    updateProgress(currentStep);  // Update progress bar and form visibility for Step 4
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function () {
    updateProgress(currentStep); // Set the first step active
});
