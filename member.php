<?php
if(isset($_GET['logout'])){
    session_destroy();
    header('location:index.php');
    exit();
}

session_start();
include('connection.php');
if(!isset($_SESSION['member_id'])){
    header('location: signin.php');
    exit();
}

if(!isset($_GET['nav'])&&!isset($_GET['edit'])){
    header('location:member.php?nav=dashboard');
}

$id=$_SESSION['member_id'];

$memberRecord=mysqli_query($conn,"SELECT*from members where member_id='$id'");
$row1=mysqli_fetch_array($memberRecord);
$fname=$row1['first_name'];
$lname=$row1['last_name'];
$email=$row1['email'];
$phoneno=$row1['phone_no'];
$weight=$row1['weight'];
$height=$row1['height'];
$gender=$row1['gender'];
$dob=$row1['dob'];

$subRecord=mysqli_query($conn,"SELECT*from member_plans where member_id='$id' order by subscription_id desc limit 1");
$row2=mysqli_fetch_array($subRecord);
$planId=$row2['plan_id'];
$startDate=$row2['start_date'];
$endDate=$row2['end_date'];
$status=$row2['status'];

$planRecord=mysqli_query($conn,"SELECT*from plans where plan_id='$planId'");
$plan=mysqli_fetch_array($planRecord);
$planName=$plan['plan_name'];
$price=$plan['price'];

$currDate=date("Y-m-d");
$end=date("Y-m-d" , strtotime($endDate));
$daysleft=(strtotime($end)-strtotime($currDate))/86400;
$today=date("l, j F",strtotime($currDate));

$expired=false;
if($daysleft<=0){
    mysqli_query($conn,"UPDATE member_plans set status='Expired' where member_id='$id'");
    $expired=true;
}
$disabled = ($expired == true) ? "disabled" : "";

if(isset($_GET['renew'])){
    mysqli_query($conn,"INSERT into member_plans(member_id, plan_id) values('$id','$planId')");
    header('location:member.php?nav=dashboard');
}

if(isset($_POST['upgrade'])){
    $selectedPlan=$_POST['plan'];
    mysqli_query($conn,"INSERT into member_plans(member_id,plan_id) values('$id','$selectedPlan')");
    header('location:member.php?nav=membership');
}

if(isset($_POST['enroll'])){
    $pID=$_POST['programID'];
    mysqli_query($conn,"INSERT into member_programs(member_id,program_id) values ('$id','$pID')");
    header('location:member.php?nav=programs');
}
if(isset($_POST['cancel'])){
    $enrollID=$_POST['cancel'];
    mysqli_query($conn,"DELETE from member_programs where enrollment_id='$enrollID'");
    header('location:member.php?nav=programs');
}
$edit=false;
if(isset($_GET['edit'])){
    $edit=true;
}

if(isset($_POST['save'])){
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $phoneno=$_POST['phoneno'];
    $dob=$_POST['dob'];
    $gender=$_POST['gender'];
    $weight=$_POST['weight'];
    $height=$_POST['height'];
    mysqli_query($conn,"UPDATE members set first_name='$fname',last_name='$lname',email='$email',
    phone_no='$phoneno',gender='$gender',height='$height',weight='$weight',dob='$dob' where member_id='$id'");
    header('location:member.php?nav=profile');
}
if(isset($_GET['delete'])){
    mysqli_query($conn,"DELETE from members where member_id='$id'");
    header('location:signin.php');
}
if(isset($_POST['set'])){
    $goalName=$_POST['goalName'];
    $target=$_POST['target'];
    mysqli_query($conn,"INSERT into goals(member_id,goal_name,target) values('$id','$goalName','$target')");
    header('location:member.php?nav=profile');
}
if(isset($_GET['del'])){
    $goalId=$_GET['del'];
    mysqli_query($conn,"DELETE from goals where goal_id='$goalId' and member_id='$id'");
    header('location:member.php?nav=profile');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legends Fitness Gym | Transform Your Body</title>
    <link rel="stylesheet" href="member.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton+SC&family=Bowlby+One+SC&family=Contrail+One&family=Fugaz+One&family=New+Amsterdam&family=Outfit:wght@100..900&family=Racing+Sans+One&family=Science+Gothic:wght@100..900&family=Zen+Dots&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<style>
    .enroll-btn:disabled, .join-btn:disabled{
        background: #444 !important;
        background-image: none !important;
        color: <?php if($expired==false) echo '#00ff6aff'; else echo 'rgb(160,160,160)'; ?> !important;
        border: 1px solid #555 !important;
        cursor: not-allowed;
        position: relative;
        box-shadow: none;
    }
</style>
<body>
    <header>
        <h3>Welcome Back, <?php echo $fname.' '.$lname;?>!</h2>
        <div class="profile-box">           
            <label class="profile-info">
                <input type="checkbox" class="check">
                <div class="profile-icon">
                    <span class="material-symbols-outlined">account_circle</span>
                    <span id="arrow" class="material-symbols-outlined">arrow_drop_down</span>
                </div>
                <div class="hover-box">
                    <a href="index.php">Home</a><hr>
                    <a href="index.php?logout=1">Logout<span class="material-symbols-outlined">logout</span></a>
                </div>
            </label>
        </div>
    </header>
    <input type="checkbox" id="menu">
    <main>
        <input type="radio" id="dashboard" class="options" name="nav" <?php echo (isset($_GET['nav']) && $_GET['nav']=='dashboard')?'checked':''; ?>>
        <input type="radio" id="profile" class="options" name="nav" <?php echo ((isset($_GET['nav']) && $_GET['nav']=='profile') || isset($_GET['edit']))?'checked':''; ?>>
        <input type="radio" id="membership" class="options" name="nav" <?php echo (isset($_GET['nav']) && $_GET['nav']=='membership')?'checked':''; ?>>
        <input type="radio" id="programs" class="options" name="nav" <?php echo (isset($_GET['nav']) && $_GET['nav']=='programs')?'checked':''; ?>>
        <input type="radio" id="trainers" class="options" name="nav" <?php echo (isset($_GET['nav']) && $_GET['nav']=='trainers')?'checked':''; ?>>
        <div class="left-sec">
            <label id="top-icon" for="menu">
                <span id="menu-icon" class="material-symbols-outlined">left_panel_open</span>
                <div class="logo"><img src="pics/LEGEDS_FITNESS2-removebg-preview.png" alt="" id="logo"></div>
            </label>
            <label for="dashboard"><span class="material-symbols-outlined">dashboard</span><p>DASHBOARD</p></label>
            <label for="profile"><span class="material-symbols-outlined">person</span><p>PROFILE</p></label>
            <label for="membership"><span class="material-symbols-outlined">payments</span><p>MEMBERSHIP PLAN</p></label>
            <label for="programs"><span class="material-symbols-outlined">overview</span><p>PROGRAMS & SCHEDULE</p></label>
            <label for="trainers"><span class="material-symbols-outlined">fitness_center</span><p>YOUR TRAINERS</p></label>
            <a href="index.php?logout=1" id="bottom-icon"><span class="material-symbols-outlined">logout</span><p>LOGOUT</p></a>
        </div>
        <div class="right-sec">
            <div class="dashboard">
                <div class="dashboard-header">
                    <div class="header-top">
                        <h1><span class="material-symbols-outlined">dashboard</span> DASHBOARD</h1>
                    </div>
                </div>

                <div class="main-grid">
                    <div class="left-column">
                        <div class="stats-section">
                            <div class="section-header">
                                <h3><span class="material-symbols-outlined">trending_up</span> Fitness Overview</h3>
                            </div>
                            <div class="stats-grid">
                                <div class="stat-card">
                                    <div class="card-icon">
                                        <span class="material-symbols-outlined">fitness_center</span>
                                    </div>
                                    <div class="card-content">
                                        <h4>Workout Streak</h4>
                                        <p class="stat-value"><?php
                                         $stat=rand(10,30);
                                         echo $stat;?> Days</p>
                                        <div class="streak-bar">
                                            <div class="streak-fill" style="width: <?php echo ($stat/30)*100 ?>%"></div>
                                        </div>
                                        <p class="stat-detail">Personal best: <?php echo rand(20,30);?> days</p>
                                    </div>
                                </div>

                                <div class="stat-card">
                                    <div class="card-icon">
                                        <span class="material-symbols-outlined">local_fire_department</span>
                                    </div>
                                    <div class="card-content">
                                        <h4>Calories Burned</h4>
                                        <p class="stat-value"><?php echo rand(8000,9500);?> cal</p>
                                        <p class="stat-detail">Monthly total</p>
                                        <div class="calorie-progress">
                                            <span>Goal: 10,000 cal</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="stat-card">
                                    <div class="card-icon">
                                        <span class="material-symbols-outlined">monitor_heart</span>
                                    </div>
                                    <div class="card-content">
                                        <h4>Avg Heart Rate</h4>
                                        <p class="stat-value"><?php echo rand(110,160);?> bpm</p>
                                        <p class="stat-detail">Last workout average</p>
                                        <div class="heart-rate">
                                            <span class="rate-indicator excellent"></span>
                                            <span>Excellent</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="stat-card">
                                    <div class="card-icon">
                                        <span class="material-symbols-outlined">timer</span>
                                    </div>
                                    <div class="card-content">
                                        <h4>Workout Duration</h4>
                                        <p class="stat-value"><?php echo rand(6,10)*5;?> min</p>
                                        <p class="stat-detail">Average per session</p>
                                        <div class="duration-comparison">
                                            <span>↑ <?php echo rand(5,12);?>% from last month</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="measurements-section">
                            <div class="section-header">
                                <h3><span class="material-symbols-outlined">straighten</span> Body Measurements</h3>
                            </div>
                            <div class="measurement-cards">
                                <div class="measurement-card">
                                    <div class="measurement-icon">
                                        <span class="material-symbols-outlined">weight</span>
                                    </div>
                                    <div class="measurement-content">
                                        <h4>Weight</h4>
                                        <p class="measurement-value"><?php echo $weight;?> kg</p>
                                        <p class="measurement-change down">↓ 2.5 kg this month</p>
                                    </div>
                                </div>
                                <div class="measurement-card">
                                    <div class="measurement-icon">
                                        <span class="material-symbols-outlined">format_size</span>
                                    </div>
                                    <div class="measurement-content">
                                        <h4>Muscle Mass</h4>
                                        <p class="measurement-value">+<?php echo rand(20,30)/10;?>%</p>
                                        <p class="measurement-change up">↑ Target achieved</p>
                                    </div>
                                </div>
                                <div class="measurement-card">
                                    <div class="measurement-icon">
                                        <span class="material-symbols-outlined">water_drop</span>
                                    </div>
                                    <div class="measurement-content">
                                        <h4>Body Fat</h4>
                                        <p class="measurement-value"><?php echo rand(150,200)/10;?>%</p>
                                        <p class="measurement-change down">↓ <?php echo rand(15,20)/10;?>% this month</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="quick-actions">
                            <div class="section-header">
                                <h3><span class="material-symbols-outlined">bolt</span> Quick Actions</h3>
                            </div>
                            <div class="action-grid">
                                <a href="member.php?nav=programs" class="action-card">
                                    <span class="material-symbols-outlined">library_add</span>
                                    <span>Join Programs</span>
                                </a>
                                <a href="member.php?nav=trainers" class="action-card">
                                    <span class="material-symbols-outlined">person</span>
                                    <span>My Trainers</span>
                                </a>
                                <a href="member.php?nav=programs" class="action-card">
                                    <span class="material-symbols-outlined">list_alt</span>
                                    <span>My Programs</span>
                                </a>
                                <a href="member.php?nav=profile" class="action-card">
                                    <span class="material-symbols-outlined">flag</span>
                                    <span>My Goals</span>
                                </a>
                                <a href="member.php?nav=membership" class="action-card">
                                    <span class="material-symbols-outlined">card_membership</span>
                                    <span>My Plan</span>
                                </a>
                                <a href="contact.php" class="action-card">
                                    <span class="material-symbols-outlined">support_agent</span>
                                    <span>Support</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="right-column">
                        <div class="membership-status-card">
                            <div class="section-header">
                                <h3><span class="material-symbols-outlined">workspace_premium</span> Membership Status</h3>
                                <span class="status-badge <?php echo $status; ?>"><?php echo $status ?></span>
                            </div>
                            <div class="membership-details">
                                <div class="plan-info">
                                    <h4><?php echo $planName;?> PLAN</h4>
                                    <p class="plan-price">$<?php echo $price;?> / month</p>

                                    <div class="plan-features" style="display: <?php echo ($planId==1) ? 'grid':'none' ?>;">
                                        <span><span class="material-symbols-outlined">check</span> Basic Equipment Access</span>
                                        <span><span class="material-symbols-outlined">check</span> 2 Group Classes/Week</span>
                                        <span><span class="material-symbols-outlined">check</span> Basic Locker Facilities</span>
                                        <span><span class="material-symbols-outlined">check</span> Nutrition Starter Guide</span>
                                    </div>
                                    <div class="plan-features" style="display: <?php echo ($planId==2) ? 'grid':'none' ?>;">
                                        <span><span class="material-symbols-outlined">check</span> All Premium Equipment</span>
                                        <span><span class="material-symbols-outlined">check</span> Unlimited Group Classes</span>
                                        <span><span class="material-symbols-outlined">check</span> 1 Personal Training/Month</span>
                                        <span><span class="material-symbols-outlined">check</span> Towel & Sauna Access</span>
                                    </div>
                                    <div class="plan-features" style="display: <?php echo ($planId==3) ? 'grid':'none' ?>;">
                                        <span><span class="material-symbols-outlined">check</span> VIP Equipment & Recovery Zone</span>
                                        <span><span class="material-symbols-outlined">check</span> 4 Personal Trainings/Month</span>
                                        <span><span class="material-symbols-outlined">check</span> Private Locker & Cryotherapy</span>
                                        <span><span class="material-symbols-outlined">check</span> Personalized Nutrition Plan</span>
                                    </div>
                                    <div class="plan-features" style="display: <?php echo ($planId==4) ? 'grid':'none' ?>;">
                                        <span><span class="material-symbols-outlined">check</span> Full Facility Access</span>
                                        <span><span class="material-symbols-outlined">check</span> 1 Group Class Included</span>
                                        <span><span class="material-symbols-outlined">check</span> Basic Equipment Trial</span>
                                        <span><span class="material-symbols-outlined">check</span> Locker Room Access</span>
                                    </div>
                                
                                </div>
                                <div class="expiry-info">
                                    <div class="expiry-progress">
                                        <div class="progress-circle">
                                            <svg width="100" height="100">
                                                <circle class="progress-bg" cx="50" cy="50" r="40"></circle>
                                                <circle class="progress-bar" cx="50" cy="50" r="40" 
                                                        stroke-dasharray="251.2" 
                                                        stroke-dashoffset="<?php echo 251.2 * (30  - ($expired?'30':$daysleft)) / 30 ?>">
                                                        </circle>
                                                    </svg>
                                            <span class="progress-text"><?php echo $expired?'0':$daysleft ?><br><small>days left</small></span>
                                        </div>
                                    </div>
                                    
                                    <div class="expiry-dates">
                                        <p><strong>Started:</strong> <?php echo date("F j, Y", strtotime($startDate));?></p>
                                        <p><strong>Expires:</strong> <?php echo date("F j, Y", strtotime($endDate));?></p>
                                        <input type="checkbox" id="renew-btn">
                                        <label for="renew-btn" class="renew-btn">
                                            <span class="material-symbols-outlined">update</span>
                                            Renew Now
                                        </label>
                                        <div class="renew-box">
                                            <h3>Are you sure you want to Renew your current membership plan?</h3>
                                            <div class="btn-box">
                                                <label for="renew-btn" class="no-btn">NO</label>
                                                <a class="yes-btn" href="member.php?nav=dashboard&renew=<?php echo $id?>">YES</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="todays-schedule">
                            <div class="section-header">
                                <h3><span class="material-symbols-outlined">today</span> Today's Schedule</h3>
                                <span class="schedule-date"><?php echo $today ?></span>
                            </div>
                            <div class="schedule-items">
                                <?php 
                                $daytoday = date("l");

                                $joined_query = mysqli_query($conn, "SELECT program_id FROM member_programs WHERE member_id = $id");
                                $joined_programs = [];
                                while($joined = mysqli_fetch_array($joined_query)) {
                                    $joined_programs[] = $joined['program_id'];
                                }

                                $today_query = mysqli_query($conn, "SELECT * FROM programs p, trainers t 
                                                                WHERE program_id IN (SELECT program_id FROM plan_programs WHERE plan_id='$planId') 
                                                                AND p.trainer_id = t.trainer_id 
                                                                AND schedule_day = '$daytoday'"); 
                                
                                if(mysqli_num_rows($today_query) == 0) { ?>
                                    <div class="no-programs">
                                        <span class="material-symbols-outlined">filter_alt</span>
                                        <p>No programs scheduled for today.</p>
                                    </div>
                                <?php } else { ?>
                                <form action="member.php?nav=dashboard" method="post">

                                    <?php while($today_programs = mysqli_fetch_array($today_query)){
                                        $program_id = $today_programs['program_id'];
                                        $is_joined = in_array($program_id, $joined_programs);
                                    ?>

                                        <div class="schedule-item <?php echo $is_joined ? 'completed' : 'upcoming'; ?>">
                                            <div class="schedule-time">
                                                <span class="material-symbols-outlined">
                                                    <?php echo $is_joined ? 'check_circle' : 'schedule'; ?>
                                                </span>
                                                <span><?php echo date("g:i A", strtotime($today_programs['schedule_time'])); ?></span>
                                            </div>
                                            <div class="schedule-details">
                                                <h4><?php echo $today_programs['program_name']; ?></h4>
                                                <p>Trainer: <?php echo $today_programs['first_name']." ".$today_programs['last_name']; ?></p>
                                            </div>
                                            <?php if($is_joined){ ?>
                                                <span class="material-symbols-outlined">check</span>
                                            <?php }else{ ?>
                                                <input type="hidden" name="programID" value="<?php echo $program_id; ?>">
                                                <button type="submit" class="join-btn" name="enroll" <?php echo $expired?'disabled':'' ?>><?php echo $expired?'Renew Membership':'Join' ?></button>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </form>
                                <?php } ?>
                            </div>
                            <a href="member.php?nav=programs" class="view-full-schedule">
                                View Full Weekly Schedule
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile">
                <div class="profile-container">
                    <div class="profile-header">
                        <h1><span class="material-symbols-outlined">Account_circle</span> MY PROFILE</h1>
                        <a href="signin.php" id="logout-btn" class="material-symbols-outlined"><p>Logout</p>logout</a>
                    </div>

                    <div class="profile-content">
                        <div class="left-column">
                            <div class="profile-card">
                                <div class="profile-photo-section">
                                    <div class="profile-photo">
                                        <span class="material-symbols-outlined">person</span>
                                    </div>
                                    <div class="member-info">
                                        <h2 class="member-name"><?php echo $fname." ".$lname; ?></h2>
                                        <div class="member-tags">
                                            <span class="member-tag premium"><?php echo $planName; ?> MEMBER</span>
                                            <span class="member-tag active"><?php echo $status; ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="info-section">
                                    <div class="section-header">
                                        <h3>
                                            <span class="material-symbols-outlined">person_pin</span> Account Information
                                            <a href="member.php?edit=<?php echo $id; ?>" class="edit-btn" name="edit">
                                                <span class="material-symbols-outlined">edit</span>
                                            </a>
                                        </h3>
                                    </div>
                                    <form action="member.php?nav=profile" method="post" class="profile-form">
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input type="text" name="fname" value="<?php echo $fname; ?>" <?php echo $edit?'':'readonly' ?>>
                                            </div>
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input type="text" name="lname" value="<?php echo $lname; ?>" <?php echo $edit?'':'readonly' ?>>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Email Address</label>
                                            <div class="input-with-action">
                                                <input type="email" name="email" value="<?php echo $email; ?>" <?php echo $edit?'':'readonly' ?>>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <div class="input-with-action">
                                                <input type="tel" name="phoneno" value="<?php echo $phoneno; ?>" <?php echo $edit?'':'readonly' ?>>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Date of Birth</label>
                                            <input type="date" name="dob" value="<?php echo $dob; ?>" <?php echo $edit?'':'readonly' ?>>
                                        </div>

                                        <div class="form-group">
                                            <label>Gender</label>
                                            <div class="radio-box">
                                                <label class="radio-label">
                                                    <input type="radio" name="gender" value="male" <?php echo ($gender=='male')?'checked':''; ?> <?php echo $edit?'':'readonly' ?>>
                                                    <span class="radio-custom"><span class="material-symbols-outlined">check_small</span></span>
                                                    Male
                                                </label>
                                                <label class="radio-label">
                                                    <input type="radio" name="gender" value="female" <?php echo ($gender=='female')?'checked':''; ?> <?php echo $edit?'':'readonly' ?>>
                                                    <span class="radio-custom"><span class="material-symbols-outlined">check_small</span></span>
                                                    Female
                                                </label>
                                            </div>
                                            <br>
                                              <div class="form-row">
                                                <div class="form-group">
                                                    <label>Weight (kg)</label>
                                                    <input type="text" name="weight" value="<?php echo $weight?$weight:'N/A'; ?>" <?php echo $edit?'':'readonly' ?>>
                                                </div>
                                                <div class="form-group">
                                                    <label>Height (cm)</label>
                                                    <input type="text" name="height" value="<?php echo $height?$height:'N/A'; ?>" <?php echo $edit?'':'readonly' ?>>
                                                </div>
                                            </div>
                                        </div><br>
                                        <button class="primary-btn" name="save" style=" display: <?php echo $edit?'flex':'none'; ?>;">
                                            <span class="material-symbols-outlined">save</span>
                                            Save Changes
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="right-column">
                            <div class="goals-card" id="goals-card">
                                <div class="section-header">
                                    <h3><span class="material-symbols-outlined">flag</span> Fitness Goals</h3>
                                </div>
                                <?php $goal_query=mysqli_query($conn,"SELECT* from goals where member_id='$id'");
                                if(mysqli_num_rows($goal_query)==0){  ?>

                                <div class="no-goals">
                                    <span class="material-symbols-outlined">hourglass_empty</span>
                                    <h3>NO GOALS SET</h3>
                                </div>

                                <?php }else{while($goals=mysqli_fetch_array($goal_query)){  ?>

                                <div class="goals-list">
                                    <div class="goal-item">
                                        <div class="goal-info">
                                            <a href="member.php?del=<?php echo $goals['goal_id']; ?>"><span class="material-symbols-outlined">delete</span></a>
                                            <h4><?php echo $goals['goal_name']; ?></h4>
                                            <p>Target: <?php echo $goals['target']; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <?php }} ?>
                                <input type="checkbox" id="set-goal-btn">
                                <form action="member.php?nav=profile" method="post">
                                    <div class="goal-item">
                                        <div class="goal-info">
                                            <label for="goal-name">Set Name<br>
                                                <input type="text" name="goalName" id="goal-name" list="goal-suggestions" placeholder="Set goal name...">
                                                <datalist id="goal-suggestions">
                                                    <option value="Weight Loss">
                                                    <option value="Muscle Gain">
                                                    <option value="Weight Gain">
                                                    <option value="Workout Consistency">
                                                    <option value="Core Strength">
                                                    <option value="Cardio Fitness">
                                                    <option value="Fat Loss">
                                                </datalist>
                                            </label><br>
                                            <label for="goal-name">Set Target<br>
                                                <input type="text" name="target" id="goal-name" placeholder="Set goal target...">
                                            </label>
                                            <div class="btn-box">
                                                <label for="set-goal-btn" class="cancel-goal-btn">CANCEL</label>
                                                <button type="submit" name="set" class="set-btn">SET</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <label for="set-goal-btn" class="set-goals-btn">
                                    <span class="material-symbols-outlined">add_circle</span>
                                    Set New Goals
                                </label>
                            </div>

                            <div class="settings-card">
                                <div class="section-header">
                                    <h3><span class="material-symbols-outlined">settings</span> Account Settings</h3>
                                </div>
                                <div class="settings-actions">
                                    <a href="forgotpassword.php" class="change-password-btn">
                                        <span class="material-symbols-outlined">lock</span>
                                        Change Password
                                    </a>
                                    <label for="delete-acc-btn" class="change-password-btn">
                                        <span class="material-symbols-outlined">person_cancel</span>
                                        Delete Account
                                    </label>
                                    <input type="checkbox" id="delete-acc-btn">
                                    <div class="delete-box">
                                        <h3>Are you sure you want to delete your account?</h3>
                                        <div class="btn-box">
                                            <label for="delete-acc-btn" class="no-btn">NO</label>
                                            <a class="yes-btn" href="member.php?delete=<?php echo $id?>">YES</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section class="membership">
                <div class="membership-header">
                    <h1><span class="material-symbols-outlined">payment_card</span> Membership</h1>
                    <span class="status-badge <?php echo $status; ?>"><?php echo $status ?></span>
                </div>

                <div class="membership-content">
                    <div class="membership-details">
                        <div class="plan-card">
                            <div class="plan-header">
                                <h2><?php echo $planName; ?> Membership</h2>
                                <div class="plan-price">$<?php echo $price; ?><span>/month</span></div>
                            </div>
                            
                            <div class="plan-features" style="display: <?php echo ($planId==1) ? 'grid':'none' ?>;">
                                <div class="feature"><span class="icon">✓</span> <span>Basic Equipment Access</span></div>
                                <div class="feature"><span class="icon">✓</span> <span>2 Group Classes/Week</span></div>
                                <div class="feature"><span class="icon">✓</span> <span>Basic Locker Facilities</span></div>
                                <div class="feature"><span class="icon">✓</span> <span>Nutrition Starter Guide</span></div>
                            </div>
                            <div class="plan-features" style="display: <?php echo ($planId==2) ? 'grid':'none' ?>;">
                                <div class="feature"><span class="icon">✓</span> <span>All Premium Equipment</span></div>
                                <div class="feature"><span class="icon">✓</span> <span>Unlimited Group Classes</span></div>
                                <div class="feature"><span class="icon">✓</span> <span>1 Personal Training/Month</span></div>
                                <div class="feature"><span class="icon">✓</span> <span>Towel & Sauna Access</span></div>
                            </div>
                            <div class="plan-features" style="display: <?php echo ($planId==3) ? 'grid':'none' ?>;">
                                <div class="feature"><span class="icon">✓</span> <span>VIP Equipment & Recovery Zone</span></div>
                                <div class="feature"><span class="icon">✓</span> <span>4 Personal Trainings/Month</span></div>
                                <div class="feature"><span class="icon">✓</span> <span>Private Locker & Cryotherapy</span></div>
                                <div class="feature"><span class="icon">✓</span> <span>Personalized Nutrition Plan</span></div>
                            </div>
                            <div class="plan-features" style="display: <?php echo ($planId==4) ? 'grid':'none' ?>;">
                                <div class="feature"><span class="icon">✓</span> <span>Full Facility Access</span></div>
                                <div class="feature"><span class="icon">✓</span> <span>1 Group Class Included</span></div>
                                <div class="feature"><span class="icon">✓</span> <span>Basic Equipment Trial</span></div>
                                <div class="feature"><span class="icon">✓</span> <span>Locker Room Access</span></div>
                            </div>

                            <div class="plan-info">
                                <div class="info-item">
                                    <span class="label">Member Since:</span>
                                    <span class="value"><?php echo date('F d, Y ', strtotime($startDate)); ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Next Payment:</span>
                                    <span class="value"><?php echo date('F d, Y ', strtotime($endDate))." - $".$price; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="actions-section">
                            <div class="section-header">
                                <h3><span class="material-symbols-outlined">bolt</span> Quick Actions</h3>
                            </div>
                            <div class="action-buttons">
                                <input type="checkbox" id="renew-btn2">
                                <label for="renew-btn2" class="action-btn">
                                    <span class="material-symbols-outlined">update</span>
                                    Renew Plan
                                </label>
                                <div class="renew-box2">
                                    <h3>Are you sure you want to Renew your current membership plan?</h3>
                                    <div class="btn-box">
                                        <label for="renew-btn2" class="no-btn">NO</label>
                                        <a class="yes-btn" href="member.php?nav=dashboard&renew=<?php echo $id?>">YES</a>
                                    </div>
                                </div>
                                <input type="checkbox" id="upgrade-btn">
                                <label for="upgrade-btn" class="action-btn">
                                    <span class="material-symbols-outlined">arrow_upload_ready</span>
                                    Upgrade Plan
                                </label>
                                <div class="upgrade-box">
                                    <label class="section-label">Choose Your Membership <span class="required"></span></label>
                                    <div class="radio-group">
                                        <form action="member.php?nav=plan" method="post">
                                            <label class="radio-option">
                                                <input class="radio" type="radio" name="plan" value="1" required>
                                                <div class="radio-content">
                                                    <h3>Starter<span class="radio-custom"><span class="material-symbols-outlined">check_small</span></span></h3>
                                                    <p>Basic gym access, 5 classes/month</p>
                                                    <span class="price">$25/<sub>month</sub></span>
                                                </div>
                                            </label>
                                            
                                            <label class="radio-option">
                                                <input class="radio" type="radio" name="plan" value="2" checked>
                                                <div class="radio-content">
                                                    <h3>Pro<span class="radio-custom"><span class="material-symbols-outlined">check_small</span></span></h3>
                                                    <p>24/7 access, unlimited classes, 2 training sessions</p>
                                                    <span class="price">$40/<sub>month</sub></span>
                                                </div>
                                            </label>
                                            
                                            <label class="radio-option">
                                                <input class="radio" type="radio" name="plan" value="3">
                                                <div class="radio-content">
                                                    <h3>Elite<span class="radio-custom"><span class="material-symbols-outlined">check_small</span></span></h3>
                                                    <p>VIP benefits, 5 training sessions, priority access</p>
                                                    <span class="price">$50/<sub>month</sub></span>
                                                </div>
                                            </label>
                                            <div class="btn-box">
                                                <label for="upgrade-btn" class="no-btn">CANCEL</label>
                                                <button type="submit" name="upgrade" class="yes-btn">CONFIRM</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="membership-actions">
                        <div class="billing-section">
                            <div class="section-header">
                                <h3><span class="material-symbols-outlined">receipt_long</span> Billing History</h3>
                            </div>
                            <div class="billing-list">

                                <?php $history_query=mysqli_query($conn,"SELECT*from  member_plans mp join plans p on mp.member_id='$id' and mp.plan_id=p.plan_id order by subscription_id desc");
                                    while($history=mysqli_fetch_array($history_query)){ ?>
                                    <div class="billing-item">
                                        <div class="date"><?php echo date('F d, Y ', strtotime($history['start_date'])); ?></div>
                                        <div class="details">
                                            <h4><?php echo $history['plan_name'];?> Membership</h4>
                                        </div>
                                        <div class="amount">$<?php echo $history['price']; ?></div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>

                        <div class="support-section">
                            <div class="section-header">
                                <h3><span class="material-symbols-outlined">help</span> Need Help?</h3>
                            </div>
                            <div class="support-options">
                                <a href="" class="support-option">
                                    <span class="material-symbols-outlined">call</span>
                                    <div>
                                        <h4>Call Support</h4>
                                        <p>(555) 123-4567</p>
                                    </div>
                                </a>
                                <a href="" class="support-option">
                                    <span class="material-symbols-outlined">email</span>
                                    <div>
                                        <h4>Email Support</h4>
                                        <p>support@gym.com</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="programs">
                <div class="programs-header">
                    <h1><span class="material-symbols-outlined">stacks</span>PROGRAMS & SCHEDULE</h1>
                    <div class="current-plan-info">
                        <span>⭐</span>
                        <div>
                            <h3><?php echo $planName; ?> PLAN</h3>
                            <p>Access to programs based on your membership level</p>
                        </div>
                    </div>
                </div>

                <div class="programs-schedule-grid">
                    <div class="programs-column">
                        <div class="section-header">
                            <h3><span class="material-symbols-outlined">fitness_center</span>All Available Programs</h3>
                        </div>
                        <div class="programs-grid" id="programs-grid">

                            <?php $result=mysqli_query($conn,"SELECT*from programs p,trainers t where program_id in(select program_id from plan_programs where plan_id='$planId') and p.trainer_id=t.trainer_id;");
                                while($program=mysqli_fetch_array($result)){ ?>

                                <form action="member.php" method="post">
                                    <div class="program-card">
                                        <div class="program-card-header">
                                            <div class="plan-badge <?php echo $planName; ?>"><?php echo $planName; ?></div>
                                            <div class="program-status available">Available</div>
                                        </div>
                                        <div class="program-card-body">
                                            <h3><?php echo $program['program_name']; ?></h3>
                                            <div class="program-meta">
                                                <div class="meta-item"><span>⏱️</span><span><?php echo $program['duration']; ?></span></div>
                                                <div class="meta-item"><span>⚡</span><span><?php echo $program['level']; ?></span></div>
                                                <div class="meta-item"><span>👥</span><span><?php echo $program['group_size']; ?></span></div>
                                            </div>
                                            <div class="trainer-info">
                                                <span>Trainer:</span>
                                                <span><?php echo $program['first_name'].$program['last_name']; ?></span>
                                            </div>
                                            <div class="program-schedule">
                                                <span><?php echo $program['schedule_day']; ?></span>
                                                <span><?php echo date("g:i A", strtotime($program['schedule_time'])); ?></span>
                                            </div>
                                        </div>
                                        <div class="program-card-footer">
                                            <input type="hidden" name="programID" value="<?php echo $program['program_id'];?>">
                                            
                                            <?php $enrolled=mysqli_query($conn,"SELECT*from member_programs where member_id=$id"); 
                                                $match=false;
                                                while($fetch=mysqli_fetch_array($enrolled)){ 
                                                    if($fetch['program_id']==$program['program_id']) 
                                                    $match=true;
                                                }?>
                                                        
                                                <button type="submit" class="enroll-btn" name="enroll" <?php echo $match||$expired?'disabled':'' ?>>
                                                    <?php if($match==true&&$expired==false) echo 'Enrolled';
                                                        elseif($match==false&&$expired==false) echo 'Enroll'; 
                                                        else echo 'Renew Membership'?>
                                                </button>
                                            <a href="programs.html"><button class="details-btn">Details</button></a>
                                        </div>
                                    </div>
                                </form>
                            <?php } ?> 
                        </div>
                    </div>

                    <div class="schedule-column">
                        <div class="section-header">
                            <h3><span class="material-symbols-outlined">calendar_clock</span>Weekly Schedule</h3>
                        </div>
                        
                        <div class="weekly-schedule">
                            <?php
                                $day=['Monday','Tuesday','Wednesday','Thursday','Friday'];
                                $i=0;
                                while($i<5){
                                    $programresult=mysqli_query($conn,"SELECT*from programs p,trainers t where schedule_day='$day[$i]' and 
                                    program_id in(select program_id from plan_programs where plan_id='$planId') and 
                                    p.trainer_id=t.trainer_id;");
                            ?>
                            <div class="day-schedule">
                                <h3 class="day-header"><?php echo $day[$i]; ?></h3>
                                <div class="day-sessions">
                                    <?php while($programrow=mysqli_fetch_array($programresult)){ ?>
                                    <div class="session-card">
                                        <div class="session-time"><?php echo date("g:i A", strtotime($programrow['schedule_time'])); ?></div>
                                        <div class="session-details">
                                            <h4><?php echo $programrow['program_name']; ?></h4>
                                            <p class="session-trainer"><?php echo $programrow['first_name']." ".$programrow['last_name']; ?></p>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php $i++;} ?>
                        </div>
                    </div>
                </div>
                
                <div class="enrollments-section" id="enrollments-section">
                    <div class="section-header">
                        <h3><span class="material-symbols-outlined">inventory</span>Your Enrolled Programs</h3>
                    </div>
                    
                    <?php 
                    $enrollments_query = mysqli_query($conn, "SELECT * FROM trainers t, member_programs e, programs p 
                        WHERE e.member_id = $id AND e.program_id = p.program_id AND p.trainer_id = t.trainer_id
                        ORDER BY e.enrollment_date DESC");

                    if(mysqli_num_rows($enrollments_query) == 0) { 
                    ?>
                        <div class="no-enrollments" id="noEnrollmentsMessage">
                            <div class="empty-state">
                                <span class="material-symbols-outlined">newsstand</span>
                                <h3>No Programs Enrolled</h3>
                                <p>Browse available programs above and start your fitness journey today!</p>
                            </div>
                        </div>
                    <?php } else { ?>
                       <div class="enrollments-container" id="enrollmentsContainer">
                        <?php while($enrollment = mysqli_fetch_array($enrollments_query)) { ?>
                            <form action="member.php" method="post">
                            <div class="enrollment-card" data-program-id="<?php echo $enrollment['program_id']; ?>">
                                
                                <div class="card-header">
                                    <div class="program-icon">
                                        <span class="material-symbols-outlined">fitness_center</span>
                                    </div>
                                    <h3 class="program-name"><?php echo $enrollment['program_name']; ?></h3>
                                </div>
                                
                                <div class="card-content">
                                    <div class="schedule-info">
                                        <div class="info-item">
                                            <span class="material-symbols-outlined icon">schedule</span>
                                            <div class="info-details">
                                                <span class="label">Schedule</span>
                                                <span class="value">
                                                    <?php echo $enrollment['schedule_day'] . ", " . 
                                                        date("g:i A", strtotime($enrollment['schedule_time'])); ?>
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="info-item">
                                            <span class="material-symbols-outlined icon">person</span>
                                            <div class="info-details">
                                                <span class="label">Trainer</span>
                                                <span class="value"><?php echo $enrollment['first_name'] . " " . $enrollment['last_name']; ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="info-item">
                                            <span class="material-symbols-outlined icon">calendar_today</span>
                                            <div class="info-details">
                                                <span class="label">Enrolled Since</span>
                                                <span class="value"><?php echo date("M d, Y", strtotime($enrollment['enrollment_date'])); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-footer">
                                    <a href="programs.html"><button class="view-details-btn">
                                        <span class="material-symbols-outlined">visibility</span>
                                        View Details
                                    </button></a>
                                    <button type="submit" class="cancel-btn" name="cancel" value="<?php echo $enrollment['enrollment_id']; ?>">
                                        <span class="material-symbols-outlined">close</span>
                                        Cancel
                                    </button>
                                </div>
                            </div>
                            </form>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>

                <div class="timetable-section">
                    <div class="section-header">
                        <h3><span class="material-symbols-outlined">insert_chart</span>Weekly Timetable</h3>
                    </div>
                    
                    <div class="timetable-container">
                        <table class="timetable">
                            <thead>
                                <tr>
                                    <th>Time / Day</th>
                                    <th>06:00</th>
                                    <th>07:00</th>
                                    <th>08:00</th>
                                    <th>09:00</th>
                                    <th>10:00</th>
                                    <th>14:00</th>
                                    <th>15:30</th>
                                    <th>16:00</th>
                                    <th>17:00</th>
                                    <th>17:30</th>
                                    <th>18:00</th>
                                    <th>18:30</th>
                                    <th>19:00</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Monday</th>
                                    <td>FUNCTIONAL FITNESS<br><small>Marcus Johnson</small></td>
                                    <td></td>
                                    <td></td>
                                    <td>BEGINNER FOUNDATION<br><small>Jennifer Lee</small></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>CALISTHENICS<br><small>Alex Morgan</small></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Tuesday</th>
                                    <td></td>
                                    <td>HIIT & CIRCUIT<br><small>David Rodriguez</small></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>ENDURANCE TRAINING<br><small>Marcus Johnson</small></td>
                                    <td></td>
                                    <td>WEIGHT LOSS<br><small>Alex Morgan</small></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Wednesday</th>
                                    <td></td>
                                    <td></td>
                                    <td>YOGA & MOBILITY<br><small>Sarah Chen</small></td>
                                    <td></td>
                                    <td></td>
                                    <td>NUTRITION COACHING<br><small>Jennifer Lee</small></td>
                                    <td></td>
                                    <td></td>
                                    <td>MUSCLE BUILDING<br><small>Alex Morgan</small></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Thursday</th>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>SENIOR FITNESS<br><small>Sarah Chen</small></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>STRENGTH TRAINING<br><small>David Rodriguez</small></td>
                                </tr>
                                <tr>
                                    <th>Friday</th>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>TEEN FITNESS<br><small>Jennifer Lee</small></td>
                                    <td>ATHLETIC PERFORMANCE<br><small>Marcus Johnson</small></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>                    
                </div>
            </div>

            <div class="trainers">
                <div class="trainers-header">
                    <h1><span class="material-symbols-outlined">exercise</span>My Trainers</h1>
                </div>
                <div class="trainers-bottom">
                    <div class="my-trainers-section">
                        <div class="section-header">
                            <h3><span class="material-symbols-outlined">groups</span>My Active Trainers</h3>
                        </div>
                        <?php 
                        $enrollments_query = mysqli_query($conn, "SELECT * FROM trainers t, member_programs e, programs p 
                            WHERE e.member_id = $id AND e.program_id = p.program_id AND p.trainer_id = t.trainer_id
                            ORDER BY e.enrollment_date DESC");

                        if(mysqli_num_rows($enrollments_query) == 0) { ?>
                        <div class="no-enrollments" id="noEnrollmentsMessage">
                            <div class="empty-state">
                                <span class="material-symbols-outlined">personal_injury</span>
                                <h3>No Active Trainers</h3>
                                <p>Book a session with our expert trainers to get personalized guidance!</p>
                            </div>
                        </div>
                        <?php } else { ?>
                        <div class="trainers-container">
                        <?php while($enrollment = mysqli_fetch_array($enrollments_query)) { ?>
                            <div class="enrollment-card">
                                <div class="card-header">
                                    <div class="program-icon">
                                        <span class="material-symbols-outlined">account_circle</span>
                                    </div>
                  
                                    <h3 class="program-name"><?php echo $enrollment['first_name']." ".$enrollment['last_name']; ?></h3>
                                </div>
                                
                                <div class="card-content">
                                    <div class="schedule-info">
                                        <div class="info-item">
                                            <span class="material-symbols-outlined icon">stars</span>
                                            <div class="info-details">
                                                <span class="label">Specialization</span>
                                                <span class="value"><?php echo $enrollment['specialization']; ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="info-item">
                                            <span class="material-symbols-outlined icon">schedule</span>
                                            <div class="info-details">
                                                <span class="label">Next Session</span>
                                                <span class="value"><?php echo $enrollment['schedule_day'].", ".date("g:i A", strtotime($enrollment['schedule_time']));  ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="sessions-section">
                        <div class="section-header">
                            <h3><span class="material-symbols-outlined">calendar_clock</span> Upcoming Sessions</h3>
                            <a href="member.php?nav=programs" class="book-new">
                                <span class="material-symbols-outlined">add</span>Book New
                            </a>
                        </div>
                        <div class="sessions-list">
                            <?php $enrollments_query = mysqli_query($conn, "SELECT * FROM trainers t, member_programs e, programs p 
                            WHERE e.member_id = $id AND e.program_id = p.program_id AND p.trainer_id = t.trainer_id
                            ORDER BY e.enrollment_date DESC");

                            while($enrollment = mysqli_fetch_array($enrollments_query)) { ?>
                            <form action="member.php" method="post">
                                <div class="session-item">
                                    <div class="session-time">
                                        <span class="day"><?php echo date("D", strtotime($enrollment['schedule_day'])); ?></span>
                                        <span class="time"><?php echo date("g:i A", strtotime($enrollment['schedule_time'])); ?></span>
                                    </div>
                                    <div class="session-details">
                                        <h4><?php echo $enrollment['program_name']; ?></h4>
                                        <p>With <?php echo $enrollment['first_name']." ".$enrollment['last_name']; ?></p>
                                    </div>
                                    <button type="submit" class="cancel-btn" name="cancel" value="<?php echo $enrollment['enrollment_id']; ?>">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>