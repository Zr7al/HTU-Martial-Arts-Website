<?php

session_start(); 
?>
<?php
$pageTitle = 'Programs | HTU Martial Arts';
include 'header.php';
?>
<body>

<?php include 'navbar.php'; ?>

<div class="hero-programs">
    <div class="u-container">
        <h5 class="text-gold u-text-uppercase" style="letter-spacing: 3px;">World Class Training</h5>
        <h1 class="u-display-3 u-fw-bold u-text-white u-mb-3">OUR PROGRAMS</h1>
        <p class="u-lead u-text-white u-mx-auto" style="max-width: 700px; opacity: 0.9;">
            Master the art of combat. Whether your goal is self-defense, fitness, or competition, we have the path for you.
        </p>
    </div>
</div>

<div class="u-container section-padding">
    
    <div class="u-row u-g-4">
        
        <div class="u-col-lg-6">
            <div class="dashboard-card u-p-0 overflow-hidden u-d-flex u-flex-column flex-md-row u-h-100">
                <div style="width: 100%; min-height: 250px;">
                    <img src="assets/images/2524707753_201dc50421_z.jpg" class="facility-img" alt="BJJ">
                </div>
                <div class="u-p-4 u-d-flex u-flex-column u-justify-content-center">
                    <h3 class="text-gold u-mb-3"><i class="fa-solid fa-people-pulling u-me-2"></i>JIU-JITSU</h3>
                    <p class="u-text-secondary u-small u-mb-3">A grappling-based martial art focusing on submission holds. Essential for self-defense and MMA.</p>
                    <ul class="u-list-unstyled u-text-white u-small">
                        <li class="u-mb-1"><i class="fa-solid fa-check text-gold u-me-2"></i>Gi and No-Gi Classes</li>
                        <li class="u-mb-1"><i class="fa-solid fa-check text-gold u-me-2"></i>Takedowns & Submissions</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="u-col-lg-6">
            <div class="dashboard-card u-p-0 overflow-hidden u-d-flex u-flex-column flex-md-row u-h-100">
                <div style="width: 100%; min-height: 250px;">
                    <img src="assets/images/536718420.jpg" class="facility-img" alt="Muay Thai">
                </div>
                <div class="u-p-4 u-d-flex u-flex-column u-justify-content-center">
                    <h3 class="text-gold u-mb-3"><i class="fa-solid fa-hand-fist u-me-2"></i>MUAY THAI</h3>
                    <p class="u-text-secondary u-small u-mb-3">The "Art of Eight Limbs". A striking discipline utilizing fists, elbows, knees, and shins.</p>
                    <ul class="u-list-unstyled u-text-white u-small">
                        <li class="u-mb-1"><i class="fa-solid fa-check text-gold u-me-2"></i>Clinch Work & Striking</li>
                        <li class="u-mb-1"><i class="fa-solid fa-check text-gold u-me-2"></i>Cardio & Conditioning</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="u-col-lg-6">
            <div class="dashboard-card u-p-0 overflow-hidden u-d-flex u-flex-column flex-md-row u-h-100">
                <div style="width: 100%; min-height: 250px;">
                    <img src="assets/images/JUDO.jpg" class="facility-img" alt="Judo">
                </div>
                <div class="u-p-4 u-d-flex u-flex-column u-justify-content-center">
                    <h3 class="text-gold u-mb-3"><i class="fa-solid fa-user-ninja u-me-2"></i>JUDO</h3>
                    <p class="u-text-secondary u-small u-mb-3">An Olympic sport focusing on throws and takedowns. Perfect for balance and core strength.</p>
                    <ul class="u-list-unstyled u-text-white u-small">
                        <li class="u-mb-1"><i class="fa-solid fa-check text-gold u-me-2"></i>Throws & Takedowns</li>
                        <li class="u-mb-1"><i class="fa-solid fa-check text-gold u-me-2"></i>Pins & Chokes</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="u-col-lg-6">
            <div class="dashboard-card u-p-0 overflow-hidden u-d-flex u-flex-column flex-md-row u-h-100">
                <div style="width: 100%; min-height: 250px;">
                    <img src="assets/images/karate.jpg" class="facility-img" alt="Karate">
                </div>
                <div class="u-p-4 u-d-flex u-flex-column u-justify-content-center">
                    <h3 class="text-gold u-mb-3"><i class="fa-solid fa-hand-holding-hand u-me-2"></i>KARATE</h3>
                    <p class="u-text-secondary u-small u-mb-3">A striking art utilizing punching, kicking, and open-hand techniques. Focuses on discipline.</p>
                    <ul class="u-list-unstyled u-text-white u-small">
                        <li class="u-mb-1"><i class="fa-solid fa-check text-gold u-me-2"></i>Kata (Forms)</li>
                        <li class="u-mb-1"><i class="fa-solid fa-check text-gold u-me-2"></i>Kumite (Sparring)</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




