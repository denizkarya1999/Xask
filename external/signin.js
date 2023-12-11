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
    try{
        //http://localhost:8080/projects/Tasks/UserAccountAPI?email=${email}&password=${password}
        //https://jsonplaceholder.typicode.com/users
        console.log('looking for response')
        fetch('http://localhost:8080/projects/Tasks/UserAccountAPI/',{
            mode:'no-cors',
            method:'Get',
            headers:{
                'Content-Type' : 'application/json',
            },
        })
        .then(response=> {
            if(!response.ok){
                console.log('problem');
                return;
            }
            return response.json();
        }).then(data => {
            console.log(data.email);
        });
    }
    catch(error){
    console.log(error);
    }
    window.location.href = 'http://localhost:8080/projects/external/tasklist.html';
}//end signIn()

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