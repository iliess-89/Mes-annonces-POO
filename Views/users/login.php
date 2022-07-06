<?php if(!empty($_SESSION['erreur'])): ?>
<div class="alert alert-danger" role="alert">
<?= $_SESSION['erreur']; unset($_SESSION['erreur']);?>
</div>
<?php endif; ?>
<h1>Connexion</h1>
<?= $loginForm ?>