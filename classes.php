<?php

session_start();
include("db.php");


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$msg = null;


if (isset($_POST['book'])) {
    $classId = $_POST['class_id'];

    $check = mysqli_query(
        $conn,
        "SELECT id FROM booking 
         WHERE user_id = '$userId' AND class_id = '$classId'"
    );

    if (mysqli_num_rows($check) == 0) {
        mysqli_query(
            $conn,
            "INSERT INTO booking (user_id, class_id, status)
             VALUES ('$userId', '$classId', 'booked')"
        );
        $msg = "Class booked successfully.";
    } else {
        $msg = "You already booked this class.";
    }
}


if (isset($_POST['cancel'])) {
    $classId = $_POST['class_id'];

    mysqli_query(
        $conn,
        "DELETE FROM booking 
         WHERE user_id = '$userId' AND class_id = '$classId'"
    );

    $msg = "Booking cancelled.";
}
?>
<?php
$pageTitle = 'Timetable | HTU Martial Arts';
include 'header.php';
?>
<body>

<?php include 'navbar.php'; ?>

<div class="u-container u-mt-5">

    
    <div class="u-text-center u-mb-5">
        <h1 class="text-gold u-display-4 u-fw-bold">MARTIAL ARTS TIMETABLE</h1>
        <p class="u-text-secondary">Weekly training schedule</p>
    </div>

    
    <?php if ($msg): ?>
        <div class="notice notice--success u-text-center"><?= $msg ?></div>
    <?php endif; ?>

    <?php
    $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

    foreach ($days as $day) {

        $query = "
            SELECT classes.*, instructors.name AS coach
            FROM classes
            JOIN instructors ON classes.instructor_id = instructors.id
            WHERE day_of_week = '$day'
            ORDER BY start_time ASC
        ";

        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {

            echo "<h3 class='text-gold u-border-bottom u-border-secondary u-pb-2 u-mb-4 u-mt-5'>$day</h3>";
            echo "<div class='u-row u-g-3'>";

            while ($row = mysqli_fetch_array($result)) {

                $classId = $row['ID'];
                $className = htmlspecialchars($row['name']);
                $coachName = htmlspecialchars($row['coach']);
                $startTime = date("H:i", strtotime($row['start_time']));
                $endTime = date("H:i", strtotime($row['end_time']));

                $bookedCheck = mysqli_query(
                    $conn,
                    "SELECT id FROM booking 
                     WHERE user_id = '$userId' AND class_id = '$classId'"
                );

                $isBooked = mysqli_num_rows($bookedCheck) > 0;
                ?>

                <div class="u-col-md-4 u-col-lg-3">
                    <div class="dashboard-card u-p-3">

                      
                        <div class="u-mb-2">
                            <span class="tag u-bg-dark text-gold u-border border-gold">
                                <?= $startTime ?>
                                -
                                <?= $endTime ?>
                            </span>
                        </div>

                        
                        <h5 class="u-text-white u-mb-1">
                            <?= $className ?>
                        </h5>

                        
                        <p class="u-text-secondary u-small u-mb-3">
                            Coach: <?= $coachName ?>
                        </p>

                       
                        <form method="POST">
                            <input type="hidden" name="class_id" value="<?= $classId ?>">

                            <?php if ($isBooked): ?>
                               
                                <button class="btn-solid-success btn-small u-w-100 u-fw-bold u-mb-2" disabled>
                                    BOOKED
                                </button>

                                
                                <button type="submit" name="cancel"
                                        class="btn-ghost-danger btn-small u-w-100 u-fw-bold">
                                    CANCEL BOOKING
                                </button>
                            <?php else: ?>
                               
                                <button type="submit" name="book"
                                        class="btn-gold btn-small u-w-100 u-fw-bold">
                                    BOOK SESSION
                                </button>
                            <?php endif; ?>
                        </form>

                    </div>
                </div>

                <?php
            }

            echo "</div>";
        }
    }
    ?>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




