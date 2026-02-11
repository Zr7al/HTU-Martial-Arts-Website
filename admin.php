<?php

session_start();
include 'db.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}


$action = $_POST['action'] ?? $_GET['action'] ?? null;
if ($action) {
    switch ($action) {
        
        case 'add_instructor':
            $name = $_POST['name'];
            $role = $_POST['role'];
            $details = $_POST['details'];
            mysqli_query($conn, "INSERT INTO instructors (name, role, details) VALUES ('$name', '$role', '$details')");
            header("Location: admin.php?tab=instructors");
            break;
        case 'update_instructor':
            $id = (int)$_POST['id'];
            $name = $_POST['name'];
            $role = $_POST['role'];
            $details = $_POST['details'];
            mysqli_query($conn, "UPDATE instructors SET name='$name', role='$role', details='$details' WHERE id=$id");
            header("Location: admin.php?tab=instructors");
            break;
        case 'delete_instructor':
            $id = (int)$_GET['id'];
            
            mysqli_query($conn, "DELETE FROM classes WHERE instructor_id=$id");
            
            mysqli_query($conn, "DELETE FROM instructors WHERE id=$id");
            header("Location: admin.php?tab=instructors");
            break;

        
        case 'add_class':
            $name = $_POST['name'];
            $day = $_POST['day'];
            $start = $_POST['start_time'];
            $end = $_POST['end_time'];
            $coach_id = (int)$_POST['instructor_id'];
            mysqli_query($conn, "INSERT INTO classes (name, day_of_week, start_time, end_time, instructor_id) VALUES ('$name', '$day', '$start', '$end', '$coach_id')");
            header("Location: admin.php?tab=classes");
            break;
        case 'delete_class':
            $id = (int)$_GET['id'];
            mysqli_query($conn, "DELETE FROM classes WHERE ID=$id");
            header("Location: admin.php?tab=classes");
            break;
        case 'update_class':
            $id = (int)$_POST['id'];
            $name = $_POST['name'];
            $day = $_POST['day'];
            $start = $_POST['start_time'];
            $end = $_POST['end_time'];
            $coach_id = (int)$_POST['instructor_id'];
            mysqli_query($conn, "UPDATE classes SET name='$name', day_of_week='$day', start_time='$start', end_time='$end', instructor_id='$coach_id' WHERE ID=$id");
            header("Location: admin.php?tab=classes");
            break;

        
        case 'add_membership':
            $title = $_POST['title'];
            $price = (float)$_POST['price'];
            $desc = $_POST['description'];
            mysqli_query($conn, "INSERT INTO memberships (title, price, description) VALUES ('$title', '$price', '$desc')");
            header("Location: admin.php?tab=pricing");
            break;
        case 'update_membership':
            $id = (int)$_POST['id'];
            $title = $_POST['title'];
            $price = (float)$_POST['price'];
            $desc = $_POST['description'];
            mysqli_query($conn, "UPDATE memberships SET title='$title', price='$price', description='$desc' WHERE id=$id");
            header("Location: admin.php?tab=pricing");
            break;
        case 'delete_membership':
            $id = (int)$_GET['id'];
            mysqli_query($conn, "DELETE FROM memberships WHERE id=$id");
            header("Location: admin.php?tab=pricing");
            break;

        
        case 'update_user':
            $id = (int)$_POST['id'];
            $name = $_POST['full_name'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $plan = (int)$_POST['membership_id'];
            $planSql = "NULL";
            if ($plan > 0) {
                $planSql = "'$plan'";
            }
            mysqli_query($conn, "UPDATE users SET full_name='$name', email='$email', role='$role', membership_id=$planSql WHERE id=$id");
            header("Location: admin.php?tab=users");
            break;
        case 'delete_user':
            $id = (int)$_GET['id'];
            if($id != $_SESSION['user_id']) {
                mysqli_query($conn, "DELETE FROM users WHERE id=$id");
            }
            header("Location: admin.php?tab=users");
            break;
    }
}



$instructors_table = mysqli_query($conn, "SELECT * FROM instructors");
$instructors_dropdown = mysqli_query($conn, "SELECT id, name FROM instructors");
$instructors_dropdown_edit = mysqli_query($conn, "SELECT id, name FROM instructors");
$classes = mysqli_query($conn, "SELECT classes.ID, classes.day_of_week, classes.name, classes.start_time, classes.end_time, instructors.name as coach FROM classes LEFT JOIN instructors ON classes.instructor_id = instructors.id ORDER BY FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), start_time");
$memberships_cards = mysqli_query($conn, "SELECT * FROM memberships");
$memberships_dropdown = mysqli_query($conn, "SELECT id, title FROM memberships");
$users = mysqli_query($conn, "SELECT users.*, memberships.title as plan_name FROM users LEFT JOIN memberships ON users.membership_id = memberships.id");


$activeTab = 'instructors';
if (isset($_GET['tab'])) {
    $activeTab = $_GET['tab'];
}

$editData = null;
if (isset($_GET['edit_type']) && isset($_GET['edit_id'])) {
    $editId = (int)$_GET['edit_id'];
    
 
    if ($_GET['edit_type'] == 'instructor') {
        $res = mysqli_query($conn, "SELECT * FROM instructors WHERE id=$editId");
        $editData = mysqli_fetch_array($res);
        $activeTab = 'instructors'; 
    } 
 
    elseif ($_GET['edit_type'] == 'user') {
        $res = mysqli_query($conn, "SELECT * FROM users WHERE id=$editId");
        $editData = mysqli_fetch_array($res);
        $activeTab = 'users'; 
    }
    elseif ($_GET['edit_type'] == 'class') {
        $res = mysqli_query($conn, "SELECT * FROM classes WHERE ID=$editId");
        $editData = mysqli_fetch_array($res);
        $activeTab = 'classes';
    }
}

$isEditingInstructor = isset($editData) && $activeTab == 'instructors';
$isEditingUser = isset($editData) && $activeTab == 'users';
$isEditingClass = isset($editData) && $activeTab == 'classes';
$instructorFormTitle = 'Add Instructor';
$instructorAction = 'add_instructor';
$instructorSubmitName = 'add_instructor';
$instructorSubmitText = 'Add New Staff';
$instructorNameValue = '';
$instructorRoleValue = '';
$instructorDetailsValue = '';
if ($isEditingInstructor) {
    $instructorFormTitle = 'Edit Instructor';
    $instructorAction = 'update_instructor';
    $instructorSubmitName = 'update_instructor';
    $instructorSubmitText = 'Update Staff';
    $instructorNameValue = $editData['name'];
    $instructorRoleValue = $editData['role'];
    $instructorDetailsValue = $editData['details'];
}

$userFormTitle = $isEditingUser ? 'Edit User Details' : '';

$classFormTitle = 'Add Class';
$classAction = 'add_class';
$classSubmitName = 'add_class';
$classSubmitText = 'Add';
$classIdValue = '';
$classNameValue = '';
$classDayValue = '';
$classStartValue = '';
$classEndValue = '';
$classInstructorValue = '';
if ($isEditingClass) {
    $classFormTitle = 'Edit Class';
    $classAction = 'update_class';
    $classSubmitName = 'update_class';
    $classSubmitText = 'Update';
    $classIdValue = $editData['ID'];
    $classNameValue = $editData['name'];
    $classDayValue = $editData['day_of_week'];
    $classStartValue = $editData['start_time'];
    $classEndValue = $editData['end_time'];
    $classInstructorValue = $editData['instructor_id'];
}

$tabClassInstructors = '';
if ($activeTab == 'instructors') {
    $tabClassInstructors = 'is-active';
}
$tabClassClasses = '';
if ($activeTab == 'classes') {
    $tabClassClasses = 'is-active';
}
$tabClassPricing = '';
if ($activeTab == 'pricing') {
    $tabClassPricing = 'is-active';
}
$tabClassUsers = '';
if ($activeTab == 'users') {
    $tabClassUsers = 'is-active';
}

$tabPaneInstructorsClass = 'tab-panel';
if ($activeTab == 'instructors') {
    $tabPaneInstructorsClass .= ' is-active';
}
$tabPaneClassesClass = 'tab-panel';
if ($activeTab == 'classes') {
    $tabPaneClassesClass .= ' is-active';
}
$tabPanePricingClass = 'tab-panel';
if ($activeTab == 'pricing') {
    $tabPanePricingClass .= ' is-active';
}
$tabPaneUsersClass = 'tab-panel';
if ($activeTab == 'users') {
    $tabPaneUsersClass .= ' is-active';
}
?>

<?php
$pageTitle = 'Admin Panel | HTU Martial Arts';
include 'header.php';
?>
<body>

<?php include 'navbar.php'; ?>

<div class="u-container section-padding">
    <h1 class="text-gold u-mb-4 u-display-5 u-fw-bold">ADMINISTRATION</h1>
    
    <ul class="admin-tabs u-mb-4 u-gap-2" id="adminTabs" role="tablist">
        <li class="admin-tab"><a class="admin-tab-link btn-outline-custom <?php echo $tabClassInstructors; ?>" href="admin.php?tab=instructors">Instructors</a></li>
        <li class="admin-tab"><a class="admin-tab-link btn-outline-custom <?php echo $tabClassClasses; ?>" href="admin.php?tab=classes">Schedule</a></li>
        <li class="admin-tab"><a class="admin-tab-link btn-outline-custom <?php echo $tabClassPricing; ?>" href="admin.php?tab=pricing">Pricing</a></li>
        <li class="admin-tab"><a class="admin-tab-link btn-outline-custom <?php echo $tabClassUsers; ?>" href="admin.php?tab=users">Users</a></li>
    </ul>

    <div class="tab-panels">

        <div class="<?php echo $tabPaneInstructorsClass; ?>" id="instructors">
            <div class="u-row">
                <div class="u-col-md-4 u-mb-4">
                    <div class="dashboard-card border-gold">
                        <h4 class="u-text-white u-mb-3"><?php echo $instructorFormTitle; ?></h4>
                        
                        <form method="POST">
                            <input type="hidden" name="action" value="<?php echo $instructorAction; ?>">
                            <?php if(isset($editData) && $activeTab=='instructors'): ?>
                                <input type="hidden" name="id" value="<?= $editData['id'] ?>">
                            <?php endif; ?>
                            
                            <div class="u-mb-3">
                                <label class="u-text-secondary u-small">Name</label>
                                <input type="text" name="name" class="custom-input" value="<?php echo $instructorNameValue; ?>" required>
                            </div>

                            <div class="u-mb-3">
                                <label class="u-text-secondary u-small">Role / Title</label>
                                <input type="text" name="role" class="custom-input" value="<?php echo $instructorRoleValue; ?>" placeholder="e.g. Head Coach" required>
                            </div>

                            <div class="u-mb-3">
                                <label class="u-text-secondary u-small">Bio</label>
                                <textarea name="details" class="custom-input" rows="4" required><?php echo $instructorDetailsValue; ?></textarea>
                            </div>

                            <button type="submit" 
                                    name="<?php echo $instructorSubmitName; ?>" 
                                    class="btn-gold u-w-100">
                                <?php echo $instructorSubmitText; ?>
                            </button>

                            <?php if(isset($editData) && $activeTab=='instructors'): ?>
                                <a href="admin.php?tab=instructors" class="btn-ghost-secondary u-w-100 u-mt-2">Cancel Edit</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

                <div class="u-col-md-8">
                    <div class="dashboard-card">
                        <div class="table-wrap">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th class="text-gold">Name</th>
                                        <th class="text-gold">Role</th>
                                        <th>Details</th>
                                        <th class="u-text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php while($row = mysqli_fetch_array($instructors_table)): ?>
                                <tr>
                                    <td class="u-fw-bold"><?= $row['name'] ?></td>
                                    <td><span class="tag bg-gold u-text-dark"><?= $row['role'] ?></span></td>
                                    <td><small class="u-text-secondary"><?= substr($row['details'], 0, 40) ?>...</small></td>
                                    <td class="u-text-end">
                                        <a href="admin.php?edit_type=instructor&edit_id=<?= $row['id'] ?>&tab=instructors" class="btn-small btn-ghost-light"><i class="fas fa-edit"></i></a>
                                        <a href="admin.php?action=delete_instructor&id=<?= $row['id'] ?>&tab=instructors" class="btn-small btn-ghost-danger"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="<?php echo $tabPaneClassesClass; ?>" id="classes">
            <div class="dashboard-card u-mb-4 border-gold">
                <h4 class="u-text-white u-mb-3"><?php echo $classFormTitle; ?></h4>
                <form method="POST" class="u-row u-g-3">
                    <input type="hidden" name="action" value="<?php echo $classAction; ?>">
                    <?php if ($isEditingClass): ?>
                        <input type="hidden" name="id" value="<?php echo $classIdValue; ?>">
                    <?php endif; ?>
                    <div class="u-col-md-3">
                        <select name="name" class="custom-input" required>
                            <option <?php if ($classNameValue == 'Brazilian Jiu-Jitsu') { echo 'selected'; } ?>>Brazilian Jiu-Jitsu</option>
                            <option <?php if ($classNameValue == 'Muay Thai') { echo 'selected'; } ?>>Muay Thai</option>
                            <option <?php if ($classNameValue == 'Judo') { echo 'selected'; } ?>>Judo</option>
                            <option <?php if ($classNameValue == 'Karate') { echo 'selected'; } ?>>Karate</option>
                            <option <?php if ($classNameValue == 'MMA') { echo 'selected'; } ?>>MMA</option>
                        </select>
                    </div>
                    <div class="u-col-md-2">
                        <select name="day" class="custom-input" required>
                            <option <?php if ($classDayValue == 'Monday') { echo 'selected'; } ?>>Monday</option>
                            <option <?php if ($classDayValue == 'Tuesday') { echo 'selected'; } ?>>Tuesday</option>
                            <option <?php if ($classDayValue == 'Wednesday') { echo 'selected'; } ?>>Wednesday</option>
                            <option <?php if ($classDayValue == 'Thursday') { echo 'selected'; } ?>>Thursday</option>
                            <option <?php if ($classDayValue == 'Friday') { echo 'selected'; } ?>>Friday</option>
                            <option <?php if ($classDayValue == 'Saturday') { echo 'selected'; } ?>>Saturday</option>
                            <option <?php if ($classDayValue == 'Sunday') { echo 'selected'; } ?>>Sunday</option>
                        </select>
                    </div>
                    <div class="u-col-md-2"><input type="time" name="start_time" class="custom-input" value="<?php echo $classStartValue; ?>" required></div>
                    <div class="u-col-md-2"><input type="time" name="end_time" class="custom-input" value="<?php echo $classEndValue; ?>" required></div>
                    <div class="u-col-md-3">
                        <select name="instructor_id" class="custom-input" required>
                            <?php while($inst = mysqli_fetch_array($instructors_dropdown_edit)): ?>
                                <option value="<?= $inst['id'] ?>" <?php if ($classInstructorValue == $inst['id']) { echo 'selected'; } ?>>
                                    <?= $inst['name'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="u-col-12 u-text-end">
                        <button type="submit" name="<?php echo $classSubmitName; ?>" class="btn-gold"><?php echo $classSubmitText; ?></button>
                        <?php if ($isEditingClass): ?>
                            <a href="admin.php?tab=classes" class="btn-ghost-secondary u-ms-2">Cancel Edit</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            <div class="dashboard-card">
                <div class="table-wrap">
                    <table class="data-table">
                        <thead><tr><th class="text-gold">Day</th><th>Class</th><th>Time</th><th>Coach</th><th class="u-text-end">Action</th></tr></thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_array($classes)): ?>
                            <tr>
                                <td class="u-fw-bold"><?= $row['day_of_week'] ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?= substr($row['start_time'], 0, 5) . " - " . substr($row['end_time'], 0, 5) ?></td>
                                <td><?= $row['coach'] ?></td>
                                <td class="u-text-end">
                                    <a href="admin.php?edit_type=class&edit_id=<?= $row['ID'] ?>&tab=classes" class="btn-small btn-ghost-light"><i class="fas fa-edit"></i></a>
                                    <a href="admin.php?action=delete_class&id=<?= $row['ID'] ?>&tab=classes" class="btn-small btn-ghost-danger">Remove</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="<?php echo $tabPanePricingClass; ?>" id="pricing">
            <div class="dashboard-card u-mb-4 border-gold">
                <h5 class="u-text-white">Add Membership</h5>
                <form method="POST" class="u-row u-g-3">
                    <input type="hidden" name="action" value="add_membership">
                    <div class="u-col-md-4"><input type="text" name="title" class="custom-input" placeholder="Title" required></div>
                    <div class="u-col-md-2"><input type="number" name="price" class="custom-input" placeholder="Price" step="0.01" required></div>
                    <div class="u-col-md-4"><input type="text" name="description" class="custom-input" placeholder="Description" required></div>
                    <div class="u-col-md-2"><button type="submit" name="add_membership" class="btn-gold u-w-100">Add</button></div>
                </form>
            </div>
            <div class="u-row">
                <?php while($row = mysqli_fetch_array($memberships_cards)): ?>
                <div class="u-col-md-4 u-mb-3">
                    <div class="dashboard-card u-h-100">
                        <form method="POST">
                            <input type="hidden" name="action" value="update_membership">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <div class="u-d-flex u-justify-content-between u-mb-2">
                                <input type="text" name="title" class="custom-input u-fw-bold text-gold" value="<?= $row['title'] ?>">
                                <a href="admin.php?action=delete_membership&id=<?= $row['id'] ?>&tab=pricing" class="btn-ghost-danger btn-small"><i class="fas fa-trash"></i></a>
                            </div>
                            <input type="number" name="price" class="custom-input u-mb-2" value="<?= $row['price'] ?>" step="0.01">
                            <textarea name="description" class="custom-input u-mb-2"><?= $row['description'] ?></textarea>
                            <button name="update_membership" class="btn-ghost-light btn-small u-w-100">Update</button>
                        </form>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="<?php echo $tabPaneUsersClass; ?>" id="users">
            <div class="u-row">
                <?php if(isset($editData) && $activeTab=='users'): ?>
                    <div class="u-col-md-4 u-mb-4">
                        <div class="dashboard-card border-gold">
                            <h4 class="u-text-white u-mb-3"><?php echo $userFormTitle; ?></h4>
                            <form method="POST">
                                <input type="hidden" name="action" value="update_user">
                                <input type="hidden" name="id" value="<?= $editData['id'] ?>">
                                <div class="u-mb-3">
                                    <label class="u-text-secondary u-small">Full Name</label>
                                    <input type="text" name="full_name" class="custom-input" value="<?= $editData['full_name'] ?>" required>
                                </div>
                                <div class="u-mb-3">
                                    <label class="u-text-secondary u-small">Email</label>
                                    <input type="email" name="email" class="custom-input" value="<?= $editData['email'] ?>" required>
                                </div>
                                <div class="u-mb-3">
                                    <label class="u-text-secondary u-small">Role</label>
                                    <select name="role" class="custom-input">
                                        <option value="member" <?php if ($editData['role']=='member') { echo 'selected'; } ?>>Member</option>
                                        <option value="admin" <?php if ($editData['role']=='admin') { echo 'selected'; } ?>>Admin</option>
                                    </select>
                                </div>
                                <div class="u-mb-3">
                                    <label class="u-text-secondary u-small">Membership Plan</label>
                                    <select name="membership_id" class="custom-input">
                                        <option value="0">None</option>
                                        <?php while($m = mysqli_fetch_array($memberships_dropdown)): ?>
                                            <option value="<?= $m['id'] ?>" <?php if ($editData['membership_id']==$m['id']) { echo 'selected'; } ?>><?= $m['title'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <button type="submit" name="update_user" class="btn-gold u-w-100">Save Changes</button>
                                <a href="admin.php?tab=users" class="btn-ghost-secondary u-w-100 u-mt-2">Cancel</a>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="<?php echo $isEditingUser ? 'u-col-md-8' : 'u-col-12'; ?>">
                    <div class="dashboard-card">
                        <div class="table-wrap">
                            <table class="data-table">
                                <thead><tr><th class="text-gold">Name</th><th>Email</th><th>Role</th><th>Plan</th><th class="u-text-end">Action</th></tr></thead>
                                <tbody>
                                    <?php while($row = mysqli_fetch_array($users)): ?>
                                    <tr>
                                        <td class="u-fw-bold"><?= htmlspecialchars($row['full_name']) ?></td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td>
                                            <?php
                                            $roleBadgeClass = 'bg-secondary';
                                            if ($row['role'] == 'admin') {
                                            $roleBadgeClass = 'bg-gold u-text-dark';
                                            }
                                            ?>
                                            <span class="tag <?php echo $roleBadgeClass; ?>">
                                                <?= ucfirst($row['role']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($row['plan_name']) { ?>
                                                <?= $row['plan_name'] ?>
                                            <?php } else { ?>
                                                -
                                            <?php } ?>
                                        </td>
                                        <td class="u-text-end">
                                            <a href="admin.php?edit_type=user&edit_id=<?= $row['id'] ?>&tab=users" class="btn-small btn-ghost-light"><i class="fas fa-edit"></i></a>
                                            <?php if($row['id'] != $_SESSION['user_id']): ?>
                                                <a href="admin.php?action=delete_user&id=<?= $row['id'] ?>&tab=users" class="btn-small btn-ghost-danger"><i class="fas fa-trash"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
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



