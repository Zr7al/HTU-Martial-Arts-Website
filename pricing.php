<?php

session_start();
include 'db.php';


if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$userId = $_SESSION['user_id'];
$message = "";
$msgClass = "notice--success";


if (isset($_POST['select'])) {
    $membershipId = $_POST['membership_id'];
    mysqli_query($conn, "UPDATE users SET membership_id='$membershipId' WHERE id='$userId'");
    $message = "Membership plan updated successfully!";
}


if (isset($_POST['book_service'])) {
    $serviceName = $_POST['service_name'];
    $servicePrice = $_POST['service_price'];
    
    
    $serviceSql = "INSERT INTO service_bookings (user_id, service_name, price) VALUES ('$userId', '$serviceName', '$servicePrice')";
    
    if (mysqli_query($conn, $serviceSql)) {
        $message = "Success! You have booked: " . $serviceName;
    } else {
        $message = "Error booking service: " . mysqli_error($conn);
        $msgClass = "notice--danger";
    }
}


$userQuery = mysqli_query($conn, "SELECT membership_id FROM users WHERE id='$userId'");
$currentPlanId = mysqli_fetch_array($userQuery)['membership_id'];
$memberships = mysqli_query($conn, "SELECT * FROM memberships");
?>
<?php
$pageTitle = 'Pricing | HTU Martial Arts';
include 'header.php';
?>
<body>

<?php include 'navbar.php'; ?>

<div class="u-container u-mt-5">
    <div class="u-text-center u-mb-5">
        <h1 class="text-gold u-display-4 u-fw-bold">MEMBERSHIPS & PRICING</h1>
        <p class="u-text-secondary u-lead">Official HTU rates for classes and facilities.</p>
    </div>

    <?php if ($message) echo "<div class='notice $msgClass'>$message <button type='button' class='notice-close' aria-label='Close'>&times;</button></div>"; ?>

    <div class="u-row u-g-4 u-mb-5">
        <?php while ($row = mysqli_fetch_array($memberships)) { 
            $membershipId = $row['id'];
            $membershipTitle = $row['title'];
            $membershipPrice = $row['price'];
            $membershipDescription = $row['description'];
            $isCurrent = ($membershipId == $currentPlanId);
            $cardBorderClass = '';
            $buttonDisabled = '';
            $buttonText = 'Select Plan';
            if ($isCurrent) {
                $cardBorderClass = 'border-gold';
                $buttonDisabled = 'disabled';
                $buttonText = 'Current Plan';
            }
        ?>
            <div class="u-col-md-4">
                <div class="dashboard-card u-text-center <?php echo $cardBorderClass; ?>" style="height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <h3 class="text-gold"><?= $membershipTitle ?></h3>
                        <div class="u-my-3">
                            <span class="u-display-6 u-fw-bold u-text-white"><?= $membershipPrice ?></span>
                            <span class="u-text-secondary">JD/mo</span>
                        </div>
                        <p class="u-small u-text-secondary u-mb-4"><?= $membershipDescription ?></p>
                    </div>
                    <form method="post">
                        <input type="hidden" name="membership_id" value="<?= $membershipId ?>">
                        <button name="select" class="btn-gold u-w-100" <?php echo $buttonDisabled; ?>>
                            <?php echo $buttonText; ?>
                        </button>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="u-pt-5 u-border-top u-border-secondary">
        <h2 class="text-gold u-fw-bold u-mb-4">SPECIALIST COURSES & FITNESS TRAINING</h2>
        <div class="u-row u-g-4">
            
            <div class="u-col-md-4">
                <div class="dashboard-card border-gold u-h-100 u-d-flex u-flex-column u-justify-content-between">
                    <div>
                        <h5 class="text-gold">Self-Defence Course</h5>
                        <p class="u-small u-text-secondary">Six-week beginners' course (2x1h per week).</p>
                        <h4 class="u-text-white">180.00 JD</h4>
                    </div>
                    <form method="post" class="u-mt-3">
                        <input type="hidden" name="service_name" value="Self-Defence Course">
                        <input type="hidden" name="service_price" value="180.00">
                        <button name="book_service" class="btn-outline-custom u-w-100">Book Course</button>
                    </form>
                </div>
            </div>

            <div class="u-col-md-4">
                <div class="dashboard-card u-h-100 u-d-flex u-flex-column u-justify-content-between">
                    <div>
                        <h5 class="text-gold">Fitness Room</h5>
                        <p class="u-small u-text-secondary">Use of fitness room, sauna, and steam room.</p>
                        <h4 class="u-text-white">6.00 JD <span class="u-small u-text-muted">/visit</span></h4>
                    </div>
                    <form method="post" class="u-mt-3">
                        <input type="hidden" name="service_name" value="Fitness Room Pass">
                        <input type="hidden" name="service_price" value="6.00">
                        <button name="book_service" class="btn-outline-custom u-w-100">Buy Day Pass</button>
                    </form>
                </div>
            </div>

            <div class="u-col-md-4">
                <div class="dashboard-card u-h-100 u-d-flex u-flex-column u-justify-content-between">
                    <div>
                        <h5 class="text-gold">Personal Training</h5>
                        <p class="u-small u-text-secondary">Personal fitness training per hour with specialists.</p>
                        <h4 class="u-text-white">35.00 JD <span class="u-small u-text-muted">/hour</span></h4>
                    </div>
                    <form method="post" class="u-mt-3">
                        <input type="hidden" name="service_name" value="Personal Training Session">
                        <input type="hidden" name="service_price" value="35.00">
                        <button name="book_service" class="btn-outline-custom u-w-100">Book Session</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>





