import React, { useState } from 'react';
import '../Styles/Login.css';

const SignInComponent = () => {
  const [showSignUp, setShowSignUp] = useState(false);
  const [signInError, setSignInError] = useState(false); // State for sign-in error

  const openSignUpForm = () => {
    setShowSignUp(true);
  };

  const signIn = async (email, password) => {
    try {
      const response = await fetch(`http://localhost:8080/projects/Tasks/UserAccountAPI/index.php?email=${email}&password=${password}`, {
        mode: 'no-cors', 
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
        }
      });

      console.log(response);

      const textData = await response.text();
      const jsonData = textData ? JSON.parse(textData) : null;

      console.log(jsonData);
      
      if (jsonData!= null) {
        console.log('Sign in success');
        // Perform actions after successful sign-in
      } else {
        console.error('Sign in failed:', response.statusText);
        setSignInError(true); // Set sign-in error state
      }
    } catch (error) {
      console.error('Error signing in:', error);
      // Handle error during sign-in process
    }
  };

  const signUp = async (firstName, lastName, email, password, productivityscore) => {
    try {
      // Make a POST request to the user sign-up endpoint of your API
      const response = await fetch('http://localhost:8080/projects/Tasks/UserAccountAPI', {
        mode: 'no-cors', 
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ firstName, lastName, email, password, productivityscore }),
      });

      // Handle response - check status codes, set tokens, etc.
      if (response.ok) {
        // Sign-up success
        setShowSignUp(false); // Hide sign-up form
        console.log('Sign up success');
      } else {
        // Sign-up failed
      }
    } catch (error) {
      // Handle error
      console.error('Error signing up:', error);
    }
  };

  const handleSignIn = (e) => {
    e.preventDefault();
    const email = e.target.email.value;
    const password = e.target.password.value;
    signIn(email, password);
  };
  

  const handleSignUp = (e) => {
    e.preventDefault();
    const firstName = e.target.firstName.value;
    const lastName = e.target.lastName.value;
    const email = e.target.signupEmail.value;
    const password = e.target.signupPassword.value;
    const productivityscore = 100;
    signUp(firstName, lastName, email, password, productivityscore);
  };
  
  return (
    <div>
      <div className="form-container" id="signin-form">
        <h2><strong>Sign In</strong></h2>
        {signInError && <p className="additional-text"><strong>Username or password is not correct.</strong></p>}
        <form onSubmit={handleSignIn}>
          <input type="email" id="email" name="email" placeholder="Enter your email" required />
          <input type="password" id="password" name="password" placeholder="Enter your password" required />
          <button type="submit"><strong>Sign In</strong></button>
        </form>
        <a href="#" className="sign-up-link" onClick={openSignUpForm}><strong>Sign Up</strong></a>
      </div>

      {showSignUp && (
        <div className="form-container" id="signup-form">
          <h2><strong>Sign Up</strong></h2>
          <form onSubmit={handleSignUp}>
            <input type="text" id="firstName" name="firstName" placeholder="First Name" required />
            <input type="text" id="lastName" name="lastName" placeholder="Last Name" required />
            <input type="email" id="signupEmail" name="signupEmail" placeholder="Enter your email" required />
            <input type="password" id="signupPassword" name="signupPassword" placeholder="Enter your password" required />
            <button type="submit"><strong>Sign Up</strong></button>
          </form>
        </div>
      )}
    </div>
  );
};

export default SignInComponent;
