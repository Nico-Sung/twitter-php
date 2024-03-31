<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $database = new PDO('mysql:host=localhost;dbname=Twitter', 'root', 'root', array(
            PDO::ATTR_PERSISTENT => true
        ));
        
        if(isset($_POST['user']) && !empty($_POST['user'])) {
            $user = $_POST['user'];

            if(isset($_POST['message']) && !empty($_POST['message'])) {
                $message = $_POST['message'];
                $userId = null;

                $requete = $database->prepare(
                    'SELECT id FROM users WHERE pseudo = :pseudo'
                );
                $requete->execute([
                    'pseudo' => $user
                ]);
                $userId = $requete->fetchColumn();

                if($userId) {
                    $requete = $database->prepare(
                        'INSERT INTO tweets (message, author_id) VALUES (:message, :author_id)'
                    );
                    $requete->execute([
                        'message' => $message,
                        'author_id' => $userId
                    ]);
                } else {
                    $requete = $database->prepare(
                        'INSERT INTO tweets (message) VALUES (:message)'
                    );
                    $requete->execute([
                        'message' => $message
                    ]);
                }

                header('Location: http://localhost/?user=' . urlencode($user));
                exit();
            } else {
                die('Le champ message est vide.');
            }
        } else {
            die('Aucun pseudo');
        }
    } catch(PDOException $e) {
        die('Could not connect to the database $dbname :' . $e->getMessage());
    }
} else {
    die('Method not allowed.');
}
