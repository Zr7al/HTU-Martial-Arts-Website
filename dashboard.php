<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$role = 'Member';
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
}
$name = 'Fighter';
if (isset($_SESSION['name'])) {
    $name = $_SESSION['name'];
}
?>
<?php
$pageTitle = 'Dashboard | HTU Martial Arts';
include 'header.php';
?>
<body>

<?php include 'navbar.php'; ?>

<div class="u-container section-padding">
    
    <div class="u-row u-align-items-end u-mb-5">
        <div class="u-col-md-8">
            <span class="tag bg-gold u-text-dark u-mb-2">Active Member</span>
            <h1 class="u-display-4 u-fw-bold">WELCOME BACK, <span class="text-gold"><?= htmlspecialchars($name); ?></span></h1>
            <p class="u-text-secondary u-lead">Manage your training, schedule, and profile.</p>
        </div>
        <div class="u-col-md-4 u-text-md-end">
            <p class="u-text-secondary u-text-uppercase u-small">Account Role: <span class="u-text-white u-fw-bold"><?= ucfirst($role); ?></span></p>
        </div>
    </div>

    <div class="u-row u-g-4 u-mb-5">
        
        <div class="u-col-md-4">
            <div class="dashboard-card u-d-flex u-flex-column u-justify-content-between">
                <div>
                    <i class="fa-solid fa-medal text-gold u-fs-2 u-mb-3"></i>
                    <h4>MEMBERSHIP</h4>
                    <p class="u-text-secondary u-small">Check your current plan status or upgrade.</p>
                </div>
                <a href="pricing.php" class="btn-gold u-mt-3 u-text-center">Manage Plan</a>
            </div>
        </div>

        <div class="u-col-md-4">
            <div class="dashboard-card u-d-flex u-flex-column u-justify-content-between">
                <div>
                    <i class="fa-solid fa-calendar-days text-gold u-fs-2 u-mb-3"></i>
                    <h4>TIMETABLE</h4>
                    <p class="u-text-secondary u-small">Book BJJ, MMA, and Kickboxing sessions.</p>
                </div>
                <a href="classes.php" class="btn-outline-custom u-mt-3 u-text-center">View Schedule</a>
            </div>
        </div>

        <div class="u-col-md-4">
            <div class="dashboard-card u-d-flex u-flex-column u-justify-content-between">
                <div>
                    <i class="fa-solid fa-user-ninja text-gold u-fs-2 u-mb-3"></i>
                    <h4>MY PROFILE</h4>
                    <p class="u-text-secondary u-small">Update stats and view booking history.</p>
                </div>
                <a href="profile.php" class="btn-outline-custom u-mt-3 u-text-center">Edit Profile</a>
            </div>
        </div>
    </div>

    <div class="u-border-top u-border-secondary u-pt-5">
        <h2 class="u-text-white u-mb-4"><span class="text-gold">HTU</span> FACILITIES</h2>
        <div class="u-row u-g-3">
            <div class="u-col-md-8">
                <div class="facility-card facility-card--tall">
                    <img src="assets/images/Benefits-of-Tatami-Mats-01.jpg" class="facility-img" alt="Dojo">
                    <div class="facility-overlay">
                        <h4 class="text-gold u-mb-0">THE COMBAT ZONE</h4>
                        <p class="u-text-white u-small u-mb-0">Large, professional matted martial arts area.</p>
                    </div>
                </div>
            </div>
            
            <div class="u-col-md-4">
                <div class="facility-card facility-card--tall">
                    <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=800" class="facility-img" alt="Gym">
                    <div class="facility-overlay">
                        <h4 class="text-gold u-mb-0">IRON PARADISE</h4>
                        <p class="u-text-white u-small u-mb-0">Fully-equipped strength & conditioning gym.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




