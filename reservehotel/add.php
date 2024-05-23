<?php
include 'functions.php'; 

$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {
    // Vérification si l'email, le CIN ou le numéro de téléphone existe déjà
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $cin = isset($_POST['cin']) ? $_POST['cin'] : '';
    $tel = isset($_POST['tel']) ? $_POST['tel'] : '';

    $stmt = $pdo->prepare('SELECT * FROM reservation WHERE email = ? OR cin = ? OR tel = ?');
    $stmt->execute([$email, $cin, $tel]);
    $existing_reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_reservation) {
        // Si l'email, le CIN ou le numéro de téléphone existe déjà, afficher un message d'erreur
        $msg = 'Une réservation avec cet email, CIN ou numéro de téléphone existe déjà.';
    } else {
        // Si aucun enregistrement existant trouvé, continuer avec l'ajout de la réservation
        $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] !=
        'auto' ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $cin = isset($_POST['cin']) ? $_POST['cin'] : '';
        $tel = isset($_POST['tel']) ? $_POST['tel'] : '';
        $checkin = isset($_POST['checkin']) ? $_POST['checkin'] : '';
        $checkout = isset($_POST['checkout']) ? $_POST['checkout'] : '';
        $created_at = isset($_POST['created_at']) ? $_POST['created_at'] : date('Y-m-d H:i:s');
        
        // Insertion d'un nouvel enregistrement dans la table reservation
        $stmt = $pdo->prepare('INSERT INTO reservation (name, email, cin, tel, checkin, checkout, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$name, $email, $cin, $tel, $checkin, $checkout, $created_at]);
        
        // Message de sortie
        $msg = 'Créé avec succès!';
    }
}
?>

<?php template_header('Nouvelle Réservation | ENJEZ'); ?>
<div class="newreser">
    <h2>Ajouter une nouvelle réservation : </h2>
    <form action="add.php" method="post">
        <label for="name">Nom Complet :</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="cin">CIN :</label>
        <input type="text" id="cin" name="cin" required><br><br>
        <label for="tel">Téléphone :</label>
        <input type="text" id="tel" name="tel" required><br><br>
        <label for="checkin">Date d'Arrivée :</label>
        <input type="date" id="checkin" name="checkin" required><br><br>
        <label for="checkout">Date de Départ :</label>
        <input type="date" id="checkout" name="checkout" required><br><br>
        <label for="created_at">Date de Création de Réservation :</label>
        <input type="datetime-local" name="created_at" value="<?=date('Y-md\TH:i')?>" id="created_at">
        <input type="submit" value="Confirmer" >
        <input type="button" value="Annuler"onclick="window.location.href = 'index.php';">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>
<?=template_footer()?> 
