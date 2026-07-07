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

include('connection.php');
$email='';
$msg='';
$request_id='';
$found=true;
$approved=false;
$reset_success=false;
$pending=false;
$password_error=false;

if(isset($_POST['send'])){
    $email=$_POST['email'];
    $msg=$_POST['message'];
    $result=mysqli_query($conn,"SELECT email,member_id from members");
    while($row=mysqli_fetch_array($result)){
        if($row['email']==$email){
            mysqli_query($conn,"INSERT into requests(email, message, member_id) values('$email','$msg','$row[member_id]')");
            $found=true;
            break;
        }
        else{
            $found=false;
        }
    }
}

if(isset($_GET['check'])){
    $checkemail=$_GET['email'];
    $result=mysqli_query($conn,"SELECT * from requests WHERE email='$checkemail' ORDER BY updated_at DESC LIMIT 1");
    $row=mysqli_fetch_array($result);
    $request_id=$row['request_id'];
    if($row != null && $row['status'] == 'approved'){
        $approved=true;
        $date=$row['updated_at'];
    }
    if($row != null && $row['status'] == 'pending'){
        $pending=true;
    } 
}

if(isset($_POST['reset_password'])){
    $request_id=$_POST['request_id'];
    $new_password=$_POST['new_password'];
    $confirm_password=$_POST['confirm_password'];   
    if($new_password == $confirm_password){
        $email = $_POST['email'];
        mysqli_query($conn, "UPDATE members SET password='$confirm_password' WHERE email='$email'");
        mysqli_query($conn, "UPDATE requests SET status='completed' WHERE request_id='$request_id'");        
        $reset_success = true;
    } else {
        $password_error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Legends Fitness Gym</title>
    <link rel="stylesheet" href="forgot.css">
    <link rel="stylesheet" href="header-footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton+SC&family=Bowlby+One+SC&family=Contrail+One&family=Fugaz+One&family=New+Amsterdam&family=Outfit:wght@100..900&family=Racing+Sans+One&family=Science+Gothic:wght@100..900&family=Zen+Dots&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<style>
    .no-approval{ display: <?php echo ($approved || $pending) ? 'none' : 'block' ?>;}
    .reset-form-container{ display: <?php echo ($approved) ? 'block' : 'none' ?>;}
    .approval-status{ display: <?php echo ($pending) ? 'block' : 'none' ?>;}
    .profile{display: <?php echo $loggedin ? 'flex' : 'none'; ?>}
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
                <a href="contact.php">CONTACT</a>
            </div>
            <div class="profile">
                <span class="material-symbols-outlined">account_circle</span>
                <p><?php echo $info['first_name'].' '.$info['last_name']; ?></p>
                <span class="material-symbols-outlined">arrow_drop_down</span>
            </div>
            <div class="hover-box">
                <a href="member.php">Dashboard</a>
                <a href="index.php?logout=1">Logout<span class="material-symbols-outlined">logout</span></a>
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
        <section class="forgot-password-section">
            <div class="forgot-password-container">
                <div class="forgot-password-card">
                    <div class="password-header">
                        <h1><span class="material-symbols-outlined">lock_reset</span> Password Recovery</h1>
                        <p class="subtitle">Get back access to your Legends Fitness account</p>
                    </div>

                    <?php if($reset_success): ?>
                    <div class="success-message">
                        <span class="material-symbols-outlined">check_circle</span>
                        <h3>Password Reset Successful!</h3>
                        <p>Your password has been updated successfully. You can now login with your new password.</p>
                        <a href="signin.php" class="btn-login">
                            <span class="material-symbols-outlined">login</span>
                            Go to Login
                        </a>
                    </div>
                    <?php endif; ?>

                    <div class="recovery-options">
                        <div class="option-card" id="sendRequestCard">
                            <div class="option-header">
                                <div class="option-icon">
                                    <span class="material-symbols-outlined">send</span>
                                </div>
                                <h3>Send Request to Admin</h3>
                            </div>
                            <p class="option-description">Request password reset approval from gym administrator</p>
                            
                            <form method="POST" class="option-form" id="sendRequestForm">
                                <div class="form-group">
                                    <label for="memberEmail">
                                        <span class="material-symbols-outlined">email</span>
                                        Member Email
                                    </label>
                                    <input type="email" id="memberEmail" name="email" placeholder="Enter your registered email address" required>
                                    <?php if($found==false){echo "<div class='error'><span class='material-symbols-outlined'>exclamation</span>Email not found</div>";} ?>
                                </div>
                                
                                <div class="form-group">
                                    <label for="message">
                                        <span class="material-symbols-outlined">message</span>
                                        Additional Message (Optional)
                                    </label>
                                    <textarea id="message" name="message" rows="3" placeholder="Add any details to help admin identify your account..."></textarea>
                                </div>
                                
                                <button type="submit" class="btn-send-request" name="send">
                                    <span class="material-symbols-outlined">send</span>
                                    Send Approval Request
                                </button>
                            </form>
                        </div>
                        
                        <div class="option-card" id="checkApprovalCard">
                            <div class="option-header">
                                <div class="option-icon">
                                    <span class="material-symbols-outlined">task_alt</span>
                                </div>
                                <h3>Check Approval Status</h3>
                            </div>
                            <p class="option-description">Check if your request has been approved by admin</p>
                            
                            <form method="GET" class="option-form" id="checkApprovalForm">
                                <div class="form-group">
                                    <label for="checkEmail">
                                        <span class="material-symbols-outlined">email</span>
                                        Enter Your Email
                                    </label>
                                    <input type="email" id="checkEmail" name="email" placeholder="Enter email to check approval status" required>
                                </div>
                                
                                <button type="submit" class="btn-check-approval" name="check">
                                    <span class="material-symbols-outlined">search</span>
                                    Check Approval Status
                                </button>
                            </form>
                            
                            <div class="approval-container">
                                <div class="no-approval" id="noApproval">
                                    <span class="material-symbols-outlined">pending</span>
                                    <p>No approval found or request is still pending.</p>
                                    <small>Admin may not have reviewed your request yet.</small>
                                </div>
                                <?php if(!$approved){ ?>
                                    <div class="approval-status" id="pendingStatus">
                                        <div class="status-card pending">
                                            <span class="material-symbols-outlined">pending</span>
                                            <h4>Request Pending</h4>
                                            <p>Your password reset request is waiting for admin approval.</p>
                                            <small>Request ID: <?php echo $request_id; ?></small>
                                        </div>
                                    </div>
                                <?php } ?>
                                
                                <div class="reset-form-container">
                                    <div class="status-card approved">
                                        <span class="material-symbols-outlined">check_circle</span>
                                        <h4>Request Approved!</h4>
                                        <p>Your request was approved on <?php echo $date; ?></p>
                                        <p class="instruction">You can now set a new password for your account.</p>
                                    </div>
                                    
                                    <form method="POST" class="reset-password-form">
                                        <input type="hidden" name="request_id" value="<?php echo $request_id; ?>">
                                        <input type="hidden" name="email" value="<?php echo $checkemail; ?>">
                                        
                                        <div class="form-group">
                                            <label for="new_password">
                                                <span class="material-symbols-outlined">lock</span>
                                                New Password
                                            </label>
                                            <input type="password" id="new_password" name="new_password" 
                                                   placeholder="Enter new password" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="confirm_password">
                                                <span class="material-symbols-outlined">lock_reset</span>
                                                Confirm Password
                                            </label>
                                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
                                            <?php if($password_error==true){echo "<div class='error'><span class='material-symbols-outlined'>exclamation</span>Passwords do not match</div>";} ?>
                                        </div>
                                        
                                        <button type="submit" class="btn-reset-password" name="reset_password">
                                            <span class="material-symbols-outlined">lock_reset</span>
                                            Reset Password
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="recovery-info">
                        <div class="info-box">
                            <div>
                                <span class="material-symbols-outlined">info</span>
                                <h4>How it works:</h4>
                            </div>
                            <ol>
                                <li>Send approval request to admin with your registered email</li>
                                <li>Gym administrator will review and approve your request</li>
                                <li>Check approval status with the same email</li>
                                <li>If approved, set a new password immediately</li>
                            </ol>
                        </div>
                        
                        <div class="contact-support">
                            <p>Need immediate help? <a href="contact.php"><span class="material-symbols-outlined">support_agent</span> Contact Support</a></p>
                        </div>
                    </div>
                    
                    <div class="navigation-links">
                        <a href="signin.php" class="nav-link">
                            <span class="material-symbols-outlined">arrow_back</span>
                            Back to Login
                        </a>
                        <a href="signup.php" class="nav-link">
                            <span class="material-symbols-outlined">person_add</span>
                            Create New Account
                        </a>
                    </div>
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