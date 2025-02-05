document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const USNInput = document.getElementById('USN');
    const passwordInput = document.getElementById('password');
    const USNError = document.getElementById('USN-error');
    const passwordError = document.getElementById('password-error');
    
    let valid = true;

    // Validate USN
    const USNValue = USNInput.value.trim();
    
    // Check if non-numeric is entered
    if (!/^\d*$/.test(USNValue)) {
        USNError.innerHTML = 'Numeric characters only.';
        USNError.style.display = 'block';
        valid = false;
    } else {
        USNError.textContent = ''; // Clear error message
        USNError.style.display = 'none'; // Hide error if valid
    }

    // Validate password
    if (!passwordInput.value) {
        passwordError.textContent = 'Please enter your password';
        passwordError.style.display = 'block';
        valid = false;
    } else {
        passwordError.textContent = '';
        passwordError.style.display = 'none';
    }

    if (valid) {
        alert('Login Successful!');
        // Replace this with actual authentication logic
    }
});

// Real-time validation for USN input
document.getElementById('USN').addEventListener('input', function() {
    const USNValue = this.value.trim();
    const USNError = document.getElementById('USN-error');

    // Check if non-numeric is entered
    if (!/^\d*$/.test(USNValue)) {
        USNError.textContent = 'Numeric characters only.';
        USNError.style.display = 'block';
   
    } else if (USNValue.length > 12) {
        // Show error if more than 12 characters
        USNError.textContent = 'Should not exceed 12 characters';
        USNError.style.display = 'block';
    } else {
        USNError.textContent = ''; // Hide error if valid
        USNError.style.display = 'none';
    }
});
