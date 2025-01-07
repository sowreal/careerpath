// Validation function for required fields
function validateRequiredFields(step) {
    const currentStepFields = document.querySelectorAll(`#step${step} input[required]`);
    for (const field of currentStepFields) {
        if (!field.value.trim()) {
            alert('Please fill out all required fields.');
            return false;
        }
    }
    return true;
}

// Validation for Employee ID (Step 1)
function validateEmployeeID() {
    const employeeID = document.querySelector('input[placeholder="Employee ID Number"]').value.trim();
    const isValid = /^[A-Z]{4}-[A-Z]{3}\d{4}$/.test(employeeID);
    if (!isValid) {
        alert('Employee ID must be in the format "ABCD-EFG1234"');
        return false;
    }
    return true;
}

// Validation for dropdowns in Step 1
function validateDropdowns() {
    const role = document.getElementById('role').value;
    const department = document.getElementById('department').value;
    if (role === "" || department === "") {
        alert('Please select your Role and Faculty/Department.');
        return false;
    }
    return true;
}

// Password validation (Step 2)
function validatePassword() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/;

    if (!passwordRegex.test(password)) {
        alert('Password must be at least 8 characters long, include uppercase, lowercase, a number, and a special character.');
        return false;
    }
    if (password !== confirmPassword) {
        alert('Passwords do not match.');
        return false;
    }
    return true;
}

// Validation for Terms and Conditions (Step 2)
function validateTerms() {
    const termsChecked = document.getElementById('terms').checked;
    if (!termsChecked) {
        alert('You must agree to the terms and conditions before proceeding.');
        return false;
    }
    return true;
}

// Validate email format
function validateEmail() {
    const email = document.querySelector('input[placeholder="Email Address"]').value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('Please enter a valid email address.');
        return false;
    }
    return true;
}
