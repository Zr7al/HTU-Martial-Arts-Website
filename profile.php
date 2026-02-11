<?php

session_start();
include 'db.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$msg = "";
$msgType = "";


if (isset($_POST['update_password'])) {
    $current_pass = $_POST['current_password'];
    $new_pass = $_POST['new_password'];
    
    
    $q = mysqli_query($conn, "SELECT password FROM users WHERE id='$userId'");
    $userRow = mysqli_fetch_array($q);
    
    if (password_verify($current_pass, $userRow['password'])) {
        $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users SET password='$new_hash' WHERE id='$userId'");
        $msg = "Password updated successfully.";
        $msgType = "success";
    } else {
        $msg = "Incorrect current password.";
        $msgType = "danger";
    }
}


$userQuery = "SELECT users.*, memberships.title as plan_name 
              FROM users 
              LEFT JOIN memberships ON users.membership_id = memberships.id 
              WHERE users.id = '$userId'";
$userResult = mysqli_query($conn, $userQuery);
$user = mysqli_fetch_array($userResult);
$fullName = htmlspecialchars($user['full_name']);
$email = htmlspecialchars($user['email']);
$planName = $user['plan_name'];
$planLabel = $planName ? $planName . " Member" : "No Active Membership";


$classQuery = "SELECT classes.name, classes.day_of_week, classes.start_time, instructors.name as coach, booking.booking_date 
               FROM booking 
               JOIN classes ON booking.class_id = classes.ID 
               JOIN instructors ON classes.instructor_id = instructors.id 
               WHERE booking.user_id = '$userId' 
               ORDER BY FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), start_time";
$classResult = mysqli_query($conn, $classQuery);


$serviceQuery = "SELECT * FROM service_bookings WHERE user_id = '$userId' ORDER BY booking_date DESC";
$serviceResult = mysqli_query($conn, $serviceQuery);
?>
<?php
$pageTitle = 'My Profile | HTU Martial Arts';
include 'header.php';
?>
<body>

<?php include 'navbar.php'; ?>

<div class="u-container u-mt-5 u-mb-5">
    
    <div class="u-row u-mb-4">
        <div class="u-col-md-8 u-mx-auto">
            <div class="dashboard-card border-gold u-text-center u-p-5">
                <div class="u-mb-3">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($fullName) ?>&background=d4af37&color=000&size=128" class="u-rounded-circle u-shadow u-border u-border-warning" width="100" height="100" alt="Profile">
                </div>
                <h2 class="text-gold u-fw-bold u-mb-0"><?= $fullName ?></h2>
                <p class="u-text-secondary u-mb-3"><?= $email ?></p>
                <span class="tag bg-gold u-text-dark u-fs-6 u-px-4 u-py-2 u-rounded-pill">
                    <?= $planLabel ?>
                </span>
                <?php if($msg): ?>
                    <div class="notice notice--<?= $msgType ?> u-mt-3"><?= $msg ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="u-row u-g-4">
        
        <div class="u-col-lg-7">
            <div class="dashboard-card u-h-100">
                <h4 class="u-text-white u-border-bottom u-border-secondary u-pb-3 u-mb-4">MY CLASS SCHEDULE</h4>
                <?php if (mysqli_num_rows($classResult) > 0): ?>
                    <div class="table-wrap">
                        <table class="data-table">
                            <thead>
                                <tr class="text-gold">
                                    <th>Day</th>
                                    <th>Class</th>
                                    <th>Time</th>
                                    <th>Coach</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_array($classResult)): ?>
                                <?php
                                $day = $row['day_of_week'];
                                $className = $row['name'];
                                $classTime = date("H:i", strtotime($row['start_time']));
                                $coachName = $row['coach'];
                                ?>
                                <tr>
                                    <td class="u-fw-bold"><?= $day ?></td>
                                    <td><?= $className ?></td>
                                    <td><?= $classTime ?></td>
                                    <td><small class="u-text-secondary"><?= $coachName ?></small></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="u-text-center u-py-5 u-text-secondary">
                        <i class="fa-regular fa-calendar-xmark u-fs-1 u-mb-3"></i>
                        <p>No classes booked yet.</p>
                        <a href="classes.php" class="btn-outline-custom btn-small">View Timetable</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="u-col-lg-5">
            
            <div class="dashboard-card u-mb-4">
                <h5 class="text-gold u-mb-3"><i class="fas fa-lock u-me-2"></i>SECURITY SETTINGS</h5>
                <form method="POST">
                    <div class="u-mb-2">
                        <input type="password" name="current_password" class="custom-input" placeholder="Current Password" required>
                    </div>
                    <div class="u-mb-3">
                        <input type="password" name="new_password" class="custom-input" placeholder="New Password" required>
                    </div>
                    <button type="submit" name="update_password" class="btn-ghost-light btn-small u-w-100">Update Password</button>
                </form>
            </div>

            <div class="dashboard-card">
                <h5 class="u-text-white u-border-bottom u-border-secondary u-pb-3 u-mb-4">PURCHASE HISTORY</h5>
                <?php if (mysqli_num_rows($serviceResult) > 0): ?>
                    <ul class="list-stack">
                        <?php while($row = mysqli_fetch_array($serviceResult)): ?>
                        <?php
                        $serviceName = $row['service_name'];
                        $serviceDate = date("M d, Y", strtotime($row['booking_date']));
                        $servicePrice = number_format($row['price'], 2);
                        ?>
                        <li class="list-stack-item u-text-white u-border-secondary u-d-flex u-justify-content-between u-align-items-center u-px-0 u-py-3">
                            <div>
                                <div class="u-fw-bold u-mb-1"><?= $serviceName ?></div>
                                <small class="u-text-secondary"><i class="fa-regular fa-clock u-me-1"></i> <?= $serviceDate ?></small>
                            </div>
                            <span class="text-gold u-fw-bold"><?= $servicePrice ?> JD</span>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <div class="u-text-center u-py-4 u-text-secondary">
                        <p>No purchases yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




