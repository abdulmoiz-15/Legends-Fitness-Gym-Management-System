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
    <title>Programs | Legends Fitness</title>
    <link rel="stylesheet" href="header-footer.css">
    <link rel="stylesheet" href="programs.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton+SC&family=Bowlby+One+SC&family=Contrail+One&family=Fugaz+One&family=New+Amsterdam&family=Outfit:wght@100..900&family=Science+Gothic:wght@100..900&family=Zen+Dots&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<style>
    .profile-box{display: <?php echo $loggedin ? 'flex' : 'none'; ?>}
    .join{display: <?php echo $loggedin ? 'none' : 'flex'; ?>}
</style>
<body>
    <input type="checkbox" id="menu">
    <input type="radio" id="all" name="category" class="category-radio" checked>
    <input type="radio" id="strength" name="category" class="category-radio">
    <input type="radio" id="cardio" name="category" class="category-radio">
    <input type="radio" id="specialty" name="category" class="category-radio">
    <input type="radio" id="wellness" name="category" class="category-radio">
    <input type="radio" id="group" name="category" class="category-radio">

    <header>
        <div class="left">
            <label for="menu">
                <div id="menu-icon" class="material-symbols-outlined">menu</div>
            </label>
            <div class="logo">
                <a href="index.php">
                    <img src="pics/LEGEDS_FITNESS2-removebg-preview.png" alt="Legends Fitness Logo" id="logo">
                </a>
            </div>
        </div>
        <div class="right">
            <div class="labels">
                <a href="index.php">HOME</a>
                <a href="membership.php">MEMBERSHIP</a>
                <a href="programs.php" class="active">PROGRAMS</a>
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
        <!-- Hero Banner -->
        <section class="programs-hero">
            <div class="hero-content">
                <h1>OUR <span class="highlight">TRAINING</span> PROGRAMS</h1>
                <p>Discover 13 specialized fitness programs designed by certified trainers. Whether you're starting your journey or pushing your limits, we have the perfect program for every goal and fitness level.</p>
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="material-symbols-outlined">verified</span>
                        <div>Certified Trainers</div>
                    </div>
                    <div class="stat-item">
                        <span class="material-symbols-outlined">schedule</span>
                        <div>50+ Weekly Classes</div>
                    </div>
                    <div class="stat-item">
                        <span class="material-symbols-outlined">trending_up</span>
                        <div>92% Success Rate</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Program Categories -->
        <section class="categories-section">
            <h2>PROGRAM <span class="highlight">CATEGORIES</span></h2>
            <p class="section-subtitle">Filter programs by your training preference</p>
            
            <div class="category-filters">
                <label for="all" class="category-label">All Programs</label>
                <label for="strength" class="category-label">Strength & Power</label>
                <label for="cardio" class="category-label">Cardio & Conditioning</label>
                <label for="specialty" class="category-label">Specialty Training</label>
                <label for="wellness" class="category-label">Wellness & Recovery</label>
                <label for="group" class="category-label">Group Training</label>
            </div>
        </section>

        <!-- All Programs Grid -->
        <section class="programs">
            <h2>OUR <span class="highlight">PROGRAMS</span></h2>
            
            <div class="programs-container">
                <!-- BEGINNER FOUNDATION - Available in all memberships -->
                <div class="program-box specialty">
                    <span class="material-symbols-outlined icon">school</span>
                    <h3>BEGINNER FOUNDATION</h3>
                    <p class="level">Level: Beginner</p>
                    <p class="description">Build confidence with proper form and basic exercises. Learn gym fundamentals safely with personalized guidance.</p>
                    <div class="program-info">
                        <p><span class="material-symbols-outlined">schedule</span> Duration: 8 Weeks</p>
                        <p><span class="material-symbols-outlined">group</span> 1-on-1 & Small Groups</p>
                        <p><span class="material-symbols-outlined">fitness_center</span> Equipment Orientation</p>
                    </div>
                    <div class="features">
                        <h4>What You'll Learn:</h4>
                        <ul>
                            <li>Proper exercise form & technique</li>
                            <li>Basic gym equipment usage</li>
                            <li>Fundamental movement patterns</li>
                            <li>Safety protocols</li>
                            <li>Creating a workout routine</li>
                        </ul>
                    </div>
                    <p class="price">Available in all memberships</p>
                </div>

                <!-- WEIGHT LOSS - Available in Pro & Elite memberships -->
                <div class="program-box cardio">
                    <span class="material-symbols-outlined icon">monitor_weight</span>
                    <h3>WEIGHT LOSS</h3>
                    <p class="level">Level: All Levels</p>
                    <p class="description">Burn fat through HIIT and strength training. Get nutrition guidance and weekly progress tracking.</p>
                    <div class="program-info">
                        <p><span class="material-symbols-outlined">schedule</span> Duration: 12 Weeks</p>
                        <p><span class="material-symbols-outlined">restaurant</span> Nutrition Plans Included</p>
                        <p><span class="material-symbols-outlined">track_changes</span> Weekly Progress Tracking</p>
                    </div>
                    <div class="features">
                        <h4>Program Includes:</h4>
                        <ul>
                            <li>Customized HIIT workouts</li>
                            <li>Strength training circuits</li>
                            <li>Personalized nutrition plan</li>
                            <li>Weekly weigh-ins & measurements</li>
                            <li>Accountability coaching</li>
                        </ul>
                    </div>
                    <p class="price">Available in Pro & Elite memberships</p>
                </div>

                <!-- MUSCLE BUILDING - Available in all memberships -->
                <div class="program-box strength">
                    <span class="material-symbols-outlined icon">fitness_center</span>
                    <h3>MUSCLE BUILDING</h3>
                    <p class="level">Level: Intermediate-Advanced</p>
                    <p class="description">Gain strength and size with progressive overload. Follow structured splits and nutrition for hypertrophy.</p>
                    <div class="program-info">
                        <p><span class="material-symbols-outlined">schedule</span> Duration: 8-16 Weeks</p>
                        <p><span class="material-symbols-outlined">trending_up</span> Progressive Overload</p>
                        <p><span class="material-symbols-outlined">nutrition</span> Hypertrophy Nutrition</p>
                    </div>
                    <div class="features">
                        <h4>Training Focus:</h4>
                        <ul>
                            <li>Structured workout splits</li>
                            <li>Progressive overload techniques</li>
                            <li>Muscle group specialization</li>
                            <li>Recovery optimization</li>
                            <li>Supplement guidance</li>
                        </ul>
                    </div>
                    <p class="price">Available in all memberships</p>
                </div>

                <!-- STRENGTH TRAINING - Available in all memberships -->
                <div class="program-box strength">
                    <span class="material-symbols-outlined icon">trending_up</span>
                    <h3>STRENGTH TRAINING</h3>
                    <p class="level">Level: Intermediate-Advanced</p>
                    <p class="description">Increase raw power in squat, bench, and deadlift. Follow periodized programs for maximal strength gains.</p>
                    <div class="program-info">
                        <p><span class="material-symbols-outlined">schedule</span> Periodized Programming</p>
                        <p><span class="material-symbols-outlined">show_chart</span> Strength Benchmarking</p>
                        <p><span class="material-symbols-outlined">weight</span> Powerlifting Focus</p>
                    </div>
                    <div class="features">
                        <h4>Key Components:</h4>
                        <ul>
                            <li>Squat, Bench, Deadlift programming</li>
                            <li>Accessory work optimization</li>
                            <li>Technique refinement</li>
                            <li>Peaking protocols</li>
                            <li>Meet preparation</li>
                        </ul>
                    </div>
                    <p class="price">Available in all memberships</p>
                </div>

                <!-- ATHLETIC PERFORMANCE - Available in Pro & Elite memberships -->
                <div class="program-box specialty">
                    <span class="material-symbols-outlined icon">sprint</span>
                    <h3>ATHLETIC PERFORMANCE</h3>
                    <p class="level">Level: Intermediate-Advanced</p>
                    <p class="description">Enhance speed, agility, and sport-specific power. Improve athleticism with functional movement training.</p>
                    <div class="program-info">
                        <p><span class="material-symbols-outlined">schedule</span> Sport-Specific Cycles</p>
                        <p><span class="material-symbols-outlined">bolt</span> Power & Plyometrics</p>
                        <p><span class="material-symbols-outlined">sports</span> Individual & Team</p>
                    </div>
                    <div class="features">
                        <h4>Performance Training:</h4>
                        <ul>
                            <li>Speed & agility drills</li>
                            <li>Plyometric training</li>
                            <li>Sport-specific conditioning</li>
                            <li>Injury prevention</li>
                            <li>Recovery strategies</li>
                        </ul>
                    </div>
                    <p class="price">Available in Pro & Elite memberships</p>
                </div>

                <!-- FUNCTIONAL FITNESS - Available in all memberships -->
                <div class="program-box group">
                    <span class="material-symbols-outlined icon">diversity_3</span>
                    <h3>FUNCTIONAL FITNESS</h3>
                    <p class="level">Level: All Levels</p>
                    <p class="description">Varied, high-intensity workouts combining weightlifting, gymnastics, and cardio. Community-driven classes.</p>
                    <div class="program-info">
                        <p><span class="material-symbols-outlined">schedule</span> Daily WOD Classes</p>
                        <p><span class="material-symbols-outlined">groups</span> Community Focus</p>
                        <p><span class="material-symbols-outlined">exercise</span> Scaled Options</p>
                    </div>
                    <div class="features">
                        <h4>Class Elements:</h4>
                        <ul>
                            <li>Constantly varied workouts</li>
                            <li>Olympic weightlifting</li>
                            <li>Gymnastics skills</li>
                            <li>High-intensity conditioning</li>
                            <li>Community competitions</li>
                        </ul>
                    </div>
                    <p class="price">Available in all memberships</p>
                </div>

                <!-- HIIT & CIRCUIT - Available in all memberships -->
                <div class="program-box cardio">
                    <span class="material-symbols-outlined icon">electric_bolt</span>
                    <h3>HIIT & CIRCUIT</h3>
                    <p class="level">Level: All Levels</p>
                    <p class="description">Time-efficient calorie burn through interval training. Short, intense workouts with minimal rest periods.</p>
                    <div class="program-info">
                        <p><span class="material-symbols-outlined">schedule</span> 30-45 Minute Sessions</p>
                        <p><span class="material-symbols-outlined">timer</span> High Intensity Intervals</p>
                        <p><span class="material-symbols-outlined">whatshot</span> Max Calorie Burn</p>
                    </div>
                    <div class="features">
                        <h4>Workout Structure:</h4>
                        <ul>
                            <li>Tabata intervals</li>
                            <li>AMRAP circuits</li>
                            <li>EMOM challenges</li>
                            <li>Partner workouts</li>
                            <li>Equipment-free options</li>
                        </ul>
                    </div>
                    <p class="price">Available in all memberships</p>
                </div>

                <!-- YOGA & MOBILITY - Available in all memberships -->
                <div class="program-box wellness">
                    <span class="material-symbols-outlined icon">self_improvement</span>
                    <h3>YOGA & MOBILITY</h3>
                    <p class="level">Level: All Levels</p>
                    <p class="description">Improve flexibility, balance, and mind-body connection. Reduce stress while increasing range of motion.</p>
                    <div class="program-info">
                        <p><span class="material-symbols-outlined">schedule</span> Weekly Classes</p>
                        <p><span class="material-symbols-outlined">accessibility</span> Flexibility & Recovery</p>
                        <p><span class="material-symbols-outlined">psychiatry</span> Mind-Body Connection</p>
                    </div>
                    <div class="features">
                        <h4>Class Types:</h4>
                        <ul>
                            <li>Vinyasa flow</li>
                            <li>Yin & restorative yoga</li>
                            <li>Mobility workshops</li>
                            <li>Breathwork sessions</li>
                            <li>Meditation practices</li>
                        </ul>
                    </div>
                    <p class="price">Available in all memberships</p>
                </div>

                <!-- SENIOR FITNESS - Special pricing -->
                <div class="program-box specialty">
                    <span class="material-symbols-outlined icon">elderly</span>
                    <h3>SENIOR FITNESS</h3>
                    <p class="level">Level: Beginner</p>
                    <p class="description">Safe, low-impact exercises focusing on balance, mobility, and bone density. Maintain independence through movement.</p>
                    <div class="program-info">
                        <p><span class="material-symbols-outlined">schedule</span> Gentle Pace Classes</p>
                        <p><span class="material-symbols-outlined">balance</span> Balance & Mobility</p>
                        <p><span class="material-symbols-outlined">shield</span> Safety First Approach</p>
                    </div>
                    <div class="features">
                        <h4>Program Focus:</h4>
                        <ul>
                            <li>Fall prevention exercises</li>
                            <li>Joint mobility work</li>
                            <li>Bone density training</li>
                            <li>Functional movement practice</li>
                            <li>Social community building</li>
                        </ul>
                    </div>
                    <p class="price">Available in all memberships</p>
                </div>

                <!-- TEEN FITNESS - Special teen rates -->
                <div class="program-box specialty">
                    <span class="material-symbols-outlined icon">diversity_1</span>
                    <h3>TEEN FITNESS</h3>
                    <p class="level">Level: Beginner-Intermediate</p>
                    <p class="description">Age-appropriate strength and conditioning. Build healthy habits and confidence in a supervised environment.</p>
                    <div class="program-info">
                        <p><span class="material-symbols-outlined">schedule</span> After School Sessions</p>
                        <p><span class="material-symbols-outlined">safety_check</span> Supervised Training</p>
                        <p><span class="material-symbols-outlined">school</span> 13-18 Years</p>
                    </div>
                    <div class="features">
                        <h4>Program Elements:</h4>
                        <ul>
                            <li>Proper lifting technique</li>
                            <li>Sports conditioning</li>
                            <li>Nutrition education</li>
                            <li>Confidence building</li>
                            <li>Peer group workouts</li>
                        </ul>
                    </div>
                    <p class="price">Available in all memberships</p>
                </div>

                <!-- CALISTHENICS - Available in all memberships -->
                <div class="program-box strength">
                    <span class="material-symbols-outlined icon">sports_gymnastics</span>
                    <h3>CALISTHENICS</h3>
                    <p class="level">Level: All Levels</p>
                    <p class="description">Master bodyweight movements like push-ups, pull-ups, and handstands. Build functional strength and control.</p>
                    <div class="program-info">
                        <p><span class="material-symbols-outlined">schedule</span> Skill Progression</p>
                        <p><span class="material-symbols-outlined">front_hand</span> Advanced Movements</p>
                        <p><span class="material-symbols-outlined">body_fat</span> Bodyweight Mastery</p>
                    </div>
                    <div class="features">
                        <h4>Skill Development:</h4>
                        <ul>
                            <li>Pull-up progression</li>
                            <li>Push-up variations</li>
                            <li>Handstand training</li>
                            <li>Muscle-up technique</li>
                            <li>Human flag progressions</li>
                        </ul>
                    </div>
                    <p class="price">Available in all memberships</p>
                </div>

                <!-- ENDURANCE TRAINING - Available in all memberships -->
                <div class="program-box cardio">
                    <span class="material-symbols-outlined icon">directions_run</span>
                    <h3>ENDURANCE TRAINING</h3>
                    <p class="level">Level: Intermediate-Advanced</p>
                    <p class="description">Prepare for races with structured running programs. Build stamina through progressive distance increases.</p>
                    <div class="program-info">
                        <p><span class="material-symbols-outlined">schedule</span> Race-Specific Plans</p>
                        <p><span class="material-symbols-outlined">distance</span> Pace & Distance Focus</p>
                        <p><span class="material-symbols-outlined">flag</span> Runners & Triathletes</p>
                    </div>
                    <div class="features">
                        <h4>Training Plans:</h4>
                        <ul>
                            <li>5K to marathon training</li>
                            <li>Triathlon preparation</li>
                            <li>Pace strategy development</li>
                            <li>Endurance nutrition</li>
                            <li>Recovery for runners</li>
                        </ul>
                    </div>
                    <p class="price">Available in all memberships</p>
                </div>

                <!-- NUTRITION COACHING - Additional fee required -->
                <div class="program-box wellness">
                    <span class="material-symbols-outlined icon">nutrition</span>
                    <h3>NUTRITION COACHING</h3>
                    <p class="level">Level: All Levels</p>
                    <p class="description">Personalized meal planning and nutritional guidance. Learn sustainable eating habits for your goals.</p>
                    <div class="program-info">
                        <p><span class="material-symbols-outlined">schedule</span> Weekly Check-ins</p>
                        <p><span class="material-symbols-outlined">menu_book</span> Custom Meal Plans</p>
                        <p><span class="material-symbols-outlined">monitoring</span> 1-on-1 Consultations</p>
                    </div>
                    <div class="features">
                        <h4>Coaching Includes:</h4>
                        <ul>
                            <li>Personalized meal planning</li>
                            <li>Macronutrient guidance</li>
                            <li>Supplement recommendations</li>
                            <li>Grocery shopping guidance</li>
                            <li>Meal prep strategies</li>
                        </ul>
                    </div>
                    <p class="price">Available in Pro & Elite memberships</p>
                </div>
            </div>
        </section>

        <!-- Program Comparison -->
        <section class="comparison-section">
            <h2>PROGRAM <span class="highlight">COMPARISON</span></h2>
            <div class="comparison-table">
                <table>
                    <thead>
                        <tr>
                            <th>Program</th>
                            <th>Best For</th>
                            <th>Time Commitment</th>
                            <th>Equipment Needed</th>
                            <th>Membership Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Beginner Foundation</td>
                            <td>New gym members</td>
                            <td>3-4 hrs/week</td>
                            <td>Basic gym equipment</td>
                            <td>All Memberships</td>
                        </tr>
                        <tr>
                            <td>Weight Loss</td>
                            <td>Fat loss & transformation</td>
                            <td>4-6 hrs/week</td>
                            <td>Full gym access</td>
                            <td>Pro & Elite</td>
                        </tr>
                        <tr>
                            <td>Muscle Building</td>
                            <td>Size & strength gains</td>
                            <td>4-5 hrs/week</td>
                            <td>Weights & machines</td>
                            <td>All Memberships</td>
                        </tr>
                        <tr>
                            <td>Strength Training</td>
                            <td>Powerlifting & strength</td>
                            <td>3-4 hrs/week</td>
                            <td>Power racks & weights</td>
                            <td>All Memberships</td>
                        </tr>
                        <tr>
                            <td>Athletic Performance</td>
                            <td>Sports & agility training</td>
                            <td>4-5 hrs/week</td>
                            <td>Functional equipment</td>
                            <td>Pro & Elite</td>
                        </tr>
                        <tr>
                            <td>Functional Fitness</td>
                            <td>Varied workouts & community</td>
                            <td>3-4 hrs/week</td>
                            <td>Cross-training equipment</td>
                            <td>All Memberships</td>
                        </tr>
                        <tr>
                            <td>HIIT & Circuit</td>
                            <td>Time-efficient workouts</td>
                            <td>2-3 hrs/week</td>
                            <td>Minimal equipment</td>
                            <td>All Memberships</td>
                        </tr>
                        <tr>
                            <td>Yoga & Mobility</td>
                            <td>Flexibility & recovery</td>
                            <td>1-2 hrs/week</td>
                            <td>Yoga mat</td>
                            <td>All Memberships</td>
                        </tr>
                        <tr>
                            <td>Senior Fitness</td>
                            <td>Balance & mobility</td>
                            <td>2-3 hrs/week</td>
                            <td>Low-impact equipment</td>
                            <td>All Memberships</td>
                        </tr>
                        <tr>
                            <td>Teen Fitness</td>
                            <td>Youth strength training</td>
                            <td>3-4 hrs/week</td>
                            <td>Supervised equipment</td>
                            <td>All Memberships</td>
                        </tr>
                        <tr>
                            <td>Calisthenics</td>
                            <td>Bodyweight mastery</td>
                            <td>3-4 hrs/week</td>
                            <td>Pull-up bars, rings</td>
                            <td>All Memberships</td>
                        </tr>
                        <tr>
                            <td>Endurance Training</td>
                            <td>Running & race prep</td>
                            <td>4-6 hrs/week</td>
                            <td>Treadmill, track</td>
                            <td>Pro & Elite</td>
                        </tr>
                        <tr>
                            <td>Nutrition Coaching</td>
                            <td>Diet & meal planning</td>
                            <td>Consultations</td>
                            <td>N/A</td>
                            <td>Pro & Elite</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="programs-cta">
            <div class="cta-content">
                <h2>READY TO START YOUR <span class="highlight">TRANSFORMATION?</span></h2>
                <p>Book a free consultation with our program specialists to find the perfect program for your goals.</p>
                <div class="cta-buttons">
                    <a href="contact.php" class="cta-btn primary">BOOK FREE CONSULTATION</a>
                    <a href="membership.php" class="cta-btn secondary">VIEW MEMBERSHIP PLANS</a>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-col">
                    <div class="logo">
                        <img src="pics/LEGEDS_FITNESS2-removebg-preview.png" alt="Legends Fitness Logo" id="logo">
                    </div>
                    <p>We are committed to helping you achieve your fitness goals in a supportive and motivating environment.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h3>Popular Programs</h3>
                    <div class="footer-links">
                        <li><a href="#weightloss">Weight Loss Program</a></li>
                        <li><a href="#muscle">Muscle Building</a></li>
                        <li><a href="#hiit">HIIT & Circuit Training</a></li>
                        <li><a href="#yoga">Yoga & Mobility</a></li>
                        <li><a href="#strength">Strength Training</a></li>
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
                    <h3>Quick Links</h3>
                    <div class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="membership.php">Membership</a></li>
                        <li><a href="programs.php">Programs</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="contact.php">Contact</a></li>
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