<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Vérifier que l'ID de contact existe
if (isset($_GET['id'])) {
    // Sélectionnez l'enregistrement qui va être supprimé
    $stmt = $pdo->prepare('SELECT * FROM reservation WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $reserved = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$reserved) {
        exit('Contact doesn\'t exist with that ID!');
    }
    // Assurez-vous que l'utilisateur confirme avant la suppression
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
        // L'utilisateur a cliqué sur le bouton "Oui", supprimer l'enregistrement
        $stmt = $pdo->prepare('DELETE FROM reservation WHERE id = ?');
        $stmt->execute([$_GET['id']]);
        $msg = 'You have deleted the reservation!';
        } 
        else {
        // L'utilisateur a cliqué sur le bouton "Non", le redirige vers la page de lecture
        header('Location: reserved.php');
        exit;
        }
    }
} 
else {
    exit('No ID specified!');
}
?>
<?=template_header('Delete')?>
<script src="control.js"></script>
<div class="content delete">
<h2>Delete Reservation #<?=$reserved['id']?></h2>
<?php if ($msg): ?>
<p><?=$msg?></p>
<?php else: ?>
<p>Are you sure you want to delete contact #<?=$reserved['id']?>?</p>
<div class="yesno">
<a href="annuler.php?id=<?=$reserved['id']?>&confirm=yes">Yes</a>
<a href="annuler.php?id=<?=$reserved['id']?>&confirm=no">No</a>
</div>
<?php endif; ?>
</div>
<?=template_footer()?>