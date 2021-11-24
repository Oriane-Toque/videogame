<?php

// TODO #1 créer un objet PDO permettant de se connecter à la base de données "videogame"
// et le stocker dans la variable $pdo
// --- START OF YOUR CODE ---

  // dsn = data source name
  $dsn = 'mysql:dbname=qc1w67hiprxlfc3i;host=lmc8ixkebgaq22lo.chr7pe7iynqr.eu-west-1.rds.amazonaws.com;charset=UTF8mb4';

  // username
  $username = 'zjxbi79zrxm2plpm';

  // password
  $password = 'fwq95h8d4xwlblys';

  // option
  $option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

  /* fabrication d'un objet à partir de la class PDO
  qui va me permettre d'interagir avec la BDD mentionnée dans le dsn
  */
  $pdo = new PDO($dsn, $username, $password, $option);

// --- END OF YOUR CODE ---
