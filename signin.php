<?php
session_start();
include('connection.php');
$email='';
$password='';
$found=true;

if(isset($_POST['login'])){
    $email=$_POST['email'];
    $password=$_POST['password'];
    $a_result=mysqli_query($conn,"SELECT admin_id,email,password from admin");
    $a_row=mysqli_fetch_array($a_result);
    if($email==$a_row['email'] && $password==$a_row['password']){
        $_SESSION['admin_id']=$a_row['admin_id'];
        $found=true;
        header('location:index.php');
        exit();
    }
    else{
        $found=false;
    }
    $m_result=mysqli_query($conn,"SELECT member_id,email,password from members");
    while($m_row=mysqli_fetch_array($m_result)){
        if($email==$m_row['email'] && $password==$m_row['password']){
            $_SESSION['member_id']=$m_row['member_id'];
            $found=true;
            header('location:index.php');
            exit();
        }
        else{
            $found=false;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Legends Fitness</title>
    <link rel="stylesheet" href="header-footer.css">
    <link rel="stylesheet" href="signin.css">
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

    <main class="login-container">
        <div class="login-wrapper">
            <div class="login-left">
                <div class="welcome-content">
                    <h1>Welcome Back to <span class="highlight">Legends Fitness</span></h1>
                    <p>Continue your fitness journey with us. Track your progress, book classes, and connect with our community.</p>
                    
                    <div class="features-list">
                        <div class="feature">
                            <span class="material-symbols-outlined">track_changes</span>
                            <div>
                                <h3>Track Progress</h3>
                                <p>Monitor your fitness journey with detailed analytics</p>
                            </div>
                        </div>
                        <div class="feature">
                            <span class="material-symbols-outlined">calendar_month</span>
                            <div>
                                <h3>Book Classes</h3>
                                <p>Reserve spots in our premium group classes</p>
                            </div>
                        </div>
                        <div class="feature">
                            <span class="material-symbols-outlined">groups</span>
                            <div>
                                <h3>Community Access</h3>
                                <p>Connect with trainers and fellow members</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial">
                        <p>"The member portal transformed how I track my fitness goals. Everything I need in one place!"</p>
                        <div class="testimonial-author">
                            <strong>James Wilson</strong>
                            <span>Member since 2020</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="login-right">
                <div class="login-form-container">
                    <div class="form-header">
                        <h2>Login</h2>
                        <p>Enter your credentials to access your account</p>
                    </div>
                    
                    <form class="login-form" id="loginForm" action="signin.php" method="POST">
                        <div class="form-group">
                            <label for="email">Email Address <span>*</span></label>
                            <div class="input-with-icon">
                                <span class="material-symbols-outlined">mail</span>
                                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password <span>*</span></label>
                            <div class="input-with-icon">
                                <span class="material-symbols-outlined">lock</span>
                                <input type="password" id="password" name="password" placeholder="Enter your password" required autocomplete="off">
                            </div>
                            <?php if($found==false){echo "<div class='error'><span class='material-symbols-outlined'>exclamation</span>Incorrect Email or Password</div>";} ?>
                        </div>
                        
                        
                        <button type="submit" class="login-button" name="login">
                            <span class="button-text">Sign In</span>
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </button>
                                           
                        <div class="signup-link">
                            <p>Don't have an account? <a href="signup.php">Create Account</a></p>
                            <p><a href="index.php" class="back-home"><span class="material-symbols-outlined">arrow_back</span> Back to Home</a></p>
                        </div>
                    </form>
                    <a class="forgot-pass" href="forgotpassword.php">Forgot Password?</a>
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