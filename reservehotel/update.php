<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// Vérifiez si l'identifiant du contact existe, par exemple update.php?id=1 obtiendra le contact avec l'identifiant 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // Cette partie est similaire à create.php, mais à la place, nous mettons à jour un enregistrement et n'insérons pas
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $cin = isset($_POST['cin']) ? $_POST['cin'] : '';
        $tel = isset($_POST['tel']) ? $_POST['tel'] : '';
        $checkin = isset($_POST['checkin']) ? $_POST['checkin'] : '';
        $checkout = isset($_POST['checkout']) ? $_POST['checkout'] : '';
        $created_at = isset($_POST['created_at']) ? $_POST['created_at'] : date('Y-m-d H:i:s'); // Ajout du point-virgule manquant

        // Update the record
        $stmt = $pdo->prepare('UPDATE reservation SET name = ?, email = ?, cin = ?, tel = ?, checkin = ?, checkout = ?, created_at = ? WHERE id = ?');
        $stmt->execute([$name, $email, $cin, $tel, $checkin, $checkout, $created_at, $_GET['id']]);

        $msg = 'Updated Successfully!';
    }
    // Obtenir le contact à partir du tableau des contacts
    $stmt = $pdo->prepare('SELECT * FROM reservation WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $reserved = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$reserved) {
        exit('Aucune réservation trouvée!'); // Correction de la faute de frappe dans le message
    }
} else {
    exit('Aucun ID spécifié'); // Correction de la faute de frappe dans le message
}
?>


<?php template_header('Modifier'); ?>
<script src="control.js"></script>
<div class="newreser">
    <h2>Modifier une réservation :</h2> <!-- Modification du titre -->
    <form action="update.php?id=<?php echo $_GET['id']; ?>" method="post"> <!-- Modification de l'action du formulaire -->
        <label for="name">Nom Complet :</label>
        <input type="text" id="name" name="name" value="<?php echo isset($reserved['name']) ? $reserved['name'] : ''; ?>" required><br><br>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?php echo isset($reserved['email']) ? $reserved['email'] : ''; ?>" required><br><br>
        <label for="cin">CIN :</label>
        <input type="text" id="cin" name="cin" value="<?php echo isset($reserved['cin']) ? $reserved['cin'] : ''; ?>" required><br><br>
        <label for="tel">Téléphone :</label>
        <input type="text" id="tel" name="tel" value="<?php echo isset($reserved['tel']) ? $reserved['tel'] : ''; ?>" required><br><br>
        <label for="checkin">Date d'Arrivée :</label>
        <input type="date" id="checkin" name="checkin" value="<?php echo isset($reserved['checkin']) ? $reserved['checkin'] : ''; ?>" required><br><br>
        <label for="checkout">Date de Départ :</label>
        <input type="date" id="checkout" name="checkout" value="<?php echo isset($reserved['checkout']) ? $reserved['checkout'] : ''; ?>" required><br><br>
        <label for="created_at">Date de Création de Réservation :</label>
        <input type="datetime-local" name="created_at" value="<?php echo isset($reserved['created_at']) ? date('Y-m-d\TH:i', strtotime($reserved['created_at'])) : date('Y-m-d\TH:i'); ?>" id="created_at"><br><br>
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?php echo $msg; ?></p> <!-- Modification de la façon dont la variable $msg est affichée -->
    <?php endif; ?>
</div>
<?php template_footer(); ?>
