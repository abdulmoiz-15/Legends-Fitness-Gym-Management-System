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
    <title>Membership Plans | Legends Fitness</title>
    <link rel="stylesheet" href="mem.css">
    <link rel="stylesheet" href="header-footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton+SC&family=Bowlby+One+SC&family=Contrail+One&family=Fugaz+One&family=New+Amsterdam&family=Outfit:wght@100..900&family=Racing+Sans+One&family=Science+Gothic:wght@100..900&family=Zen+Dots&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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
                <a href="membership.php" class="active">MEMBERSHIP</a>
                <a href="programs.php">PROGRAMS</a>
                <a href="about.php">ABOUT US</a>
                <a href="contact.php">CONTACT</a>
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
    
    <main class="membership-page">
        <!-- Hero Section -->
        <section class="membership-hero">
            <div class="hero-content">
                <h1>Find Your Perfect <span class="highlight">Membership</span></h1>
                <p>Choose the plan that matches your fitness goals, lifestyle, and budget. No hidden fees, no long-term contracts.</p>
                <a href="#plans" class="cta-button">View All Plans</a>
            </div>
        </section>

        <!-- Membership Comparison -->
        <section class="membership-comparison" id="plans">
            <h2>Choose Your <span class="highlight">Plan</span></h2>
            <p class="section-subtitle">Compare features and find the perfect fit for your fitness journey</p>
            
            <div class="comparison-table">
                <div class="table-header">
                    <div class="feature-col header-title">Membership Features</div>
                    <div class="plan-col">
                        <h3>Starter</h3>
                        <div class="price">$25<span>/month</span></div>
                        <a href="signup.php" class="select-plan">Select Plan</a>
                        <div class="features">
                            <div class="feats">Gym Access Hours:
                                Equipment Zones:
                                Group Classes:
                                Recovery Amenities:
                                Nutrition Support:
                                Member App:
                            </div>
                            <div class="desc">Standard Hours (6AM-10PM)
                                Basic Equipment Only
                                2 Classes/Week
                                Basic Locker
                                Basic Guide
                                Basic Access
                            </div>
                        </div>
                    </div>
                    <div class="plan-col popular">
                        <div class="popular-badge">MOST POPULAR</div>
                        <h3>Pro</h3>
                        <div class="price">$40<span>/month</span></div>
                        <a href="signup.php" class="select-plan">Select Plan</a>
                        <div class="features">
                            <div class="feats">Gym Access Hours:
                                Equipment Zones:
                                Group Classes:
                                Personal Training:
                                Guest Passes:
                                Recovery Amenities:
                                Nutrition Support:
                                Member App:
                            </div>
                            <div class="desc">24/7 Access
                                All Premium Equipment
                                Unlimited Classes
                                1 Session/Month
                                2 Passes/Month
                                Towel Service + Sauna
                                Monthly Workshop
                                Premium Features
                            </div>
                        </div>
                    </div>
                    <div class="plan-col">
                        <h3>Elite</h3>
                        <div class="price">$50<span>/month</span></div>
                        <a href="signup.php" class="select-plan">Select Plan</a>
                        <div class="features">
                            <div class="feats">Gym Access Hours:
                                Equipment Zones:
                                Group Classes:
                                Personal Training:
                                Guest Passes:
                                Recovery Amenities:
                                Nutrition Support:
                                Member App:
                            </div>
                            <div class="desc">24/7 Priority Access
                                VIP Equipment + Recovery Zone
                                Unlimited + Priority Booking
                                4 Sessions/Month
                                4 Passes/Month
                                Private Locker + Cryotherapy
                                Personalized Plan + Scans
                                VIP Features + Coach Chat
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="table-body">
                    <div class="table-row">
                        <div class="feature-col">Gym Access Hours</div>
                        <div class="plan-col">Standard Hours (6AM-10PM)</div>
                        <div class="plan-col">24/7 Access</div>
                        <div class="plan-col">24/7 Priority Access</div>
                    </div>
                    <div class="table-row">
                        <div class="feature-col">Equipment Zones</div>
                        <div class="plan-col">Basic Equipment Only</div>
                        <div class="plan-col">All Premium Equipment</div>
                        <div class="plan-col">VIP Equipment + Recovery Zone</div>
                    </div>
                    <div class="table-row">
                        <div class="feature-col">Group Classes</div>
                        <div class="plan-col">2 Classes/Week</div>
                        <div class="plan-col">Unlimited Classes</div>
                        <div class="plan-col">Unlimited + Priority Booking</div>
                    </div>
                    <div class="table-row">
                        <div class="feature-col">Personal Training</div>
                        <div class="plan-col">-</div>
                        <div class="plan-col">1 Session/Month</div>
                        <div class="plan-col">4 Sessions/Month</div>
                    </div>
                    <div class="table-row">
                        <div class="feature-col">Guest Passes</div>
                        <div class="plan-col">-</div>
                        <div class="plan-col">2 Passes/Month</div>
                        <div class="plan-col">4 Passes/Month</div>
                    </div>
                    <div class="table-row">
                        <div class="feature-col">Recovery Amenities</div>
                        <div class="plan-col">Basic Locker</div>
                        <div class="plan-col">Towel Service + Sauna</div>
                        <div class="plan-col">Private Locker + Cryotherapy</div>
                    </div>
                    <div class="table-row">
                        <div class="feature-col">Nutrition Support</div>
                        <div class="plan-col">Basic Guide</div>
                        <div class="plan-col">Monthly Workshop</div>
                        <div class="plan-col">Personalized Plan + Scans</div>
                    </div>
                    <div class="table-row">
                        <div class="feature-col">Member App</div>
                        <div class="plan-col">Basic Access</div>
                        <div class="plan-col">Premium Features</div>
                        <div class="plan-col">VIP Features + Coach Chat</div>
                    </div>
                </div>
            </div>
        </section>
        <!-- How to Join -->
        <section class="join-process">
            <h2>How to <span class="highlight">Join</span></h2>
            <div class="process-steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Choose Your Plan</h3>
                    <p>Select the membership that fits your goals and budget. Try our 7-day free trial first.</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Sign Up Online or In-Person</h3>
                    <p>Complete your registration digitally or visit our gym for a personal tour and sign-up.</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Complete Onboarding</h3>
                    <p>Get your membership card, app access, and introductory session with a coach.</p>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <h3>Start Your Journey</h3>
                    <p>Access all facilities, join classes, and begin working toward your fitness goals.</p>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
       <section class="faq-section">
            <h2>Frequently Asked <span class="highlight">Questions</span></h2>
            <div class="faq-container">
                <div class="faq-item">
                    <input type="checkbox" id="faq1" class="faq-checkbox">
                    <label for="faq1" class="faq-question">
                        <h3>Can I freeze my membership?</h3>
                        <span class="material-symbols-outlined plus-icon">add</span>
                        <span class="material-symbols-outlined minus-icon">remove</span>
                    </label>
                    <div class="faq-answer">
                        <p>Yes! You can freeze your membership for up to 3 months per year for medical reasons, travel, or personal circumstances. A small monthly freeze fee applies.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <input type="checkbox" id="faq2" class="faq-checkbox">
                    <label for="faq2" class="faq-question">
                        <h3>What's your cancellation policy?</h3>
                        <span class="material-symbols-outlined plus-icon">add</span>
                        <span class="material-symbols-outlined minus-icon">remove</span>
                    </label>
                    <div class="faq-answer">
                        <p>We require 30 days' notice for cancellation. No long-term contracts on monthly plans. Annual memberships can be canceled with a prorated refund.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <input type="checkbox" id="faq3" class="faq-checkbox">
                    <label for="faq3" class="faq-question">
                        <h3>Do you offer day passes?</h3>
                        <span class="material-symbols-outlined plus-icon">add</span>
                        <span class="material-symbols-outlined minus-icon">remove</span>
                    </label>
                    <div class="faq-answer">
                        <p>Yes! Day passes are $15 for guests. Members can bring guests with their guest pass privileges. Weekly trial passes are also available for $30.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <input type="checkbox" id="faq4" class="faq-checkbox">
                    <label for="faq4" class="faq-question">
                        <h3>What payment methods do you accept?</h3>
                        <span class="material-symbols-outlined plus-icon">add</span>
                        <span class="material-symbols-outlined minus-icon">remove</span>
                    </label>
                    <div class="faq-answer">
                        <p>We accept all major credit cards, debit cards, bank transfers, and cash payments. Recurring payments are automatically processed on your billing date.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <input type="checkbox" id="faq5" class="faq-checkbox">
                    <label for="faq5" class="faq-question">
                        <h3>Is there an initiation fee?</h3>
                        <span class="material-symbols-outlined plus-icon">add</span>
                        <span class="material-symbols-outlined minus-icon">remove</span>
                    </label>
                    <div class="faq-answer">
                        <p>We waive the $49 initiation fee when you sign up for an annual plan or commit to 6+ months. Monthly plans have a one-time $29 setup fee.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Trial Section -->
        <section class="trial-section">
            <div class="trial-content">
                <h2>Not Ready to Commit?</h2>
                <h2>Try Our <span class="highlight">7-Day Free Trial</span></h2>
                <p>Experience all our facilities, equipment, and 3 group classes absolutely free for 7 days. No credit card required.</p>
                <div class="trial-features">
                    <p><span class="material-symbols-outlined">done</span>Full gym access</p>
                    <p><span class="material-symbols-outlined">done</span>3 group classes</p>
                    <p><span class="material-symbols-outlined">done</span>Equipment orientation</p>
                    <p><span class="material-symbols-outlined">done</span>No obligation to join</p>
                </div>
                <a href="signup.php" class="trial-button">Claim Your Free Trial</a>
            </div>
        </section>
        <!-- Testimonials -->
        <section class="member-testimonials">
            <h2>What Our <span class="highlight">Members</span> Say</h2>
            <div class="testimonials-container">
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div>
                            <h4>Sarah Johnson</h4>
                            <p>Pro Member • 2 years</p>
                        </div>
                    </div>
                    <p class="testimonial-text">"The Pro plan gave me everything I needed to lose 30 pounds. The 24/7 access fits my nurse schedule perfectly!"</p>
                    <div class="rating">★★★★★</div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div>
                            <h4>Mike Chen</h4>
                            <p>Elite Member • 1 year</p>
                        </div>
                    </div>
                    <p class="testimonial-text">"As a competitive athlete, the Elite plan's recovery facilities and personal training have taken my performance to the next level."</p>
                    <div class="rating">★★★★★</div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div>
                            <h4>Jessica Williams</h4>
                            <p>Starter → Pro Member • 6 months</p>
                        </div>
                    </div>
                    <p class="testimonial-text">"Started with the basic plan and upgraded as I got more serious. The flexibility to change plans is fantastic!"</p>
                    <div class="rating">★★★★★</div>
                </div>
            </div>
        </section>

        <!-- Final CTA -->
        <section class="final-cta">
            <div class="cta-container">
                <h2>Ready to Transform?</h2>
                <p>Join 2,500+ members who've transformed their lives at Legends Fitness.</p>
                <div class="cta-stats">
                    <div class="stat">
                        <h3>4.9/5</h3>
                        <p>Member Rating</p>
                    </div>
                    <div class="stat">
                        <h3>24/7</h3>
                        <p>Access</p>
                    </div>
                    <div class="stat">
                        <h3>50+</h3>
                        <p>Weekly Classes</p>
                    </div>
                    <div class="stat">
                        <h3>0</h3>
                        <p>Hidden Fees</p>
                    </div>
                </div>
                <a href="signup.php" class="join-now-button">Join Now • Free Trial Available</a>
                <p class="cta-note">Questions? Call us at (555) 123-4567 or visit the gym for a personal tour.</p>
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
                        <li><a href="#plans">Membership</a></li>
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