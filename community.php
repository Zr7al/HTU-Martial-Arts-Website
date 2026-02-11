<?php

session_start();
include 'db.php';

if (isset($_POST['post_message']) && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $content = $_POST['content'];
    if (!empty($content)) {
        mysqli_query($conn, "INSERT INTO forum_posts (user_id, content) VALUES ('$userId', '$content')");
        header("Location: community.php"); 
        exit();
    }
}
$posts = mysqli_query($conn, "SELECT forum_posts.*, users.full_name FROM forum_posts JOIN users ON forum_posts.user_id = users.id ORDER BY forum_posts.created_at DESC");
?>

<?php
$pageTitle = 'Forum | HTU Martial Arts';
$pageStyles = <<<CSS
body.community-page .forum-avatar {
    flex: 0 0 auto;
}

body.community-page .post-avatar {
    width: 52px;
    height: 52px;
    border-radius: 999px;
    object-fit: cover;
}

@media (max-width: 768px) {
    body.community-page .forum-card,
    body.community-page .post-card {
        padding: 20px;
    }
}

@media (max-width: 576px) {
    body.community-page .forum-form,
    body.community-page .post-row {
        flex-direction: column;
        align-items: flex-start;
    }

    body.community-page .forum-actions {
        text-align: left;
    }

    body.community-page .post-avatar {
        width: 44px;
        height: 44px;
    }
}
CSS;
include 'header.php';
?>
<body class="community-page">

<?php include 'navbar.php'; ?>

<div class="u-container u-mt-5 u-mb-5">
    <div class="u-row u-justify-content-center">
        <div class="u-col-lg-8">
            <div class="u-text-center u-mb-4">
                <h2 class="text-gold u-display-5 u-fw-bold">MEMBER FORUM</h2>
                <p class="u-text-secondary">Discussion board for all active members.</p>
            </div>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="dashboard-card u-mb-5 border-gold forum-card">
                    <form method="POST" class="u-d-flex u-gap-3 forum-form">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['name']) ?>&background=d4af37&color=000" class="u-rounded-circle forum-avatar" width="50" height="50" alt="Member avatar">
                        <div class="u-w-100">
                            <textarea name="content" class="custom-input u-mb-3" placeholder="Write something..." rows="3" required></textarea>
                            <div class="u-text-end forum-actions">
                                <button type="submit" name="post_message" class="btn-gold u-px-4">POST</button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <div class="notice notice--dark u-border-secondary u-text-center u-mb-5">
                    <a href="login.php" class="text-gold u-fw-bold">Login</a> to join the discussion.
                </div>
            <?php endif; ?>

            <div class="u-d-flex u-flex-column u-gap-3">
                <?php while($row = mysqli_fetch_array($posts)): ?>
                    <div class="dashboard-card u-p-4 post-card">
                        <div class="u-d-flex u-gap-3 post-row">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($row['full_name']) ?>&background=333&color=fff" class="post-avatar" alt="Member avatar">
                            <div>
                                <h6 class="text-gold u-mb-1 u-fw-bold"><?= htmlspecialchars($row['full_name']) ?></h6>
                                <small class="u-text-secondary u-d-block u-mb-2" style="font-size: 0.8rem;">
                                    <?= date("M d, Y • h:i A", strtotime($row['created_at'])) ?>
                                </small>
                                <p class="u-text-white u-mb-0 u-lead" style="font-size: 1rem;"><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                
                <?php if(mysqli_num_rows($posts) == 0): ?>
                    <div class="u-text-center u-text-secondary u-py-5"><p>No posts yet. Start the conversation!</p></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

