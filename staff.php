<?php

session_start();
include 'db.php'; 


$query = "SELECT * FROM instructors";
$result = mysqli_query($conn, $query);
?>
<?php
$pageTitle = 'Our Team | HTU Martial Arts';
include 'header.php';
?>
<body>

<?php include 'navbar.php'; ?>

<div class="u-container section-padding">
    <div class="u-text-center u-mb-5">
        <h1 class="text-gold u-display-4 u-fw-bold">MEET THE TEAM</h1>
        <p class="u-text-secondary u-lead">World-class instruction from dedicated professionals.</p>
    </div>

    <div class="u-row u-g-4 u-justify-content-center">
        
        <?php
        
        if (mysqli_num_rows($result) > 0) {
            
            while ($row = mysqli_fetch_array($result)) {
                
                $avatarName = urlencode($row['name']);
                $avatarUrl = "https://ui-avatars.com/api/?name=$avatarName&background=d4af37&color=000&size=128";
                
                
                
                ?>
                <div class="u-col-lg-4 u-col-md-6">
                    <div class="dashboard-card u-h-100 u-text-center">
                        <img src="<?= $avatarUrl ?>" class="u-rounded-circle staff-img u-shadow u-mb-4" alt="Coach avatar">
                        
                        <h3 class="u-text-white u-mb-1"><?= htmlspecialchars($row['name']) ?></h3>
                        
                        <h6 class="text-gold u-text-uppercase u-mb-3">HTU Coach</h6>
                        
                        <div class="u-border-top u-border-secondary u-pt-3">
                            <p class="u-text-secondary u-small">
                                <?= nl2br(htmlspecialchars($row['details'])) ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            
            echo '<p class="u-text-center u-text-secondary">No staff members listed yet.</p>';
        }
        ?>

    </div>
</div>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




