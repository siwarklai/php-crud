<?php 
//Fonction du configuration et du connexion à une base de données MySQL 
function pdo_connect_mysql() { 
    // Configuration des informations de la base de données 
    $DATABASE_HOST = 'localhost'; 
    $DATABASE_USER = 'root'; 
    $DATABASE_PASS = ''; 
    $DATABASE_NAME = 'reservation'; 
    //saisie d'une exception potentielle 
    try { 
         // Connexion à la base de données mysql avec PDO 
        return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . 
$DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS); 
    } catch (PDOException $exception) { 
        // S'il y a une erreur avec la connexion, arrêtez le script et affichez l'erreur. 
        exit('Failed to connect to database!'); 
    } 
} /*Le fonction template_header($title)  est communément utilisé dans 
les sites web pour inclure le code HTML et les éléments visuels  
qui sont répétés sur toutes les pages du site, tels que la barre de 
navigation, le logo du site, 
 les liens vers les réseaux sociaux, etc.*/  
 
 function template_header($title) { 
    echo <<<EOT
    <!DOCTYPE html>
    <html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <title>$title</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <nav class="navtop">
        <div>
        <a href="index.php"><img src="logo.png" alt="logo"style="max-width: 50px; height: auto;""></a>
        <a href="index.php">Acceuil</a>
        <a href="reserved.php">Reservations</a>
        </div>
        </nav>
EOT; 
} 
/*La fonction template_footer() est communément utilisé dans les 
sites web pour inclure les éléments communs au pied de page 
 de chaque page du site, tels que les liens de navigation 
secondaire, 
 les coordonnées de contact, etc.*/ 
function template_footer() { 
    echo <<<EOT
    </body> 
</html> 
EOT; 
} 
?> 