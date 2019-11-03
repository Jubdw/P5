<?php $title = "Modifier votre profil" ?>

<?php ob_start(); ?>
<div class="title title-small">
	<h1>Modifiez votre compte</h1>
	<a href="index.php?action=showProfile&amp;id=<?= $_SESSION['id'] ?>&amp;page=1">Retour au profil</a>
</div>

<div class="edit-profile edit-name">
	<h3>Modifier votre NOM</h3>
	<form action="index.php?action=updateName" method="post">
		<div class="edit-inputs">
			<label for="name">Nouveau nom</label><br>
			<input type ="text" id="name" name="name" /><br>
		</div>
		<div class="submit">
			<input type="submit">
		</div>
	</form>
</div>

<div class="edit-profile edit-email">
	<h3>Modifier votre E-mail</h3>
	<form action="index.php?action=updateEmail" method="post">
		<div class="edit-inputs">
			<label for="email">Nouvelle adresse mail</label><br>
			<input type ="text" id="email" name="email" /><br>
		</div>
		<div class="submit">
			<input type="submit">
		</div>
	</form>
</div>

<div class="edit-profile edit-password">
	<h3>Modifier votre Mot de Passe</h3>
	<form action="index.php?action=updatePassword" method="post">
		<div class="edit-inputs">
			<label for="password">Nouveau mot de passe</label><br>
			<input type ="password" id="password" name="password" /><br>
		</div>
		<div class="edit-inputs">
			<label for="password_check">Répétez le nouveau mot de passe</label><br>
			<input type ="password" id="password_check" name="password_check" /><br>
		</div>
		<div class="submit">
			<input type="submit">
		</div>
	</form>
</div>

<div class="edit-profile edit-avatar">
	<h3>Choisir un Avatar</h3>
	<form action="index.php?action=upload" method="post" enctype="multipart/form-data">
		<div class="edit-inputs">
			<label for="fileUpload">Choisir un fichier</label><br>
			<input type="file" name="avatar" id="fileUpload">
		</div><br>
		<div class="submit">
			<input type="submit"  name="submit" value="Valider">
		</div>
		<p><strong>Note:</strong> Seuls les formats .jpg, .jpeg, .jpeg, .gif, .png sont autorisés jusqu'à une taille maximale de 5 Mo.</p>
	</form>
</div>

<div class="edit-profile edit-signature">
	<h3>Modifier votre Signature</h3>
	<form action="index.php?action=updateSignature" method="post">
		<div class="edit-inputs">
			<label for="signature">Nouvelle Signature</label><br>
			<textarea id="signature" name="signature" rows="8" cols="40"></textarea><br>
		</div>
		<div class="submit">
			<input type="submit">
		</div>
	</form>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>