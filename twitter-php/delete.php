<?php

try {
    $database = new PDO('mysql:host=localhost;dbname=Twitter', 'root', 'root', array(
        PDO::ATTR_PERSISTENT => true
    ));

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tweet_id'])) {
        $tweetId = $_POST['tweet_id'];

        $user = isset($_GET['user']) ? $_GET['user'] : null;

        $requete = $database->prepare(
            'SELECT users.pseudo FROM tweets LEFT JOIN users ON users.id = tweets.author_id WHERE tweets.id = :tweet_id'
        );
        $requete->execute([
            'tweet_id' => $tweetId
        ]);
        $tweetOwner = $requete->fetchColumn();

        if ($tweetOwner === $user) {
            $deleteRequete = $database->prepare(
                'DELETE FROM tweets WHERE id = :id'
            );
            $deleteRequete->execute([
                'id' => $tweetId
            ]);

            header('Location: http://localhost/?user=' . urlencode($user));
            exit();
        } else {
            die('Vous n\'êtes pas autorisé à supprimer ce tweet');
        }
    } else {
        die('Method not allowed');
    }
}   catch(PDOException $e) {
    die('Could not connect to the database $dbname :' . $e->getMessage());
}

