function openSignUpForm() {
    document.getElementById('signin-form').style.display = 'none';
    document.getElementById('signup-form').style.display = 'block';
}

// Get references to the form elements
const signInForm = document.getElementById('signin-form');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const signInError = document.querySelector('.additional-text');

async function signIn() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    try {
        await fetch(`http://localhost:8080/projects/Tasks/UserAccountAPI?email=${email}&password=${password}`, {
            mode: 'no-cors',
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });
        console.log('Sign in success');
        // Perform actions after successful sign-in
    } catch (error) {
        console.error('Error signing in:', error);
        // Handle error during sign-in process
    }
}

// Event listener for form submission
signInForm.addEventListener('submit', (event) => {
    event.preventDefault(); // Prevent the default form submission

    signIn(); // Call the sign-in function
});

// Function to switch to sign-up form
function openSignUpForm() {
    const signUpForm = document.getElementById('signup-form');
    signUpForm.style.display = 'block';
}