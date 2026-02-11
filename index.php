<?php

session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>
<?php
$pageTitle = 'Home | HTU Martial Arts';
include 'header.php';
?>
<body>

<?php include 'navbar.php'; ?>


<section class="hero-home">
    <div class="u-container">
        <h1 class="hero-title">
            DISCIPLINE.<br>STRENGTH. HONOR.
        </h1>

        <p class="hero-subtitle">
            World-class martial arts training built on tradition, structure, and relentless improvement.
        </p>

        <div class="u-d-flex u-justify-content-center u-gap-3">
            <?php if (!$isLoggedIn): ?>
                <a href="register.php" class="btn-gold">JOIN THE CLUB</a>
                <a href="programs.php" class="btn-outline-custom">OUR PROGRAMS</a>
            <?php else: ?>
                <a href="dashboard.php" class="btn-gold">GO TO DASHBOARD</a>
            <?php endif; ?>
        </div>
    </div>
</section>


<section class="section-padding facilities-section">
    <div class="u-container">

        <div class="u-text-center u-mb-5">
            <h2 class="u-display-5 u-fw-bold">
                <span class="text-gold">HTU</span> Facilities
            </h2>
            <p class="u-text-muted">
                Designed for performance, discipline, and recovery.
            </p>
        </div>

        <div class="u-row u-g-4">
            <div class="u-col-md-8">
                <div class="facility-card">
                    <img src="assets/images/Benefits-of-Tatami-Mats-01.jpg" class="facility-img" alt="Tatami mats training area">
                    <div class="facility-overlay">
                        <h4 class="text-gold">Combat Zone</h4>
                        <p class="u-small">Professional matted training area</p>
                    </div>
                </div>
            </div>

            <div class="u-col-md-4">
                <div class="facility-card">
                    <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=800" class="facility-img" alt="Strength gym equipment">
                    <div class="facility-overlay">
                        <h4 class="text-gold">Strength Gym</h4>
                        <p class="u-small">Elite strength & conditioning</p>
                    </div>
                </div>
            </div>

            <div class="u-col-md-4">
                <div class="facility-card">
                    <img src="assets/images/Sauna_03.jpg" class="facility-img" alt="Sauna room">
                    <div class="facility-overlay">
                        <h5 class="text-gold">Sauna</h5>
                        <p class="u-small">Recovery & heat therapy</p>
                    </div>
                </div>
            </div>

            <div class="u-col-md-4">
                <div class="facility-card">
                    <img src="assets/images/Classic-Steam_copertina.jpg" class="facility-img" alt="Steam room">
                    <div class="facility-overlay">
                        <h5 class="text-gold">Steam Room</h5>
                        <p class="u-small">Relaxation & detox</p>
                    </div>
                </div>
            </div>

            <div class="u-col-md-4">
                <div class="facility-card">
                    <img src="assets/images/shower-cubicles.jpg" class="facility-img" alt="Luxury showers">
                    <div class="facility-overlay">
                        <h5 class="text-gold">Amenities</h5>
                        <p class="u-small">Luxury showers & changing rooms</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



