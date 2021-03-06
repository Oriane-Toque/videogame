<?php

// Inclusion du fichier s'occupant de la connexion à la DB (TODO)
require __DIR__.'/inc/db.php'; // Pour __DIR__ => http://php.net/manual/fr/language.constants.predefined.php
// Rappel : la variable $pdo est disponible dans ce fichier
//          car elle a été créée par le fichier inclus ci-dessus

// Initialisation de variables (évite les "NOTICE - variable inexistante")
$videogameList = array();
$platformList = array();
$name = '';
$editor = '';
$release_date = '';
$platform = '';

// Si le formulaire a été soumis
if (!empty($_POST)) {
    // Récupération des valeurs du formulaire dans des variables
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $editor = isset($_POST['editor']) ? $_POST['editor'] : '';
    $release_date = isset($_POST['release_date']) ? $_POST['release_date'] : '';
    $platform = isset($_POST['platform']) ? intval($_POST['platform']) : 0;
    
    // pour gérer les apostrophes & guillemets
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $editor = filter_input(INPUT_POST, 'editor', FILTER_SANITIZE_SPECIAL_CHARS);
    
    // TODO #3 (optionnel) valider les données reçues (ex: donnée non vide)
    // --- START OF YOUR CODE ---

    // tableau qui récupère notification erreurs
    $errors = [];
    // une fonction pour vérifier ma date
    function valideDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    // vérification des données reçues du formulaire
    // + messages d'erreurs pour améliorations en projet
    if(empty($name)) {
        $errors['name'] = 'Le titre est obligatoire';
    }

    if(empty($editor)) {
        $errors['editor'] = 'Le nom de l\'éditeur est obligatoire'; 
    }

    if(valideDate($release_date) === false) {
        $errors['date'] = 'Veuillez spécifier une date de sortie';
    }

    if(empty($platform)) {
        $errors['platform'] = 'Indiquer la plateforme correspondante';   
    }

    /* var_dump($errors); */

    // si le tableau $errors est vide alors on continue le script
    if (empty($errors)) {
        // --- END OF YOUR CODE ---
    
        // Insertion en DB du jeu video
        $insertQuery = "
        INSERT INTO videogame (name, editor, release_date, platform_id)
        VALUES ('{$name}', '{$editor}', '{$release_date}', {$platform})
        ";
        // TODO #3 exécuter la requête qui insère les données
        // TODO #3 une fois inséré, faire une redirection vers la page "index.php" (fonction header)
        // --- START OF YOUR CODE ---

        $pdoStatement = $pdo->exec($insertQuery);
        header('Location:index.php');
        die();
    }
        // --- END OF YOUR CODE ---
}

// Liste des consoles de jeux
// TODO #4 (optionnel) récupérer cette liste depuis la base de données
// --- START OF YOUR CODE ---
/* $platformList = array(
    1 => 'PC',
    2 => 'MegaDrive',
    3 => 'SNES',
    4 => 'PlayStation'
); */

$sql = '
    SELECT *
    FROM `platform`
';

// on peut écrire la requête directement dans le query
$pdoStatement = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// parcourir ce tableau
foreach($pdoStatement as $platformValue) {
    $key = $platformValue['id'];
    $platformList[$key] = $platformValue['name'];
}

// --- END OF YOUR CODE ---

// TODO #1 écrire la requête SQL permettant de récupérer les jeux vidéos en base de données (mais ne pas l'exécuter maintenant)
// --- START OF YOUR CODE ---
$sql = '
    SELECT *
    FROM `videogame`
';
// --- END OF YOUR CODE ---

// Si un tri a été demandé, on réécrit la requête
if (!empty($_GET['order'])) {
    // Récupération du tri choisi
    $order = trim($_GET['order']);
    if ($order == 'name') {
        // TODO #2 écrire la requête avec un tri par nom croissant
        // --- START OF YOUR CODE ---
        $sql = '
            SELECT *
            FROM `videogame`
            ORDER BY `name`
            ASC
        ';
        // --- END OF YOUR CODE ---
    }
    else if ($order == 'editor') {
        // TODO #2 écrire la requête avec un tri par editeur croissant
        // --- START OF YOUR CODE ---
        $sql = '
            SELECT *
            FROM `videogame`
            ORDER BY `editor`
            ASC
        ';
        // --- END OF YOUR CODE ---
    }
}
// TODO #1 exécuter la requête contenue dans $sql et récupérer les valeurs dans la variable $videogameList
// --- START OF YOUR CODE ---

$pdoStatement = $pdo->query($sql);

// pour avoir un tableau associatif -> fetchAll(PDO::FETCH_ASSOC)
$videogameList = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

// --- END OF YOUR CODE ---

// Inclusion du fichier s'occupant d'afficher le code HTML
// Je fais cela car mon fichier actuel est déjà assez gros, donc autant le faire ailleurs (pas le métier hein ! ;) )
require __DIR__.'/view/videogame.php';
