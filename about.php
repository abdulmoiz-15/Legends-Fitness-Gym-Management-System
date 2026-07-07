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
    <title>About Us | Legends Fitness</title>
    <link rel="stylesheet" href="about.css">
    <link rel="stylesheet" href="header-footer.css">
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
                <a href="about.php" class="active">ABOUT US</a>
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
    
    <main class="about-page">
        <!-- Hero Section -->
        <section class="about-hero">
            <div class="hero-content">
                <h1>More Than a Gym <span class="highlight">A Fitness Community</span></h1>
                <p>Since 2015, we've been transforming lives through fitness, community, and personalized support.</p>
                <a href="signup.php" class="cta-button">Join Us</a>
            </div>
        </section>

        <!-- Our Story -->
        <section class="our-story">
            <div class="story-content">
                <h2>Our <span class="highlight">Story</span></h2>
                <p>Legends Fitness began with a simple vision: create a gym where everyone feels welcome, supported, and motivated to reach their goals. What started as a small 2,000 sq ft space has grown into a premier fitness destination serving over 2,500 members.</p>
                <p>Founder Alex Morgan's own fitness journey inspired him to build a community-focused gym that prioritizes results, safety, and genuine connection over just equipment and space.</p>
            </div>
            <div class="story-stats">
                <div class="stat">
                    <h3>2015</h3>
                    <p>Year Founded</p>
                </div>
                <div class="stat">
                    <h3>2,500+</h3>
                    <p>Members Transformed</p>
                </div>
                <div class="stat">
                    <h3>15</h3>
                    <p>Certified Trainers</p>
                </div>
                <div class="stat">
                    <h3>24/7</h3>
                    <p>Access</p>
                </div>
            </div>
        </section>

        <!-- Mission & Values -->
        <section class="mission-values">
            <h2>Our Mission & <span class="highlight">Values</span></h2>
            <div class="values-grid">
                <div class="value-card">
                    <span class="material-symbols-outlined">diversity_3</span>
                    <h3>Community First</h3>
                    <p>We believe fitness is better together. Our supportive environment fosters connections and accountability.</p>
                </div>
                <div class="value-card">
                    <span class="material-symbols-outlined">trending_up</span>
                    <h3>Results Driven</h3>
                    <p>Every program is designed with measurable outcomes. We celebrate every milestone, big or small.</p>
                </div>
                <div class="value-card">
                    <span class="material-symbols-outlined">check</span>
                    <h3>Excellence</h3>
                    <p>From equipment to coaching, we maintain the highest standards to ensure your success and safety.</p>
                </div>
                <div class="value-card">
                    <span class="material-symbols-outlined">accessibility</span>
                    <h3>Inclusivity</h3>
                    <p>All fitness levels, ages, and backgrounds are welcome. Our space is judgment-free and supportive.</p>
                </div>
            </div>
        </section>

        <!-- Trainers Section -->
        <section class="trainers-section">
            <h2>Meet Our <span class="highlight">Expert Trainers</span></h2>
            <p class="section-subtitle">Our certified professionals are here to guide you on your fitness journey</p>
            
            <div class="trainers-grid">
                <div class="trainer-card">
                    <div class="trainer-icon">
                        <span class="material-symbols-outlined">fitness_center</span>
                    </div>
                    <div class="trainer-info">
                        <h3>Alex Morgan</h3>
                        <p class="trainer-title">Head Coach & Founder</p>
                        <div class="trainer-specialties">
                            <span>Strength Training</span>
                            <span>Nutrition</span>
                            <span>Bodybuilding</span>
                        </div>
                        <p class="trainer-quote">"Fitness is a journey, not a destination. Let's build your legacy together."</p>
                        <div class="trainer-cert">
                            <span class="material-symbols-outlined">verified_user</span>
                            <div>NASM, ISSA Certified</div>
                        </div>
                    </div>
                </div>
                
                <div class="trainer-card">
                    <div class="trainer-icon">
                        <span class="material-symbols-outlined">self_improvement</span>
                    </div>
                    <div class="trainer-info">
                        <h3>Sarah Chen</h3>
                        <p class="trainer-title">Yoga & Mobility Specialist</p>
                        <div class="trainer-specialties">
                            <span>Yoga</span>
                            <span>Mobility</span>
                            <span>Recovery</span>
                        </div>
                        <p class="trainer-quote">"Balance your body and mind for sustainable fitness success."</p>
                        <div class="trainer-cert">
                            <span class="material-symbols-outlined">verified_user</span>
                            <div>RYT-500, ACE Certified</div>
                        </div>
                    </div>
                </div>
                
                <div class="trainer-card">
                    <div class="trainer-icon">
                        <span class="material-symbols-outlined">sprint</span>
                    </div>
                    <div class="trainer-info">
                        <h3>Marcus Johnson</h3>
                        <p class="trainer-title">Cardio & Conditioning Coach</p>
                        <div class="trainer-specialties">
                            <span>HIIT</span>
                            <span>Endurance</span>
                            <span>Fat Loss</span>
                        </div>
                        <p class="trainer-quote">"Push your limits safely and effectively with science-backed methods."</p>
                        <div class="trainer-cert">
                            <span class="material-symbols-outlined">verified_user</span>
                            <div>NASM, CPR Certified</div>
                        </div>
                    </div>
                </div>
                
                <div class="trainer-card">
                    <div class="trainer-icon">
                        <span class="material-symbols-outlined">weight</span>
                    </div>
                    <div class="trainer-info">
                        <h3>David Rodriguez</h3>
                        <p class="trainer-title">Powerlifting Coach</p>
                        <div class="trainer-specialties">
                            <span>Powerlifting</span>
                            <span>Strength</span>
                            <span>Technique</span>
                        </div>
                        <p class="trainer-quote">"Proper form and progressive overload are keys to strength gains."</p>
                        <div class="trainer-cert">
                            <span class="material-symbols-outlined">verified_user</span>
                            <div>USAPL, CSCS Certified</div>
                        </div>
                    </div>
                </div>
                
                <div class="trainer-card">
                    <div class="trainer-icon">
                        <span class="material-symbols-outlined">elderly</span>
                    </div>
                    <div class="trainer-info">
                        <h3>Jennifer Lee</h3>
                        <p class="trainer-title">Senior Fitness Specialist</p>
                        <div class="trainer-specialties">
                            <span>Senior Health</span>
                            <span>Rehabilitation</span>
                            <span>Low-Impact</span>
                        </div>
                        <p class="trainer-quote">"Age is just a number. It's never too late to improve your health."</p>
                        <div class="trainer-cert">
                            <span class="material-symbols-outlined">verified_user</span>
                            <div>ACE, Geriatrics Certified</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Facilities -->
        <section class="facilities">
            <div class="facilities-content">
                <h2>World-Class <span class="highlight">Facilities</span></h2>
                <p>Our 15,000 sq ft facility is equipped with the latest fitness technology and designed for optimal performance and recovery.</p>
                <div class="facility-list">
                    <p><span class="material-symbols-outlined">check_circle</span>Premium Life Fitness Equipment</p>
                    <p><span class="material-symbols-outlined">check_circle</span>Dedicated Functional Training Zone</p>
                    <p><span class="material-symbols-outlined">check_circle</span>Olympic Lifting Platforms</p>
                    <p><span class="material-symbols-outlined">check_circle</span>Recovery Center with Sauna</p>
                    <p><span class="material-symbols-outlined">check_circle</span>Group Class Studios</p>
                    <p><span class="material-symbols-outlined">check_circle</span>24/7 Security & Access</p>
                </div>
            </div>
            <div class="facilities-gallery">
                <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=600&h=400&fit=crop" alt="Gym Interior">
                <img src="https://images.unsplash.com/photo-1571902943202-507ec2618e8f?w=600&h=400&fit=crop" alt="Weight Area">
            </div>
        </section>

        <!-- Community Impact -->
        <section class="community-impact">
            <div class="impact-content">
                <h2>Our <span class="highlight">Community</span> Impact</h2>
                <p>We're proud to be more than just a gym. Through partnerships and initiatives, we support our local community.</p>
                <div class="impact-highlights">
                    <div class="highlight-item">
                        <h3>500+</h3>
                        <p>Free community workout sessions annually</p>
                    </div>
                    <div class="highlight-item">
                        <h3>$25K</h3>
                        <p>Raised for local health charities</p>
                    </div>
                    <div class="highlight-item">
                        <h3>3 Years</h3>
                        <p>Voted "Best Local Gym" by City Magazine</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-quote">
                <p>"Legends isn't just where I work out—it's where I found my confidence and made lifelong friends."</p>
                <div class="quote-author">
                    <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=100&h=100&fit=crop&crop=face" alt="Maria Gonzalez">
                    <div>
                        <h4>Maria Gonzalez</h4>
                        <p>Member since 2018</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Final CTA -->
        <section class="about-cta">
            <div class="cta-content">
                <h2>Ready to Join Our Family?</h2>
                <p>Experience the Legends difference with a free 7-day trial. No commitment, just results.</p>
                <div class="cta-buttons">
                    <a href="signup.php" class="cta-primary">Start Free Trial</a>
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