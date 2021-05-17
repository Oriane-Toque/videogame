<?php

// TODO #1 créer un objet PDO permettant de se connecter à la base de données "videogame"
// et le stocker dans la variable $pdo
// --- START OF YOUR CODE ---

  // dsn = data source name
  $dsn = 'mysql:dbname=videogame;host=localhost;charset=UTF8mb4';

  // username
  $username = 'videogame';

  // password
  $password = 'Q9pUw5Xc2';

  // option
  $option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

  /* fabrication d'un objet à partir de la class PDO
  qui va me permettre d'interagir avec la BDD mentionnée dans le dsn
  */
  $pdo = new PDO($dsn, $username, $password, $option);

// --- END OF YOUR CODE ---
