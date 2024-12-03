// check email address before registration
function emailExists() {
    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('email_error');
    const email = emailInput.value.trim();

    if (email === '') {
        emailError.textContent = 'Inserire un indirizzo email.';
        return false; 
    }

    // invoke the script to check if the email address is already used
    fetch('../php/checkemail.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `email=${encodeURIComponent(email)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'error') {
            emailError.textContent = data.message;
        } else if (data.status === 'success' && data.message === 'found data') {
            emailError.textContent = 'Mail già in uso. Inserire una diversa.';
            emailInput.value = ''; // Clear the input if the email is already registered
        } else {
            emailError.textContent = ''; // Clear any error message
        }
    })
    .catch(error => {
        console.log('Error:', error);
        emailError.textContent = 'An error occurred while checking the email.';
    });
    return false; 
}