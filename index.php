<?php
session_start();
if(isset($_GET['logout'])){
    session_destroy();
    header('location:index.php');
    exit();
}
include('connection.php');
$user='member';
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
    <title>Legends Fitness Gym | Transform Your Body</title>
    <link rel="stylesheet" href="style.css">
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
                <a href="index.php" class="active">HOME</a>
                <a href="membership.php">MEMBERSHIP</a>
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
    
    <main>
        <div id="img-text">
            <div id="text">
                <b>TRANSFORM YOUR BODY</b><br>
                <strong>BECOME STRONGER</strong><br>
                <p>Break through plateaus with personalized plans, cutting-edge equipment, and real results.</p>               
                <a href="signup.php">JOIN NOW</a>
            </div>
            <picture>
                <img src="pics/WhatsApp Image 2025-12-07 at 10.20.06_6db4db08-Photoroom.png">
            </picture>
        </div>

        <div class="programs">
            <div id="programs-heading">EXPLORE OUR <b>PROGRAMS</b> 
                <a href="programs.php">VIEW ALL
                    <span class="material-symbols-outlined">keyboard_double_arrow_right</span>
                </a>
            </div>
            <div class="programs-container">
                <div class="prog-box">
                    <span class="material-symbols-outlined" id="icon">directions_run</span>
                    <h3>Weightloss</h3>
                    <p>Burn fat through HIIT and strength training. Get nutrition guidance and weekly progress tracking.</p>
                    <a href="programs.php">Learn More</a>
                </div>
                <div class="prog-box">
                    <span class="material-symbols-outlined" id="icon">fitness_center</span>
                    <h3>Muscle Building</h3>
                    <p>Gain strength and size with progressive overload. Follow structured splits and nutrition for hypertrophy.</p>
                    <a href="programs.php">Learn More</a>
                </div>
                <div class="prog-box">
                    <span class="material-symbols-outlined" id="icon">trending_up</span>
                    <h3>Strength training</h3>
                    <p>Increase raw power in squat, bench, and deadlift. Follow periodized programs for maximal strength gains.</p>
                    <a href="programs.php">Learn More</a>
                </div>
                <div class="prog-box">
                    <span class="material-symbols-outlined" id="icon">electric_bolt</span>
                    <h3>Athletic performance</h3>
                    <p>Enhance speed, agility, and sport-specific power. Improve athleticism with functional movement training.</p>
                    <a href="programs.php">Learn More</a>
                </div>
            </div>
        </div>

        <div class="choose-us-sec">
            <div class="imgs">
                <img src="pics/70f857a2d30ff3f3722cd2b457ca313a.jpg" alt="">
                <div class="img-box">
                    <img src="pics/WhatsApp Image 2025-12-07 at 15.54.01_6fe7039a.jpg" alt="">
                    <img src="pics/pexels-elkady-9171164.jpg" alt="">
                </div>
            </div>
            <div class="desc">
                <h2>Why choose us?</h2>
                <p><span class="material-symbols-outlined">workspace_premium</span>World-class equipment in a clean, crowd-free space.</p>
                <p><span class="material-symbols-outlined">moving</span>92% of members reach their goals with science-backed programs.</p>
                <p><span class="material-symbols-outlined">groups</span>A welcoming, judgment-free space that celebrates progress.</p>
                <p><span class="material-symbols-outlined">school</span>1-on-1 coaching for correct form and safe results.</p>
                <h3>Trusted & Recognized</h3>
                <div>4.9/5 from 800+ reviews. Serving our community since 2015 with 24/7 access, 50+ weekly classes, and zero hidden fees. Voted "Best Local Gym" three years running.</div>
            </div>
        </div>

        <section class="success-stories">
            <h2>Real <span class="highlight">Results</span>, Real Members</h2>
            <div class="stories-grid">
                <div class="story-card">
                    <div class="achievement-icon">
                        <span class="material-symbols-outlined">weight</span>
                    </div>
                    <h3>John Lost 40 lbs</h3>
                    <p>"The nutrition coaching and HIIT classes completely changed my lifestyle. Lost 40 pounds in 6 months!"</p>
                    <div class="member-info">
                        <span class="duration">6 Months</span>
                        <span class="program">Weight Loss Program</span>
                    </div>
                </div>
                
                <div class="story-card">
                    <div class="achievement-icon">
                        <span class="material-symbols-outlined">fitness_center</span>
                    </div>
                    <h3>Sarah Gained 15lbs Muscle</h3>
                    <p>"Strength training transformed my physique. Gained 15 pounds of lean muscle in just 8 months!"</p>
                    <div class="member-info">
                        <span class="duration">8 Months</span>
                        <span class="program">Muscle Building</span>
                    </div>
                </div>
                
                <div class="story-card">
                    <div class="achievement-icon">
                        <span class="material-symbols-outlined">trending_up</span>
                    </div>
                    <h3>Mike: Deadlift 185 to 405 lbs</h3>
                    <p>"The powerlifting program boosted my strength dramatically. Now I deadlift over 400 pounds!"</p>
                    <div class="member-info">
                        <span class="duration">10 Months</span>
                        <span class="program">Strength Training</span>
                    </div>
                </div>
                
                <div class="story-card">
                    <div class="achievement-icon">
                        <span class="material-symbols-outlined">directions_run</span>
                    </div>
                    <h3>Maria's Marathon Success</h3>
                    <p>"Went from couch to marathon finisher! The endurance training program made it possible."</p>
                    <div class="member-info">
                        <span class="duration">6 Months</span>
                        <span class="program">Endurance Program</span>
                    </div>
                </div>
                
                <div class="story-card">
                    <div class="achievement-icon">
                        <span class="material-symbols-outlined">monitor_heart</span>
                    </div>
                    <h3>David: 52lbs Weight Loss</h3>
                    <p>"Lost 52 pounds through consistent workouts and proper nutrition guidance. Life changing!"</p>
                    <div class="member-info">
                        <span class="duration">9 Months</span>
                        <span class="program">Transformation Program</span>
                    </div>
                </div>
                
                <div class="story-card">
                    <div class="achievement-icon">
                        <span class="material-symbols-outlined">elderly</span>
                    </div>
                    <h3>Robert: Senior Fitness at 65</h3>
                    <p>"At 65, I regained mobility and strength I thought I'd lost forever. Now I can play with my grandkids again!"</p>
                    <div class="member-info">
                        <span class="duration">5 Months</span>
                        <span class="program">Senior Fitness</span>
                    </div>
                </div>
            </div>
        </section>

        <div id="membership">
            <div class="mem-heading">Membership <b>Plans</b></div>
            <div class="plans">
                <h3>Starter Plan</h3>
                <h2>$25<p>/month</p></h2>
                <hr>
                <div class="points">
                    <p><span class="material-symbols-outlined">done_all</span>Standard Gym Access</p>
                    <p><span class="material-symbols-outlined">done_all</span>Fixed Hours</p>
                    <p><span class="material-symbols-outlined">done_all</span>Basic Locker Facipties</p>
                    <p><span class="material-symbols-outlined">done_all</span>Memeber App Access</p>
                </div>
                <a href="signup.php">Join Now</a>
            </div>
            <div class="plans">
                <p id="Popular">Most Popular</p>
                <h3>Pro Plan</h3>
                <h2>$40<p>/month</p></h2>
                <hr>
                <div class="points">
                    <p><span class="material-symbols-outlined">done_all</span>Full gym access</p>
                    <p><span class="material-symbols-outlined">done_all</span>Premium equipment zones</p>
                    <p><span class="material-symbols-outlined">done_all</span>Guest passes</p>
                    <p><span class="material-symbols-outlined">done_all</span>Towel service + Recovery area</p>
                    <p><span class="material-symbols-outlined">done_all</span>Nutrition workshops</p>
                </div>
                <a href="signup.php">Join Now</a>
            </div>
            <div class="plans">
                <h3>Elite Plan</h3>
                <h2>$50<p>/month</p></h2>
                <hr>
                <div class="points">
                    <p><span class="material-symbols-outlined">done_all</span>24/7 priority access</p>
                    <p><span class="material-symbols-outlined">done_all</span>Personal training sessions</p>
                    <p><span class="material-symbols-outlined">done_all</span>Cryotherapy/sauna access</p>
                    <p><span class="material-symbols-outlined">done_all</span>Private locker + premium recovery</p>
                    <p><span class="material-symbols-outlined">done_all</span>Body composition scans</p>
                </div>
                <a href="signup.php">Join Now</a>
            </div>
        </div>

        <section class="cta-banner">
            <div class="container cta-content">
                <h2>Start Your Fitness Journey Today</h2>
                <p>Get 7 days of free access to all our facilities and classes. No commitment, no credit card required.</p>
                <a href="#" class="btn">Claim Your Free Trial</a>
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
                        <li><a href="#img-text">Home</a></li>
                        <li><a href="#programs-heading">Programs</a></li>
                        <li><a href="#membership">Membership</a></li>
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
                            <div>info@elitefitness.com</div>
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