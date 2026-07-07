<?php
session_start();
if(isset($_GET['logout'])){
    session_destroy();
    header('location:index.php');
    exit();
}
include('connection.php');
$loggedin=false;
if(isset($_SESSION['member_id'])){
    $loggedin=true;
    $id=$_SESSION['member_id'];
    $query=mysqli_query($conn, "SELECT* from members where member_id='$id'");
    $info=mysqli_fetch_array($query);
}
if(isset($_SESSION['admin_id'])){
    $loggedin=true;
    $id=$_SESSION['admin_id'];
    $query=mysqli_query($conn, "SELECT* from admin where admin_id='$id'");
    $info=mysqli_fetch_array($query);
    $user='admin';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Legends Fitness</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="header-footer.css">
    <link rel="stylesheet" href="contact.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton+SC&family=Bowlby+One+SC&family=Contrail+One&family=Fugaz+One&family=New+Amsterdam&family=Outfit:wght@100..900&family=Racing+Sans+One&family=Science+Gothic:wght@100..900&family=Zen+Dots&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<style>
    .profile-box{display: <?php echo $loggedin ? 'flex' : 'none'; ?>}
    .join{display: <?php echo $loggedin ? 'none' : 'flex'; ?>}
</style>
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
                <a href="contact.php" class="active">CONTACT</a>
            </div>
            <div class="profile-box">           
                <label class="profile">
                    <input type="checkbox" class="check">
                    <div class="prof-info">
                        <span class="material-symbols-outlined">account_circle</span>
                        <p><?php echo $info['first_name'].' '.$info['last_name']; ?></p>
                        <span id="arrow" class="material-symbols-outlined">arrow_drop_down</span>
                    </div>
                    <div class="hover-box">
                        <a href="<?php if($user=='admin') echo 'admin.php'; else echo 'member.php';?>">Dashboard</a><hr>
                        <a href="index.php?logout=1">Logout<span class="material-symbols-outlined">logout</span></a>
                    </div>
                </label>
            </div>
            <div class="join">
                <a href="signup.php">JOIN US TODAY</a><hr>
                <a href="signin.php">LOGIN</a>
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
    
    <main class="contact-page">
        <!-- Hero Section -->
        <section class="contact-hero">
            <div class="hero-content">
                <h1>Get In <span class="highlight">Touch</span></h1>
                <p>We're here to help you start your fitness journey. Reach out with any questions or schedule a tour.</p>
            </div>
        </section>

        <!-- Contact Info & Map -->
        <section class="contact-info-map">
            <div class="contact-details">
                <h2>Visit Our <span class="highlight">Gym</span></h2>
                
                <div class="info-card">
                    <div class="info-item">
                        <span class="material-symbols-outlined">location_on</span>
                        <div>
                            <h3>Address</h3>
                            <p>123 Fitness Street<br>Health City, HC 12345</p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <span class="material-symbols-outlined">call</span>
                        <div>
                            <h3>Phone</h3>
                            <p>(555) 123-4567</p>
                            <p class="sub-text">Mon-Fri: 6AM-10PM</p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <span class="material-symbols-outlined">mail</span>
                        <div>
                            <h3>Email</h3>
                            <p>info@legendsfitness.com</p>
                            <p class="sub-text">Response within 24 hours</p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <span class="material-symbols-outlined">schedule</span>
                        <div>
                            <h3>Hours</h3>
                            <p>24/7 Member Access</p>
                            <p class="sub-text">Staffed: 6AM-10PM Daily</p>
                        </div>
                    </div>
                </div>
                
                <div class="quick-buttons">
                    <a href="tel:5551234567" class="contact-btn">
                        <span class="material-symbols-outlined">call</span>
                        Call Now
                    </a>
                    <a href="https://maps.google.com" target="_blank" class="contact-btn">
                        <span class="material-symbols-outlined">directions</span>
                        Get Directions
                    </a>
                </div>
            </div>
            
            <div class="map-container">
                <div class="map-placeholder">
                    <!-- Google Maps embed would go here -->
                    <div class="map-overlay">
                        <h3>Find Us Here</h3>
                        <p>Easy parking available • Near City Center</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Form -->
        <section class="contact-form-section">
            <h2>Send Us a <span class="highlight">Message</span></h2>
            <p class="section-subtitle">Fill out the form below and we'll get back to you as soon as possible</p>
            
            <form id="contact-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Subject *</label>
                        <select id="subject" name="subject" required>
                            <option value="">Select a topic</option>
                            <option value="membership">Membership Inquiry</option>
                            <option value="training">Personal Training</option>
                            <option value="classes">Group Classes</option>
                            <option value="tour">Schedule a Tour</option>
                            <option value="general">General Question</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group full-width">
                    <label for="message">Message *</label>
                    <textarea id="message" name="message" rows="6" required></textarea>
                </div>
                
                <div class="form-options">
                    <div class="checkbox-group">
                        <input type="checkbox" id="trial" name="trial">
                        <label for="trial">
                            <span class="material-symbols-outlined">check</span>
                            I'm interested in a free trial</label>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="tour" name="tour">
                        <label for="tour">
                            <span class="material-symbols-outlined">check
                            </span>
                            I'd like to schedule a tour</label>
                    </div>
                </div>
                
                <button type="submit" class="submit-btn">
                    Send Message
                    <span class="material-symbols-outlined">send</span>
                </button>
            </form>
        </section>

        <!-- FAQ Section -->
        <section class="contact-faq">
            <h2>Frequently Asked <span class="highlight">Questions</span></h2>
            
            <div class="faq-container">
                <div class="faq-item">
                    <input type="checkbox" id="faq1" class="faq-checkbox">
                    <label for="faq1" class="faq-question">
                        <h3>Do I need to book a tour in advance?</h3>
                        <span class="material-symbols-outlined plus-icon">add</span>
                        <span class="material-symbols-outlined minus-icon">remove</span>
                    </label>
                    <div class="faq-answer">
                        <p>Walk-ins are welcome, but booking ensures a staff member is available to give you a full tour. We recommend scheduling ahead for the best experience.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <input type="checkbox" id="faq2" class="faq-checkbox">
                    <label for="faq2" class="faq-question">
                        <h3>What should I bring for my first visit?</h3>
                        <span class="material-symbols-outlined plus-icon">add</span>
                        <span class="material-symbols-outlined minus-icon">remove</span>
                    </label>
                    <div class="faq-answer">
                        <p>Just bring yourself, workout clothes, and shoes. We provide towels, lockers, and all equipment. For tours, no special preparation is needed.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <input type="checkbox" id="faq3" class="faq-checkbox">
                    <label for="faq3" class="faq-question">
                        <h3>Is parking available?</h3>
                        <span class="material-symbols-outlined plus-icon">add</span>
                        <span class="material-symbols-outlined minus-icon">remove</span>
                    </label>
                    <div class="faq-answer">
                        <p>Yes! We have free parking for 50+ vehicles behind the building. Additional street parking is available nearby.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="contact-cta">
            <div class="cta-content">
                <h2>Ready to Visit?</h2>
                <p>Stop by anytime during staffed hours for a quick look, or schedule a comprehensive tour with one of our fitness experts.</p>
                
                <div class="cta-buttons">
                    <a href="tel:5551234567" class="cta-primary">
                        <span class="material-symbols-outlined">call</span>
                        Call to Schedule
                    </a>
                    <a href="#contact-form" class="cta-secondary">
                        <span class="material-symbols-outlined">calendar_month</span>
                        Book Online
                    </a>
                </div>
            </div>
        </section>
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