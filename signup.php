<?php
include('connection.php');
$member_id='';
$fname='';
$lname='';
$phoneno='';
$email='';
$password='';
$cpassword='';
$plan='';
$match=true;

if(isset($_POST['create'])){
    $fname=$_POST['firstName'];
    $lname=$_POST['lastName'];
    $phoneno=$_POST['phone'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $cpassword=$_POST['confirmPassword'];
    $plan=$_POST['plan'];
    if ($password !== $cpassword) {
        $match=false;
    }
    else{
        mysqli_query($conn,"INSERT INTO members (first_name, last_name, email, password, phone_no) VALUES ('$fname', '$lname', '$email', '$password', '$phoneno')");
        $member_id=mysqli_insert_id($conn);
        mysqli_query($conn,"INSERT into member_plans(member_id,plan_id) values('$member_id','$plan')");
        header('location:signin.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | Legends Fitness</title>
    <link rel="stylesheet" href="header-footer.css">
    <link rel="stylesheet" href="signup.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton+SC&family=Bowlby+One+SC&family=Contrail+One&family=Fugaz+One&family=New+Amsterdam&family=Outfit:wght@100..900&family=Racing+Sans+One&family=Science+Gothic:wght@100..900&family=Zen+Dots&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <input type="checkbox" id="menu">
    <header>
        <div class="left">
            <label for="menu">
                <div id="menu-icon" class="material-symbols-outlined">menu</div>
            </label>
            <div class="logo"><img src="pics/LEGEDS_FITNESS2-removebg-preview.png" alt="" id="logo"></div>
        </div>
        <div class="right">
            <div class="labels">
                <a href="index.php">HOME</a>
                <a href="membership.php">MEMBERSHIP</a>
                <a href="programs.php">PROGRAMS</a>
                <a href="about.php">ABOUT US</a>
                <a href="contact.php">CONTACT</a>
            </div>
        </div>
    </header>
    
    <nav class="mobile-nav">
        <a href="index.php"><span class="material-symbols-outlined icon">home</span> HOME</a>
        <a href="membership.php"><span class="material-symbols-outlined icon">card_membership</span>MEMBERSHIP</a>
        <a href="programs.php"><span class="material-symbols-outlined icon">fitness_center</span>PROGRAMS</a>
        <a href="about.php"><span class="material-symbols-outlined icon">info</span>ABOUT US</a>
        <a href="contact.php"><span class="material-symbols-outlined icon">call</span>CONTACT</a>
    </nav>

    <main class="signup-container">
        <div class="signup-wrapper">
            <!-- Left Panel - Benefits -->
            <div class="signup-left">
                <div class="benefits-content">
                    <h1>Start Your <span class="highlight">Fitness Journey</span> Today</h1>
                    <p class="subtitle">Join our community of 2,500+ members and transform your life</p>
                    
                    <div class="benefits-list">
                        <div class="benefit">
                            <span class="material-symbols-outlined">check_circle</span>
                            <div>
                                <h3>Free 7-Day Trial</h3>
                                <p>Experience our facilities with zero commitment</p>
                            </div>
                        </div>
                        <div class="benefit">
                            <span class="material-symbols-outlined">check_circle</span>
                            <div>
                                <h3>Personalized Workout Plan</h3>
                                <p>Get a customized fitness plan based on your goals</p>
                            </div>
                        </div>
                        <div class="benefit">
                            <span class="material-symbols-outlined">check_circle</span>
                            <div>
                                <h3>24/7 Access</h3>
                                <p>Work out on your schedule, any time of day</p>
                            </div>
                        </div>
                        <div class="benefit">
                            <span class="material-symbols-outlined">check_circle</span>
                            <div>
                                <h3>Expert Trainer Support</h3>
                                <p>Access to our certified fitness professionals</p>
                            </div>
                        </div>
                        <div class="benefit">
                            <span class="material-symbols-outlined">check_circle</span>
                            <div>
                                <h3>Nutrition Guidance</h3>
                                <p>Complimentary nutrition consultation</p>
                            </div>
                        </div>
                        <div class="benefit">
                            <span class="material-symbols-outlined">check_circle</span>
                            <div>
                                <h3>Group Classes Included</h3>
                                <p>Unlimited access to all group fitness classes</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial">
                        <p>"Signing up was the best decision I made. The community support kept me motivated every step of the way!"</p>
                        <div class="testimonial-author">
                            <strong>Sarah Johnson</strong>
                            <span>Lost 45lbs in 6 months</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Panel - Signup Form -->
            <div class="signup-right">
                <div class="signup-form-container">
                    <div class="form-header">
                        <h2>Create Your Account</h2>
                        <p>Fill in your details to join Legends Fitness</p>
                    </div>
                    
                    <form class="signup-form" id="signupForm" action="signup.php" method="POST">
                        <!-- Name Fields -->
                        <div class="form-row">
                            <div class="form-group half">
                                <label for="firstName">First Name <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <span class="material-symbols-outlined">person</span>
                                    <input type="text" id="firstName" name="firstName" placeholder="Enter your first name" required>
                                </div>
                            </div>
                            
                            <div class="form-group half">
                                <label for="lastName">Last Name <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <span class="material-symbols-outlined">person</span>
                                    <input type="text" id="lastName" name="lastName" placeholder="Enter your last name" required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <div class="input-with-icon">
                                <span class="material-symbols-outlined">mail</span>
                                <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                            </div>
                        </div>
                        
                        <!-- Phone -->
                        <div class="form-group">
                            <label for="phone">Phone Number <span class="required">*</span></label>
                            <div class="input-with-icon">
                                <span class="material-symbols-outlined">call</span>
                                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" minlength="11" maxlength="12" required>
                            </div>
                        </div>
                        <!-- Password Fields -->
                        <div class="form-row">
                            <div class="form-group half">
                                <label for="password">Password <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <span class="material-symbols-outlined">lock</span>
                                    <input type="password" id="password" name="password" placeholder="Create password"                     
                                        title="Minimum 8 characters" 
                                        required autocomplete="off">
                                    </button>
                                </div>
                                <?php if($match==false){echo "<div class='error'><span class='material-symbols-outlined'>exclamation</span>Passwords do not match</div>";} ?>
                            </div>
                            
                            <div class="form-group half">
                                <label for="confirmPassword">Confirm Password <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <span class="material-symbols-outlined">lock</span>
                                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm password"
                                        title="Minimum 8 characters" 
                                        required autocomplete="off"> 
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Membership Radio Buttons -->
                        <div class="form-group">
                            <label class="section-label">Choose Your Membership <span class="required">*</span></label>
                            <div class="radio-group">
                                <label class="radio-option">
                                    <input type="radio" name="plan" value="1" required>
                                    <span class="radio-custom"></span>
                                    <div class="radio-content">
                                        <h3>Starter</h3>
                                        <p>Basic gym access, 5 classes/month</p>
                                        <span class="price">$25/<sub>month</sub></span>
                                    </div>
                                </label>
                                
                                <label class="radio-option">
                                    <input type="radio" name="plan" value="2" checked>
                                    <span class="radio-custom"></span>
                                    <div class="radio-content">
                                        <h3>Pro</h3>
                                        <p>24/7 access, unlimited classes, 2 training sessions</p>
                                        <span class="price">$40/<sub>month</sub></span>
                                    </div>
                                </label>
                                
                                <label class="radio-option">
                                    <input type="radio" name="plan" value="3">
                                    <span class="radio-custom"></span>
                                    <div class="radio-content">
                                        <h3>Elite</h3>
                                        <p>VIP benefits, 5 training sessions, priority access</p>
                                        <span class="price">$50/<sub>month</sub></span>
                                    </div>
                                </label>
                                
                                <label class="radio-option">
                                    <input type="radio" name="plan" value="4">
                                    <span class="radio-custom"></span>
                                    <div class="radio-content">
                                        <h3>Trial</h3>
                                        <p> Free 7-day trial, no commitment</p>
                                        <span class="price">Free</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Terms and Conditions -->
                        <div class="form-group terms-group">
                            <span class="terms-text">
                                By creating an account, you agree to the <a href="terms.php" target="_blank">Terms & Conditions</a> and <a href="privacy.php" target="_blank">Privacy Policy</a> <span class="required"></span>
                            </span>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="signup-button" name="create">
                            <span class="button-text">Create Account</span>
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </button>
                        
                        <div class="login-link">
                            <p>Already have an account? <a href="signin.php">Sign In</a></p>
                            <p><a href="index.php" class="back-home"><span class="material-symbols-outlined">arrow_back</span> Back to Home</a></p>
                        </div>
                    </form>
                    <p class="trial-terms">
                        <label for="trialModalToggle" class="trial-details-link">
                            <span class="material-symbols-outlined">help</span>
                            How the Free trial works?
                        </label>
                    </p>

                    <input type="checkbox" id="trialModalToggle" class="modal-toggle">

                    <label for="trialModalToggle" class="modal-overlay"></label>

                    <div class="modal-content-wrapper">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2><span class="material-symbols-outlined">loyalty</span> Free Trial Details</h2>
                                <label for="trialModalToggle" class="modal-close">
                                    <span class="material-symbols-outlined">close</span>
                                </label>
                            </div>
                            <div class="modal-body">                      
                                <ul>
                                    <li><span class="material-symbols-outlined">done_all</span>No credit card required for trial signup</li>
                                    <li><span class="material-symbols-outlined">done_all</span>Full access to all facilities for 7 days</li>
                                    <li><span class="material-symbols-outlined">done_all</span>Trial automatically expires after 7 days</li>
                                    <li><span class="material-symbols-outlined">done_all</span>No obligation to continue</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-support">
                        <p><span class="material-symbols-outlined">support_agent</span> Need help? <a href="contact.php">Contact Support</a> or call (555) 123-4567</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-col">
                    <div class="logo"><img src="pics/LEGEDS_FITNESS2-removebg-preview.png" alt="" id="logo"></div>
                    <p>We are committed to helping you achieve your fitness goals in a supportive and motivating environment.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <div class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="programs.php">Programs</a></li>
                        <li><a href="membership.php">Membership</a></li>
                        <li><a href="about.php">About Us</a></li>
                    </div>
                </div>
                <div class="footer-col">
                    <h3>Contact Us</h3>
                    <div class="contact-info">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <div>123 Fitness Street, Health City, HC 12345</div>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <div>(555) 123-4567</div>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <div>info@legendsfitness.com</div>
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            <div>Open 24/7</div>
                        </li>
                    </div>
                </div>
                <div class="footer-col">
                    <h3>Legal</h3>
                    <div class="footer-links">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Careers</a></li>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 Legends Fitness. All rights reserved. | Designed for fitness enthusiasts</p>
            </div>
        </div>
    </footer>
</body>
</html>