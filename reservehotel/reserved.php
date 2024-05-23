<?php 
include 'functions.php'; 

$pdo = pdo_connect_mysql(); 

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; 

$stmt = $pdo->prepare('SELECT * FROM reservation ORDER BY id'); 
$stmt->execute(); 

$reserved = $stmt->fetchAll(PDO::FETCH_ASSOC); 

$num_reserved = count($reserved); 
?> 
<?php template_header('Liste des réservations'); ?>

<div class="read"> 
    <h2>RESERVATION : </h2> 
    <a href="add.php" class="newtask">Ajouter une résrvation</a> 
    <table> 
        <thead> 
            <tr> 
                <td>Id</td>
                <td>Nom Complet</td> 
                <td>Email</td> 
                <td>CIN</td>  
                <td>Téléphone</td> 
                <td>Date d'Arrivée</td> 
                <td>Date de Départ</td> 
                <td>Date de Création de Reservation</td>
            </tr> 
        </thead> 
        <tbody> 
            <?php foreach ($reserved as $reserve): ?> 
            <tr> 
                <td><?=$reserve['id']?></td> 
                <td><?=$reserve['name']?></td> 
                <td><?=$reserve['email']?></td> 
                <td><?=$reserve['cin']?></td> 
                <td><?=$reserve['tel']?></td>
                <td><?=$reserve['checkin']?></td> 
                <td><?=$reserve['checkout']?></td> 
                <td><?=$reserve['created_at']?></td> 

                <td class="actions"> 
                    <a href="update.php?id=<?=$reserve['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a> 
                    <a href="annuler.php?id=<?=$reserve['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a> 
                </td> 
            </tr> 
            <?php endforeach; ?> 
        </tbody> 
    </table> 
    <div class="pagination"> 
        <?php if ($page > 1): ?> 
        <a href="reserved.php?page=<?=$page-1?>"><i class="fas fa-angle-double left fa-sm"></i></a> 
        <?php endif; ?> 
        <?php if ($page*$num_reserved < $num_reserved): ?> 
        <a href="reserved.php?page=<?=$page+1?>"><i class="fas fa-angle-double right fa-sm"></i></a>
        <?php endif; ?> 
    </div> 
</div> 
<?=template_footer()?> 
