<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Twitter</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php $user = isset($_GET['user']) ? htmlspecialchars($_GET['user']) : ''; ?>
    <div class="container">
        <section class="feed">
            <?php if(!empty($user)): ?>
                <h3>Je suis <?= $user ?></h3>
            <?php endif; ?>
            <form id="tweetForm" action="action.php" method="POST">
                <input type="hidden" name="user" value="<?= $user ?>">
                <textarea placeholder="Quoi de neuf ?" name="message"></textarea>
                <button type="submit">Tweeter</button>
            </form>
            <div class="tweets">
                <?php foreach($tweets as $tweet): ?>
                    <div class="tweet">
                        <h1><?= $tweet['pseudo'] ?></h1>
                        <p><?= $tweet['message'] ?></p>
                        <?php if($tweet['pseudo'] === $user): ?>
                            <form action="delete.php?user=<?= urlencode($user) ?>" method="POST">
                                <input type="hidden" name="tweet_id" value="<?= $tweet['id'] ?>">
                                <button type="submit" class="delete-btn">Supprimer</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</body>
</html>
