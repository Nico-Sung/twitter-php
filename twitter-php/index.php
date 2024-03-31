<?php 

try{
    $database = new PDO('mysql:host=localhost;dbname=Twitter', 'root', 'root', array(
        PDO::ATTR_PERSISTENT => true
    ));

    $request = $database->prepare(
        'SELECT tweets.*, users.pseudo FROM `tweets`
        LEFT JOIN users ON users.id = tweets.author_id'
    );

    $request->execute();
    $tweets = $request->fetchAll(
            PDO::FETCH_ASSOC
    );


    require_once('index.html.php');
}catch(PDOException $e){
    die('error'. $e->getMessage());
}
