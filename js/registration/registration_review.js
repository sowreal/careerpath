// Populate review step with user-entered data
function populateReviewStep() {
    document.getElementById('reviewFirstName').textContent = document.querySelector('input[placeholder="First Name"]').value;
    
    const middleName = document.querySelector('input[placeholder="Middle Name (Optional)"]').value;
    const middleNameField = document.getElementById('reviewMiddleName').parentElement; // Get the parent element to hide both the label and value

    if (middleName.trim() !== "") {
        document.getElementById('reviewMiddleName').textContent = middleName; // Show middle name if provided
        middleNameField.style.display = "block"; // Ensure it's visible if there is a middle name
    } else {
        middleNameField.style.display = "none"; // Hide the middle name label and value if empty
    }

    document.getElementById('reviewLastName').textContent = document.querySelector('input[placeholder="Last Name"]').value;
    document.getElementById('reviewEmployeeID').textContent = document.querySelector('input[placeholder="Employee ID Number"]').value;
    
    // Fetch the email address and show it in the review step
    document.getElementById('reviewEmail').textContent = document.querySelector('input[placeholder="Email Address"]').value;
    
    document.getElementById('reviewRole').textContent = document.getElementById('role').value;
    document.getElementById('reviewDepartment').textContent = document.getElementById('department').value;
}
