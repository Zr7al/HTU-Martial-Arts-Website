<nav class="navbar navbar-custom u-sticky-top"> 
    <div class="u-container">
        <a class="u-navbar-brand u-d-flex u-align-items-center" href="dashboard.php">
            <span class="text-gold u-fw-bold u-fs-4">HTU</span>
            <span class="u-ms-2 u-fw-bold u-fs-5">MARTIAL ARTS</span>
        </a>

        <div class="u-navbar-collapse">
            <ul class="u-navbar-nav u-ms-auto u-align-lg-center u-gap-2 u-gap-lg-3">
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="u-nav-item"><a class="u-nav-link u-text-uppercase" href="programs.php">Programs</a></li>
                    <li class="u-nav-item"><a class="u-nav-link u-text-uppercase" href="staff.php">Staff</a></li>
                    <li class="u-nav-item"><a class="u-nav-link u-text-uppercase" href="community.php">Community</a></li>
                    <li class="u-nav-item"><a class="u-nav-link u-text-uppercase" href="classes.php">Timetable</a></li>
                    <li class="u-nav-item"><a class="u-nav-link u-text-uppercase" href="pricing.php">Membership</a></li>
                    <li class="u-nav-item"><a class="u-nav-link u-text-uppercase" href="profile.php">Profile</a></li>
                    
                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="u-nav-item"><a class="u-nav-link text-gold u-text-uppercase" href="admin.php">Admin</a></li>
                    <?php endif; ?>

                    <li class="u-nav-item">
                        <a href="logout.php" class="btn-small btn-ghost-danger">LOGOUT</a>
                    </li>

                <?php else: ?>
                    <li class="u-nav-item"><a class="u-nav-link" href="programs.php">Programs</a></li>
                    <li class="u-nav-item"><a class="u-nav-link" href="staff.php">Staff</a></li>
                    <li class="u-nav-item"><a class="u-nav-link" href="login.php">Login</a></li>
                    <li class="u-nav-item"><a class="btn-gold" href="register.php">Join Now</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


