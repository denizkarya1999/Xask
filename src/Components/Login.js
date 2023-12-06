import React, { useState } from 'react';
import '../Styles/Login.css';

const SignInComponent = () => {
  const [showSignUp, setShowSignUp] = useState(false);
  
  const openSignUpForm = () => {
    setShowSignUp(true);
  };

  return (
    <div>
      <div className="form-container" id="signin-form">
        <h2><strong>Sign In</strong></h2>
        {/* Is set to hidden normally. Set overflow: to visible when sign in failed */}
        <p className="additional-text"><strong>Username or password is not correct.</strong></p>
        <input type="email" id="email" name="email" placeholder="Enter your email" required />
        <input type="password" id="password" name="password" placeholder="Enter your password" required />
        <button type="submit"><strong>Sign In</strong></button>
        <a href="#" className="sign-up-link" onClick={openSignUpForm}><strong>Sign Up</strong></a>
      </div>

      {showSignUp && (
        <div className="form-container" id="signup-form">
          <h2><strong>Sign Up</strong></h2>
          <input type="text" id="firstName" name="firstName" placeholder="First Name" required />
          <input type="text" id="lastName" name="lastName" placeholder="Last Name" required />
          <input type="email" id="signupEmail" name="signupEmail" placeholder="Enter your email" required />
          <input type="password" id="signupPassword" name="signupPassword" placeholder="Enter your password" required />
          <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required />
          <button type="submit"><strong>Sign Up</strong></button>
        </div>
      )}
    </div>
  );
};

export default SignInComponent;