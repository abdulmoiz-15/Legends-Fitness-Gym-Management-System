<?php
if(isset($_GET['logout'])){
    session_destroy();
    header('location:index.php');
    exit();
}

session_start();
include('connection.php');
if(!isset($_SESSION['admin_id'])){
    header('location: signin.php');
    exit();
} 

$id=$_SESSION['admin_id'];

if(!isset($_GET['nav'])){
    header('location:admin.php?nav=dashboard');
}

$earnings_query=mysqli_query($conn,"SELECT sum(p.price) as SUM from plans p join member_plans mp on p.plan_id=mp.plan_id");
$earnings=mysqli_fetch_array($earnings_query);
$earned=$earnings['SUM'];

$count_query = mysqli_query($conn, "SELECT 
    (SELECT COUNT(*) FROM members) as total_members,
    (SELECT COUNT(*) FROM trainers) as total_trainers,
    (SELECT COUNT(*) FROM programs) as total_programs;");
$count=mysqli_fetch_array($count_query);

$new_member_query=mysqli_query($conn,"SELECT concat(m.first_name,' ',m.last_name) as name, min(mp.start_date) as joined 
    FROM members m, member_plans mp 
    WHERE m.member_id = mp.member_id group by m.member_id;");    

$member_query=mysqli_query($conn,"SELECT m.member_id, concat(m.first_name,' ',m.last_name) as name, m.email, m.phone_no,
    p.plan_name, mp.start_date, mp.status FROM members m
    JOIN member_plans mp ON m.member_id = mp.member_id
    JOIN plans p ON mp.plan_id = p.plan_id
    WHERE mp.start_date = (
    SELECT MIN(start_date) 
    FROM member_plans 
    WHERE member_id = m.member_id)");

$programs_query=mysqli_query($conn,"SELECT p.*, CONCAT(t.first_name, ' ', t.last_name) as trainer_name
    FROM programs p JOIN trainers t ON p.trainer_id = t.trainer_id order by program_id;");

$trainers_query=mysqli_query($conn,"SELECT*from trainers");

$membership_query=mysqli_query($conn,"SELECT p.*, count(mp.plan_id) as activeMembers 
    from plans p left join member_plans mp on 
    p.plan_id=mp.plan_id and mp.status='Active' and mp.member_id>0 group by p.plan_id;");

$requests_query = mysqli_query($conn, "SELECT a.* FROM requests a where a.updated_at=
    (SELECT max(updated_at) from requests b where b.member_id=a.member_id)");   

//ADD AND UPDATE
if(isset($_POST['submit'])) {
    $action = $_POST['action']; // 'add' or 'update'
    $type = $_POST['type'];
    
    if($type == 'program') {
        $program_name = $_POST['program_name'];
        $schedule_day = $_POST['schedule_day'];
        $schedule_time = $_POST['schedule_time'];
        $duration = $_POST['duration'] . " Weeks";
        $level = $_POST['level'];
        $group_size = $_POST['group_size'];
        $trainer_id = $_POST['trainer_id'];
        
        if($action == 'add') {
            $query = mysqli_query($conn,
                "INSERT INTO programs (program_name, schedule_day, schedule_time, duration, level, group_size, trainer_id) 
                 VALUES ('$program_name', '$schedule_day', '$schedule_time', '$duration', '$level', '$group_size', '$trainer_id')");
        } else {
            $id = $_POST['id'];
            $query = mysqli_query($conn,
                "UPDATE programs SET 
                program_name='$program_name', 
                schedule_day='$schedule_day', 
                schedule_time='$schedule_time', 
                duration='$duration', 
                level='$level', 
                group_size='$group_size', 
                trainer_id='$trainer_id' 
                WHERE program_id='$id'");
        }
        header('location:admin.php?nav=program');
        exit();
    }
    
    else if($type == 'member') {
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];       
        $email = $_POST['email'];
        $phoneNo = $_POST['phone_no'];
        $id = $_POST['id'];
        $query = mysqli_query($conn,
            "UPDATE members SET 
            first_name='$firstName', 
            last_name='$lastName', 
            email='$email', 
            phone_no='$phoneNo' 
            WHERE member_id='$id'");
        header('location:admin.php?nav=member');
        exit();
    }
    
    else if($type == 'trainer') {
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];       
        $email = $_POST['email'];
        $phoneNo = $_POST['phone_no'];
        $specialization = $_POST['specialization'];
        
        if($action == 'add') {
            $query = mysqli_query($conn,
                "INSERT INTO trainers (first_name, last_name, email, phone_no, specialization) 
                 VALUES ('$firstName', '$lastName', '$email', '$phoneNo', '$specialization')");
        } else {
            $id = $_POST['id'];
            $query = mysqli_query($conn,
                "UPDATE trainers SET 
                first_name='$firstName', 
                last_name='$lastName', 
                email='$email', 
                phone_no='$phoneNo', 
                specialization='$specialization' 
                WHERE trainer_id='$id'");
        }
        header('location:admin.php?nav=trainer');
        exit();
    }
    
    else if($type == 'plan') {
        $plan_name = $_POST['plan_name'];
        $price = $_POST['price'];
        $duration = $_POST['duration'];
        
        if($action == 'add') {
            $query = mysqli_query($conn,
                "INSERT INTO plans (plan_name, price, duration) 
                 VALUES ('$plan_name', '$price', '$duration')");
        } else {
            $id = $_POST['id'];
            $query = mysqli_query($conn,
                "UPDATE plans SET 
                plan_name='$plan_name', 
                price='$price', 
                duration='$duration' 
                WHERE plan_id='$id'");
        }
        header('location:admin.php?nav=plan');
        exit();
    }
}

// DELETE
if(isset($_GET['del']) && isset($_GET['type'])) {
    $del_id = $_GET['del'];
    $type = $_GET['type'];
    
    if($type == 'member') {
        $delete_query = mysqli_query($conn, "DELETE FROM members WHERE member_id='$del_id'");
        header('location:admin.php?nav=member');
        exit();
    } 
    
    else if($type == 'program') {
        $delete_query = mysqli_query($conn, "DELETE FROM programs WHERE program_id='$del_id'");
        header('location:admin.php?nav=program');
        exit();
    } 
    
    else if($type == 'trainer') {
        $delete_query = mysqli_query($conn, "DELETE FROM trainers WHERE trainer_id='$del_id'");
        header('location:admin.php?nav=trainer');
        exit();
    } 
    
    else if($type == 'plan') {
        $delete_query = mysqli_query($conn, "DELETE FROM plans WHERE plan_id='$del_id'");
        header('location:admin.php?nav=plan');
        exit();
    } 
    
    else if($type == 'request') {
        $delete_query = mysqli_query($conn, "DELETE FROM requests WHERE request_id='$del_id'");
        header('location:admin.php?nav=request');
        exit();
    }
}

// APPROVE
if(isset($_GET['approve'])) {
    $approve_id = $_GET['approve'];
    $memberid=$_GET['memberid'];
    $approve_query = mysqli_query($conn, "UPDATE requests SET status='approved' WHERE request_id='$approve_id' and member_id='$memberid'");
    header('location:admin.php?nav=request');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Legends Fitness</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=New+Amsterdam&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>
<body>
    <input type="checkbox" id="menu">
    <main>
        <input type="radio" id="dashboard" class="options" name="nav" <?php echo (isset($_GET['nav']) && $_GET['nav']=='dashboard')?'checked':''; ?>>
        <input type="radio" id="manageMembers" class="options" name="nav" <?php echo (isset($_GET['nav']) && $_GET['nav']=='member')?'checked':''; ?>>
        <input type="radio" id="managePrograms" class="options" name="nav" <?php echo (isset($_GET['nav']) && $_GET['nav']=='program')?'checked':''; ?>>
        <input type="radio" id="manageTrainers" class="options" name="nav" <?php echo (isset($_GET['nav']) && $_GET['nav']=='trainer')?'checked':''; ?>>
        <input type="radio" id="manageMemberships" class="options" name="nav" <?php echo (isset($_GET['nav']) && $_GET['nav']=='plan')?'checked':''; ?>>
        <input type="radio" id="manageRequests" class="options" name="nav" <?php echo (isset($_GET['nav']) && $_GET['nav']=='request')?'checked':''; ?>>
        
        <div class="left-sec">
            <label id="top-icon" for="menu">
                <span id="menu-icon" class="material-symbols-outlined">left_panel_open</span>
                <div class="logo"><img src="pics/LEGEDS_FITNESS2-removebg-preview.png" alt="Legends Fitness" id="logo"></div>
            </label>
            <label for="dashboard"><span class="material-symbols-outlined">dashboard</span><p>DASHBOARD</p></label>
            <label for="manageMembers"><span class="material-symbols-outlined">group</span><p>MANAGE MEMBERS</p></label>
            <label for="managePrograms"><span class="material-symbols-outlined">fitness_center</span><p>MANAGE PROGRAMS</p></label>
            <label for="manageTrainers"><span class="material-symbols-outlined">person</span><p>MANAGE TRAINERS</p></label>
            <label for="manageMemberships"><span class="material-symbols-outlined">payments</span><p>MANAGE MEMBERSHIPS</p></label>
            <label for="manageRequests"><span class="material-symbols-outlined">person_alert</span><p>REQUESTS</p></label>
            <a href="index.php?logout=1" id="bottom-icon"><span class="material-symbols-outlined">logout</span><p>LOGOUT</p></a>
        </div>
        
        <div class="right-sec">
            <!-- DASHBOARD SECTION -->
            <div class="dashboard">
                <div class="dashboard-header">
                    <h1><span class="material-symbols-outlined">dashboard</span> ADMIN DASHBOARD</h1>
                    <div class="header-top">
                        <h2>Welcome, <span class="admin-name">Admin!</span></h2>
                        <span class="current-date" id="currentDate"></span>
                    </div>
                </div>

                <div class="stats-cards">
                    <div class="stat-card">
                        <div class="card-icon">
                            <span class="material-symbols-outlined">attach_money</span>
                        </div>
                        <div class="card-content">
                            <h4>Total Earnings</h4>
                            <p class="stat-value">$
                                <?php echo $earned; ?>
                            </p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="card-icon">
                            <span class="material-symbols-outlined">group</span>
                        </div>
                        <div class="card-content">
                            <h4>Total Members</h4>
                            <p class="stat-value">
                                <?php echo $count['total_members']; ?>
                            </p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="card-icon">
                            <span class="material-symbols-outlined">person</span>
                        </div>
                       <div class="card-content">
                            <h4>Total Trainers</h4>
                            <p class="stat-value">
                                <?php echo $count['total_trainers']; ?>
                            </p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="card-icon">
                            <span class="material-symbols-outlined">fitness_center</span>
                        </div>
                        <div class="card-content">
                            <h4>Active Programs</h4>
                            <p class="stat-value">
                                <?php echo $count['total_programs']; ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="recent-activity">
                    <h2><span class="material-symbols-outlined">history</span> Recent Activity</h2>
                    <div class="activity-list">
                        <?php while($new_members=mysqli_fetch_array($new_member_query)){ ?>
                        <div class="activity-item">
                            <span class="material-symbols-outlined">person_add</span>
                            <div class="activity-details">
                                <p>New member: <?php echo $new_members['name'] ?> registered</p>
                                <span class="activity-time">
                                <?php    
                                $joined_at = round((time() - strtotime($new_members['joined'])) / 3600,1);
                                    if($joined_at < 1) {
                                        $minutes = round($joined_at * -1);
                                        echo $minutes. " min ago";
                                    } elseif($joined_at < 24 && $joined_at >= 1) {
                                        echo $joined_at . " hrs ago";
                                    } else {
                                        $days = floor($joined_at / 24);
                                        echo $days . " days ago";
                                    } ?>
                                </span>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            
            <!-- MANAGE MEMBERS SECTION -->
            <div class="manage-section">
                <div class="section-header">
                    <h1><span class="material-symbols-outlined">group</span> MANAGE MEMBERS</h1>
                </div>
                
                <!-- SINGLE FORM FOR BOTH ADD AND EDIT -->
                <?php if(isset($_GET['action']) && $_GET['type'] == 'member'): ?>
                <?php
                $is_edit = isset($_GET['edit']);
                $id = $is_edit ? $_GET['edit'] : '';
                
                // Fetch data if editing
                if($is_edit) {
                    $query = mysqli_query($conn, "SELECT * FROM members WHERE member_id='$id'");
                    $data = mysqli_fetch_array($query);
                }
                ?>
                
                <div class="edit-box">
                    <form action="admin.php?nav=member" method="POST" class="edit-form">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="type" value="member">
                        
                        <div class="edit-form-row">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" 
                                    value="<?php echo $data['first_name']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" 
                                    value="<?php echo $data['last_name']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="edit-form-row">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" 
                                    value="<?php echo $data['email']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="phone_no">Phone Number</label>
                                <input type="tel" id="phone_no" name="phone_no" 
                                    value="<?php echo $data['phone_no']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="edit-form-actions">
                            <button type="submit" name="submit" class="btn-save">
                                <span class="material-symbols-outlined">save</span>
                                Update Member
                            </button>
                            <a href="admin.php?nav=member" class="btn-cancel">
                                <span class="material-symbols-outlined">close</span> Cancel
                            </a>
                        </div>
                    </form>
                </div>
                <?php endif; ?>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Member ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Membership Plan</th>
                                <th>Status</th>
                                <th>Join Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($members=mysqli_fetch_array($member_query)){ ?>
                            <tr>
                                <td><?php echo $members['member_id']; ?></td>
                                <td><?php echo $members['name']; ?></td>
                                <td><?php echo $members['email']; ?></td>
                                <td><?php echo $members['phone_no']; ?></td>
                                <td><?php echo $members['plan_name']; ?></td>
                                <td><span class="status-badge <?php echo $members['status']; ?>"><?php echo $members['status']; ?></span></td>
                                <td><?php echo date("F j, Y", strtotime($members['start_date'])); ?></td>
                                <td class="action-buttons">
                                    <a href="admin.php?nav=member&action=add&type=member&edit=<?php echo $members['member_id']; ?>" class="edit-btn">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>
                                    <a href="admin.php?nav=member&type=member&del=<?php echo $members['member_id']; ?>" class="delete-btn">
                                        <span class="material-symbols-outlined">delete</span>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MANAGE PROGRAMS SECTION -->
            <div class="manage-section">
                <div class="section-header">
                    <h1><span class="material-symbols-outlined">fitness_center</span> MANAGE PROGRAMS</h1>
                    <div class="section-actions">
                        <a href="admin.php?nav=program&action=add&type=program" class="add-btn">
                            <span class="material-symbols-outlined">add</span>
                            Add New Program
                        </a>
                    </div>
                </div>
                
                <!-- SINGLE FORM FOR BOTH ADD AND EDIT -->
                <?php if(isset($_GET['action']) && $_GET['type'] == 'program'): ?>
                <?php
                $is_edit = isset($_GET['edit']);
                $id = $is_edit ? $_GET['edit'] : '';
                
                // Fetch data if editing
                if($is_edit) {
                    $query = mysqli_query($conn, "SELECT * FROM programs WHERE program_id='$id'");
                    $data = mysqli_fetch_array($query);
                }
                
                // Get trainers for dropdown
                $trainers_dropdown = mysqli_query($conn, "SELECT * FROM trainers");
                ?>
                
                <div class="edit-box">
                    <form action="admin.php?nav=program" method="POST" class="edit-form">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="action" value="<?php echo $is_edit ? 'update' : 'add'; ?>">
                        <input type="hidden" name="type" value="program">
                        
                        <div class="edit-form-row">
                            <div class="form-group">
                                <label for="program_name">Program Name</label>
                                <input type="text" id="program_name" name="program_name" 
                                       value="<?php echo $is_edit ? $data['program_name'] : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="duration">Duration (Weeks)</label>
                                <input type="number" id="duration" name="duration" 
                                       value="<?php echo $is_edit ? str_replace(' Weeks', '', $data['duration']) : ''; ?>" required>
                            </div>
                        </div>
                        
                        <div class="edit-form-row">
                            <div class="form-group">
                                <label for="schedule_day">Schedule Day</label>
                                <select id="schedule_day" name="schedule_day" required>
                                    <option value="Monday" <?php echo ($is_edit && $data['schedule_day'] == 'Monday') ? 'selected' : ''; ?>>Monday</option>
                                    <option value="Tuesday" <?php echo ($is_edit && $data['schedule_day'] == 'Tuesday') ? 'selected' : ''; ?>>Tuesday</option>
                                    <option value="Wednesday" <?php echo ($is_edit && $data['schedule_day'] == 'Wednesday') ? 'selected' : ''; ?>>Wednesday</option>
                                    <option value="Thursday" <?php echo ($is_edit && $data['schedule_day'] == 'Thursday') ? 'selected' : ''; ?>>Thursday</option>
                                    <option value="Friday" <?php echo ($is_edit && $data['schedule_day'] == 'Friday') ? 'selected' : ''; ?>>Friday</option>
                                    <option value="Saturday" <?php echo ($is_edit && $data['schedule_day'] == 'Saturday') ? 'selected' : ''; ?>>Saturday</option>
                                    <option value="Sunday" <?php echo ($is_edit && $data['schedule_day'] == 'Sunday') ? 'selected' : ''; ?>>Sunday</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="schedule_time">Schedule Time</label>
                                <input type="time" id="schedule_time" name="schedule_time" 
                                       value="<?php echo $is_edit ? date('H:i', strtotime($data['schedule_time'])) : ''; ?>" required>
                            </div>
                        </div>
                        
                        <div class="edit-form-row">
                            <div class="form-group">
                                <label for="level">Level</label>
                                <select id="level" name="level" required>
                                    <option value="Beginner" <?php echo ($is_edit && $data['level'] == 'Beginner') ? 'selected' : ''; ?>>Beginner</option>
                                    <option value="Intermediate" <?php echo ($is_edit && $data['level'] == 'Intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                                    <option value="Advanced" <?php echo ($is_edit && $data['level'] == 'Advanced') ? 'selected' : ''; ?>>Advanced</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="group_size">Group Size</label>
                                <select id="group_size" name="group_size" required>
                                    <option value="Small (5-8)" <?php echo ($is_edit && $data['group_size'] == 'Small (5-8)') ? 'selected' : ''; ?>>Small (5-8)</option>
                                    <option value="Medium (8-12)" <?php echo ($is_edit && $data['group_size'] == 'Medium (8-12)') ? 'selected' : ''; ?>>Medium (8-12)</option>
                                    <option value="Large (12-15)" <?php echo ($is_edit && $data['group_size'] == 'Large (12-15)') ? 'selected' : ''; ?>>Large (12-15)</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="edit-form-row">
                            <div class="form-group">
                                <label for="trainer_id">Trainer</label>
                                <select id="trainer_id" name="trainer_id" required>
                                    <option value="">Select Trainer</option>
                                    <?php while($trainer = mysqli_fetch_array($trainers_dropdown)): ?>
                                    <option value="<?php echo $trainer['trainer_id']; ?>" 
                                        <?php echo ($is_edit && $data['trainer_id'] == $trainer['trainer_id']) ? 'selected' : ''; ?>>
                                        <?php echo $trainer['first_name'] . ' ' . $trainer['last_name']; ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="edit-form-actions">
                            <button type="submit" name="submit" class="btn-save">
                                <span class="material-symbols-outlined"><?php echo $is_edit ? 'save' : 'add'; ?></span>
                                <?php echo $is_edit ? 'Update Program' : 'Add Program'; ?>
                            </button>
                            <a href="admin.php?nav=program" class="btn-cancel">
                                <span class="material-symbols-outlined">close</span> Cancel
                            </a>
                        </div>
                    </form>
                </div>
                <?php endif; ?>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Program ID</th>
                                <th>Program Name</th>
                                <th>Trainer</th>
                                <th>Schedule Day</th>
                                <th>Schedule Time</th>
                                <th>Duration</th>
                                <th>Level</th>
                                <th>Group Size</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Reset the query pointer
                            mysqli_data_seek($programs_query, 0);
                            while($programs=mysqli_fetch_array($programs_query)){ ?>
                            <tr>
                                <td><?php echo $programs['program_id']; ?></td>
                                <td><?php echo $programs['program_name']; ?></td>
                                <td><?php echo $programs['trainer_name']; ?></td>
                                <td><?php echo $programs['schedule_day']; ?></td>
                                <td><?php echo date("h:i A", strtotime($programs['schedule_time'])); ?></td>
                                <td><?php echo $programs['duration']; ?></td>
                                <td><?php echo $programs['level']; ?></td>
                                <td><?php echo $programs['group_size']; ?></td>
                                <td class="action-buttons">
                                    <a href="admin.php?nav=program&action=add&type=program&edit=<?php echo $programs['program_id']; ?>" class="edit-btn">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>
                                    <a href="admin.php?nav=program&type=program&del=<?php echo $programs['program_id']; ?>" class="delete-btn">
                                        <span class="material-symbols-outlined">delete</span>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MANAGE TRAINERS SECTION -->
            <div class="manage-section">
                <div class="section-header">
                    <h1><span class="material-symbols-outlined">person</span> MANAGE TRAINERS</h1>
                    <div class="section-actions">
                        <a href="admin.php?nav=trainer&action=add&type=trainer" class="add-btn">
                            <span class="material-symbols-outlined">person_add</span>
                            Add New Trainer
                        </a>
                    </div>
                </div>
                
                <!-- SINGLE FORM FOR BOTH ADD AND EDIT -->
                <?php if(isset($_GET['action']) && $_GET['type'] == 'trainer'): ?>
                <?php
                $is_edit = isset($_GET['edit']);
                $id = $is_edit ? $_GET['edit'] : '';
                
                // Fetch data if editing
                if($is_edit) {
                    $query = mysqli_query($conn, "SELECT * FROM trainers WHERE trainer_id='$id'");
                    $data = mysqli_fetch_array($query);
                }
                ?>
                
                <div class="edit-box">
                    <form action="admin.php?nav=trainer" method="POST" class="edit-form">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="action" value="<?php echo $is_edit ? 'update' : 'add'; ?>">
                        <input type="hidden" name="type" value="trainer">
                        
                        <div class="edit-form-row">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" 
                                       value="<?php echo $is_edit ? $data['first_name'] : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" 
                                       value="<?php echo $is_edit ? $data['last_name'] : ''; ?>" required>
                            </div>
                        </div>
                        
                        <div class="edit-form-row">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" 
                                       value="<?php echo $is_edit ? $data['email'] : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="phone_no">Phone Number</label>
                                <input type="tel" id="phone_no" name="phone_no" 
                                       value="<?php echo $is_edit ? $data['phone_no'] : ''; ?>" required>
                            </div>
                        </div>
                        
                        <div class="edit-form-row">
                            <div class="form-group">
                                <label for="specialization">Specialization</label>
                                <input type="text" id="specialization" name="specialization" 
                                       value="<?php echo $is_edit ? $data['specialization'] : ''; ?>" required>
                            </div>
                        </div>
                        
                        <div class="edit-form-actions">
                            <button type="submit" name="submit" class="btn-save">
                                <span class="material-symbols-outlined"><?php echo $is_edit ? 'save' : 'add'; ?></span>
                                <?php echo $is_edit ? 'Update Trainer' : 'Add Trainer'; ?>
                            </button>
                            <a href="admin.php?nav=trainer" class="btn-cancel">
                                <span class="material-symbols-outlined">close</span> Cancel
                            </a>
                        </div>
                    </form>
                </div>
                <?php endif; ?>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Trainer ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Specialization</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Reset the query pointer
                            mysqli_data_seek($trainers_query, 0);
                            while($trainers=mysqli_fetch_array($trainers_query)){ ?>
                            <tr>
                                <td><?php echo $trainers['trainer_id']; ?></td>
                                <td><?php echo $trainers['first_name']." ".$trainers['last_name']; ?></td>
                                <td><?php echo $trainers['email']; ?></td>
                                <td><?php echo $trainers['phone_no']; ?></td>
                                <td><?php echo $trainers['specialization']; ?></td>
                                <td class="action-buttons">
                                    <a href="admin.php?nav=trainer&action=add&type=trainer&edit=<?php echo $trainers['trainer_id']; ?>" class="edit-btn">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>
                                    <a href="admin.php?nav=trainer&type=trainer&del=<?php echo $trainers['trainer_id']; ?>" class="delete-btn">
                                        <span class="material-symbols-outlined">delete</span>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MANAGE MEMBERSHIPS SECTION -->
            <div class="manage-section">
                <div class="section-header">
                    <h1><span class="material-symbols-outlined">payments</span> MANAGE MEMBERSHIPS</h1>
                    <div class="section-actions">
                        <a href="admin.php?nav=plan&action=add&type=plan" class="add-btn">
                            <span class="material-symbols-outlined">add</span>
                            Add New Plan
                        </a>
                    </div>
                </div>
                
                <!-- SINGLE FORM FOR BOTH ADD AND EDIT -->
                <?php if(isset($_GET['action']) && $_GET['type'] == 'plan'): ?>
                <?php
                $is_edit = isset($_GET['edit']);
                $id = $is_edit ? $_GET['edit'] : '';
                
                // Fetch data if editing
                if($is_edit) {
                    $query = mysqli_query($conn, "SELECT * FROM plans WHERE plan_id='$id'");
                    $data = mysqli_fetch_array($query);
                }
                ?>
                
                <div class="edit-box">
                    <form action="admin.php?nav=plan" method="POST" class="edit-form">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="action" value="<?php echo $is_edit ? 'update' : 'add'; ?>">
                        <input type="hidden" name="type" value="plan">
                        
                        <div class="edit-form-row">
                            <div class="form-group">
                                <label for="plan_name">Plan Name</label>
                                <input type="text" id="plan_name" name="plan_name" 
                                       value="<?php echo $is_edit ? $data['plan_name'] : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Price ($)</label>
                                <input type="number" step="0.01" id="price" name="price" 
                                       value="<?php echo $is_edit ? $data['price'] : ''; ?>" required>
                            </div>
                        </div>
                        
                        <div class="edit-form-row">
                            <div class="form-group">
                                <label for="duration">Duration (months)</label>
                                <input type="number" id="duration" name="duration" 
                                       value="<?php echo $is_edit ? $data['duration'] : ''; ?>" required>
                            </div>
                        </div>
                        
                        <div class="edit-form-actions">
                            <button type="submit" name="submit" class="btn-save">
                                <span class="material-symbols-outlined"><?php echo $is_edit ? 'save' : 'add'; ?></span>
                                <?php echo $is_edit ? 'Update Plan' : 'Add Plan'; ?>
                            </button>
                            <a href="admin.php?nav=plan" class="btn-cancel">
                                <span class="material-symbols-outlined">close</span> Cancel
                            </a>
                        </div>
                    </form>
                </div>
                <?php endif; ?>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Plan ID</th>
                                <th>Plan Name</th>
                                <th>Price</th>
                                <th>Duration</th>
                                <th>Active Members</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Reset the query pointer
                            mysqli_data_seek($membership_query, 0);
                            while($memberships=mysqli_fetch_array($membership_query)){ ?>
                            <tr>
                                <td><?php echo $memberships['plan_id']; ?></td>
                                <td><?php echo $memberships['plan_name']; ?></td>
                                <td>$<?php echo $memberships['price']; ?></td>
                                <td><?php echo $memberships['duration']; ?></td>
                                <td><?php echo $memberships['activeMembers']; ?></td>
                                <td class="action-buttons">
                                    <a href="admin.php?nav=plan&action=add&type=plan&edit=<?php echo $memberships['plan_id']; ?>" class="edit-btn">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>
                                    <a href="admin.php?nav=plan&type=plan&del=<?php echo $memberships['plan_id']; ?>" class="delete-btn">
                                        <span class="material-symbols-outlined">delete</span>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MANAGE REQUESTS SECTION -->
            <div class="manage-section">
                <div class="section-header">
                    <h1><span class="material-symbols-outlined">person_raised_hand</span>PASSWORD RESET/CHANGE REQUESTS</h1>
                    <div class="section-actions">
                        <a href="admin.php?nav=request" class="add-btn" id="refreshRequests">
                            <span class="material-symbols-outlined">refresh</span>
                            Refresh
                        </a>
                    </div>
                </div>
                 <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>Member ID</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Request Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(mysqli_num_rows($requests_query) > 0) {
                                while($request = mysqli_fetch_array($requests_query)) {
                            ?>
                            <tr>
                                <td><?php echo $request['request_id']; ?></td>
                                <td><?php echo $request['member_id']; ?></td>
                                <td><?php echo $request['email']; ?></td>
                                <td><?php echo $request['message']; ?></td>
                                <td><?php echo date("d-m-Y h:00 A", strtotime($request['updated_at'])); ?></td>
                                <td>
                                    <span class="status-badge <?php echo strtolower($request['status']); ?>">
                                        <?php echo $request['status']; ?>
                                    </span>
                                </td>
                                  <td class="action-buttons">
                                    <?php if($request['status'] == 'pending') { ?>
                                    <a href="admin.php?nav=request&approve=<?php echo $request['request_id']; ?>&memberid=<?php echo $request['member_id']; ?>" class="approve-btn">
                                        <span class="material-symbols-outlined">check</span>
                                    </a>
                                    <?php } ?>
                                    <a href="admin.php?nav=request&type=request&del=<?php echo $request['request_id']; ?>" class="delete-btn">
                                        <span class="material-symbols-outlined">delete</span>
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                }
                            } else {
                            ?>
                            <tr>
                                <td colspan="8" class="no-data">
                                    <div class="empty-state">
                                        <span class="material-symbols-outlined">check_circle</span>
                                        <p>No pending requests</p>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</body>
</html>